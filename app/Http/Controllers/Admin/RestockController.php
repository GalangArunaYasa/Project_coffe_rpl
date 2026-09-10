<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\RestockLog;
use App\Models\RestockRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RestockController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('stok', 'asc')->get();
        $stokKritis = Product::where('stok', '<=', 5)->get();

        $logs = RestockLog::with(['product', 'user'])
            ->latest()
            ->paginate(15);

        return view('admin.restocks.index', compact('products', 'stokKritis', 'logs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'jumlah' => 'required|integer|min:1',
            'catatan' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);
        $oldStok = $product->stok;
        $tambah = (int)$request->jumlah;
        $newStok = $oldStok + $tambah;

        DB::beginTransaction();
        try {
            $product->update(['stok' => $newStok]);

            RestockLog::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'jumlah' => $tambah,
                'stok_sebelumnya' => $oldStok,
                'stok_sesudahnya' => $newStok,
                'sumber' => 'admin_manual',
                'catatan' => $request->catatan ?? 'Pengadaan / Restok stok reguler oleh Admin.',
            ]);

            DB::commit();
            return redirect()->route('admin.restocks.index')->with('success', 'Berhasil merestok ' . $product->nama . ' sebanyak ' . $tambah . ' pcs! Total stok saat ini: ' . $newStok . ' pcs.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses restok: ' . $e->getMessage());
        }
    }

    public function requests()
    {
        $requests = RestockRequest::with(['product', 'penjual', 'admin'])
            ->latest()
            ->paginate(15);

        $pendingCount = RestockRequest::where('status', 'pending')->count();

        return view('admin.restocks.requests', compact('requests', 'pendingCount'));
    }

    public function approveRequest(Request $request, RestockRequest $restockRequest)
    {
        if ($restockRequest->status !== 'pending') {
            return back()->with('error', 'Permintaan restok ini sudah pernah diproses sebelumnya.');
        }

        $product = $restockRequest->product;
        $tambah = $restockRequest->jumlah_diminta;
        $oldStok = $product->stok;
        $newStok = $oldStok + $tambah;

        DB::beginTransaction();
        try {
            // Tambahkan stok produk
            $product->update(['stok' => $newStok]);

            // Catat ke log
            RestockLog::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'jumlah' => $tambah,
                'stok_sebelumnya' => $oldStok,
                'stok_sesudahnya' => $newStok,
                'sumber' => 'approval_request',
                'catatan' => 'Persetujuan permintaan restok dari kasir/penjual (' . ($restockRequest->penjual ? $restockRequest->penjual->name : 'Staff') . '). Catatan: ' . ($request->catatan_admin ?? 'Disetujui.'),
            ]);

            // Update status request
            $restockRequest->update([
                'status' => 'disetujui',
                'admin_id' => Auth::id(),
                'catatan_admin' => $request->catatan_admin ?? 'Disetujui oleh Admin.',
            ]);

            DB::commit();
            return back()->with('success', 'Permintaan restok untuk ' . $product->nama . ' disetujui! Stok otomatis bertambah ' . $tambah . ' pcs.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses persetujuan restok: ' . $e->getMessage());
        }
    }

    public function rejectRequest(Request $request, RestockRequest $restockRequest)
    {
        if ($restockRequest->status !== 'pending') {
            return back()->with('error', 'Permintaan restok ini sudah pernah diproses sebelumnya.');
        }

        $restockRequest->update([
            'status' => 'ditolak',
            'admin_id' => Auth::id(),
            'catatan_admin' => $request->catatan_admin ?? 'Maaf, permintaan restok belum dapat dipenuhi saat ini.',
        ]);

        return back()->with('success', 'Permintaan restok berhasil ditolak.');
    }
}
