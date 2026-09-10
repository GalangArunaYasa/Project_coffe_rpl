<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->get('kategori', 'semua');
        $cari = $request->get('cari');

        $query = Product::active();

        if ($kategori !== 'semua') {
            $query->where('kategori', $kategori);
        }

        if ($cari) {
            $query->where('nama', 'like', '%' . $cari . '%');
        }

        $products = $query->orderBy('nama')->get();

        $kategoriList = [
            ['id' => 'semua', 'label' => 'Semua'],
            ['id' => 'signature', 'label' => 'Signature'],
            ['id' => 'kopi', 'label' => 'Kopi'],
            ['id' => 'non-kopi', 'label' => 'Non Kopi'],
            ['id' => 'snack', 'label' => 'Snack'],
        ];

        return view('penjual.pos.index', compact('products', 'kategoriList', 'kategori', 'cari'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:100',
            'metode_pembayaran' => 'required|in:cash,qris,transfer',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.ukuran' => 'nullable|string',
            'items.*.suhu' => 'nullable|string',
            'items.*.manis' => 'nullable|string',
            'items.*.catatan' => 'nullable|string',
            'uang_diterima' => 'nullable|numeric|min:0',
        ]);

        $itemsData = $request->items;

        // Validasi stok
        foreach ($itemsData as $item) {
            $product = Product::find($item['product_id']);
            if (!$product || $product->stok < $item['jumlah']) {
                $stok = $product ? $product->stok : 0;
                return response()->json([
                    'success' => false,
                    'message' => 'Stok produk ' . ($product ? $product->nama : 'Item') . ' tidak mencukupi (Tersisa: ' . $stok . ' pcs).'
                ], 422);
            }
        }

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $itemsToCreate = [];

            foreach ($itemsData as $item) {
                $product = Product::findOrFail($item['product_id']);
                $ukuran = $item['ukuran'] ?? 'Reguler';
                $harga = $product->harga;
                if (strtolower($ukuran) === 'large') {
                    $harga += 3000;
                }

                $itemSubtotal = $harga * $item['jumlah'];
                $subtotal += $itemSubtotal;

                $itemsToCreate[] = [
                    'product_id' => $product->id,
                    'nama_produk' => $product->nama,
                    'harga_satuan' => $harga,
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $itemSubtotal,
                    'ukuran' => $ukuran,
                    'suhu' => $item['suhu'] ?? 'Es',
                    'manis' => $item['manis'] ?? 'Normal',
                    'catatan_khusus' => $item['catatan'] ?? null,
                ];
            }

            $orderCode = 'POS-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
            $uangDiterima = $request->uang_diterima ? (int)$request->uang_diterima : $subtotal;
            $uangKembalian = max(0, $uangDiterima - $subtotal);

            $order = Order::create([
                'order_code' => $orderCode,
                'user_id' => null, // Penjualan kasir langsung
                'penjual_id' => Auth::id(),
                'tipe_pesanan' => 'dine_in',
                'status' => 'selesai', // Transaksi kasir langsung langsung selesai
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => 'paid',
                'subtotal' => $subtotal,
                'ongkir' => 0,
                'total_harga' => $subtotal,
                'uang_diterima' => $uangDiterima,
                'uang_kembalian' => $uangKembalian,
                'nama_pemesan' => $request->nama_pemesan,
                'nomor_kontak' => $request->nomor_kontak ?? '-',
                'catatan_pesanan' => 'Transaksi Kasir POS Walk-in',
            ]);

            foreach ($itemsToCreate as $it) {
                $it['order_id'] = $order->id;
                OrderItem::create($it);

                // Potong stok
                Product::where('id', $it['product_id'])->decrement('stok', $it['jumlah']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi kasir berhasil disimpan!',
                'order' => $order->load('items'),
                'receipt_url' => route('order.receipt', $order->order_code)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses transaksi: ' . $e->getMessage()
            ], 500);
        }
    }
}
