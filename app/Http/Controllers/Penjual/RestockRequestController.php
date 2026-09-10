<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\RestockRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestockRequestController extends Controller
{
    public function index()
    {
        $products = Product::active()->orderBy('stok', 'asc')->get();
        $stokKritis = Product::active()->where('stok', '<=', 5)->get();

        $requests = RestockRequest::with(['product', 'admin'])
            ->where('penjual_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('penjual.restock.index', compact('products', 'stokKritis', 'requests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'jumlah_diminta' => 'required|integer|min:1',
            'alasan' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);

        RestockRequest::create([
            'product_id' => $product->id,
            'penjual_id' => Auth::id(),
            'jumlah_diminta' => $request->jumlah_diminta,
            'alasan' => $request->alasan ?? 'Stok fisik di gerobak/toko hampir habis.',
            'status' => 'pending',
        ]);

        return redirect()->route('penjual.restock.index')->with('success', 'Permintaan restok untuk ' . $product->nama . ' sebanyak ' . $request->jumlah_diminta . ' pcs berhasil diajukan ke Admin!');
    }
}
