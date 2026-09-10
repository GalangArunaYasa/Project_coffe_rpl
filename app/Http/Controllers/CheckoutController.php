<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Keranjang belanja Anda masih kosong. Silakan pilih menu terlebih dahulu.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['harga'] * $item['jumlah'];
        }

        return view('checkout.index', compact('cart', 'subtotal'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Keranjang belanja Anda masih kosong.');
        }

        $request->validate([
            'nama_pemesan' => 'required|string|max:100',
            'nomor_kontak' => 'required|string|max:20',
            'tipe_pesanan' => 'required|in:dine_in,takeaway,delivery',
            'catatan_alamat' => 'nullable|string|max:255',
            'metode_pembayaran' => 'required|in:cash,qris,transfer',
            'catatan_pesanan' => 'nullable|string|max:255',
        ]);

        // Verifikasi ketersediaan stok produk terkini
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if (!$product || $product->stok < $item['jumlah']) {
                $stokAda = $product ? $product->stok : 0;
                return redirect()->route('cart.index')->with('error', 'Maaf, stok ' . $item['nama'] . ' tidak mencukupi (Tersisa: ' . $stokAda . ' pcs). Silakan sesuaikan jumlah pesanan Anda.');
            }
        }

        DB::beginTransaction();
        try {
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['harga'] * $item['jumlah'];
            }

            $ongkir = ($request->tipe_pesanan === 'delivery') ? 5000 : 0;
            $totalHarga = $subtotal + $ongkir;

            // Generate kode unik pesanan, misal: ARU-20260910-8A3F
            $orderCode = 'ARU-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

            $order = Order::create([
                'order_code' => $orderCode,
                'user_id' => Auth::id(), // null jika tamu belum login
                'tipe_pesanan' => $request->tipe_pesanan,
                'status' => 'menunggu_konfirmasi',
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => ($request->metode_pembayaran === 'cash') ? 'unpaid' : 'unpaid',
                'subtotal' => $subtotal,
                'ongkir' => $ongkir,
                'total_harga' => $totalHarga,
                'nama_pemesan' => $request->nama_pemesan,
                'nomor_kontak' => $request->nomor_kontak,
                'catatan_alamat' => $request->catatan_alamat,
                'catatan_pesanan' => $request->catatan_pesanan,
            ]);

            // Buat order items & potong stok produk
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'nama_produk' => $item['nama'],
                    'harga_satuan' => $item['harga'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['harga'] * $item['jumlah'],
                    'ukuran' => $item['ukuran'] ?? 'Reguler',
                    'suhu' => $item['suhu'] ?? 'Es',
                    'manis' => $item['manis'] ?? 'Normal',
                    'catatan_khusus' => $item['catatan'] ?? null,
                ]);

                // Kurangi stok produk
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->decrement('stok', $item['jumlah']);
                }
            }

            DB::commit();

            // Kosongkan keranjang
            session()->forget('cart');

            return redirect()->route('order.track', $order->order_code)->with('success', 'Pesanan berhasil dibuat! Silakan pantau status pesanan Anda di bawah ini.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage())->withInput();
        }
    }
}
