<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['harga'] * $item['jumlah'];
        }

        $ongkir = 0; // Default takeaway / dine-in
        $total = $subtotal + $ongkir;

        $rekomendasi = Product::active()->where('is_bestseller', true)->take(4)->get();

        return view('cart.index', compact('cart', 'subtotal', 'ongkir', 'total', 'rekomendasi'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'jumlah' => 'nullable|integer|min:1',
            'ukuran' => 'nullable|string',
            'suhu' => 'nullable|string',
            'manis' => 'nullable|string',
            'tambahan' => 'nullable|string',
            'catatan' => 'nullable|string|max:200',
            'action_type' => 'nullable|string|in:add_cart,buy_now',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stok <= 0) {
            return back()->with('error', 'Maaf, stok ' . $product->nama . ' saat ini sedang habis.');
        }

        $jumlah = max(1, (int)$request->input('jumlah', 1));
        $ukuran = $request->input('ukuran', 'Reguler');
        $suhu = $request->input('suhu', 'Es');
        $manis = $request->input('manis', 'Normal');
        $tambahan = $request->input('tambahan', '');
        $catatan = $request->input('catatan', '');
        $actionType = $request->input('action_type', 'add_cart');

        // Hitung penyesuaian harga berdasarkan ukuran & varian tambahan
        $harga = $product->harga;
        if (strtolower($ukuran) === 'large') {
            $harga += 3000;
        }
        if (!empty($tambahan) && (str_contains(strtolower($tambahan), 'oat') || str_contains(strtolower($tambahan), 'keju') || str_contains(strtolower($tambahan), 'topping'))) {
            $harga += 4000;
        }

        $cartKey = md5($product->id . '_' . $ukuran . '_' . $suhu . '_' . $manis . '_' . $tambahan . '_' . $catatan);

        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $totalJumlah = $cart[$cartKey]['jumlah'] + $jumlah;
            if ($totalJumlah > $product->stok) {
                return back()->with('error', 'Jumlah pesanan melebihi sisa stok yang tersedia (' . $product->stok . ' pcs).');
            }
            $cart[$cartKey]['jumlah'] = $totalJumlah;
        } else {
            if ($jumlah > $product->stok) {
                return back()->with('error', 'Jumlah pesanan melebihi sisa stok yang tersedia (' . $product->stok . ' pcs).');
            }
            $cart[$cartKey] = [
                'key' => $cartKey,
                'product_id' => $product->id,
                'nama' => $product->nama,
                'gambar' => $product->gambar,
                'kategori' => $product->kategori,
                'harga' => $harga,
                'harga_dasar' => $product->harga,
                'jumlah' => $jumlah,
                'ukuran' => $ukuran,
                'suhu' => $suhu,
                'manis' => $manis,
                'tambahan' => $tambahan,
                'catatan' => $catatan,
                'stok_maks' => $product->stok,
            ];
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $product->nama . ' berhasil ditambahkan ke pesanan!',
                'cart_count' => count(session()->get('cart', []))
            ]);
        }

        if ($actionType === 'buy_now') {
            return redirect()->route('checkout.index')->with('success', 'Silakan lengkapi data pembayaran untuk ' . $product->nama . '!');
        }

        return back()->with('success', '✓ ' . $product->nama . ' (' . $jumlah . 'x) berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $key)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            $action = $request->input('action'); // 'plus' or 'minus'
            $product = Product::find($cart[$key]['product_id']);

            if ($action === 'plus') {
                if ($product && $cart[$key]['jumlah'] >= $product->stok) {
                    return back()->with('error', 'Jumlah melebihi stok yang tersedia (' . $product->stok . ' pcs).');
                }
                $cart[$key]['jumlah']++;
            } elseif ($action === 'minus') {
                $cart[$key]['jumlah']--;
                if ($cart[$key]['jumlah'] <= 0) {
                    unset($cart[$key]);
                }
            }

            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Keranjang belanja berhasil diperbarui.');
    }

    public function remove($key)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Menu berhasil dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Semua item di keranjang telah dikosongkan.');
    }
}
