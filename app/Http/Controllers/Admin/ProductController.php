<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\RestockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->get('cari');
        $kategori = $request->get('kategori');

        $query = Product::latest();

        if ($cari) {
            $query->where('nama', 'like', '%' . $cari . '%');
        }

        if ($kategori && $kategori !== 'semua') {
            $query->where('kategori', $kategori);
        }

        $products = $query->paginate(10)->withQueryString();
        return view('admin.products.index', compact('products', 'cari', 'kategori'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|in:kopi,non-kopi,signature,snack',
            'tag' => 'nullable|string|max:50',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['nama', 'deskripsi', 'harga', 'stok', 'kategori', 'tag']);
        $data['is_bestseller'] = $request->has('is_bestseller');
        $data['is_active'] = $request->has('is_active') ? true : true;

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product = Product::create($data);

        // Catat stok awal ke RestockLog jika stok > 0
        if ($product->stok > 0) {
            RestockLog::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'jumlah' => $product->stok,
                'stok_sebelumnya' => 0,
                'stok_sesudahnya' => $product->stok,
                'sumber' => 'admin_manual',
                'catatan' => 'Stok awal saat penambahan produk baru.',
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk "' . $product->nama . '" berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|in:kopi,non-kopi,signature,snack',
            'tag' => 'nullable|string|max:50',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $oldStok = $product->stok;
        $newStok = (int)$request->stok;

        $data = $request->only(['nama', 'deskripsi', 'harga', 'stok', 'kategori', 'tag']);
        $data['is_bestseller'] = $request->has('is_bestseller');
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('gambar')) {
            if ($product->gambar && Storage::disk('public')->exists($product->gambar)) {
                Storage::disk('public')->delete($product->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product->update($data);

        // Catat log jika stok berubah secara manual
        if ($newStok !== $oldStok) {
            RestockLog::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'jumlah' => $newStok - $oldStok,
                'stok_sebelumnya' => $oldStok,
                'stok_sesudahnya' => $newStok,
                'sumber' => 'admin_manual',
                'catatan' => 'Penyesuaian stok manual melalui form edit produk.',
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk "' . $product->nama . '" berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->gambar && Storage::disk('public')->exists($product->gambar)) {
            Storage::disk('public')->delete($product->gambar);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    // Toggle Cepat Status Best Seller
    public function toggleBestseller(Product $product)
    {
        $product->update([
            'is_bestseller' => !$product->is_bestseller
        ]);

        $status = $product->is_bestseller ? 'Best Seller' : 'Biasa';
        return back()->with('success', 'Status produk ' . $product->nama . ' diubah menjadi ' . $status . '.');
    }

    // Restok Cepat dari Baris Tabel
    public function quickRestock(Request $request, Product $product)
    {
        $request->validate([
            'tambah_stok' => 'required|integer|min:1'
        ]);

        $tambah = (int)$request->tambah_stok;
        $oldStok = $product->stok;
        $newStok = $oldStok + $tambah;

        $product->update(['stok' => $newStok]);

        RestockLog::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'jumlah' => $tambah,
            'stok_sebelumnya' => $oldStok,
            'stok_sesudahnya' => $newStok,
            'sumber' => 'admin_manual',
            'catatan' => 'Restok cepat via tombol admin (+ ' . $tambah . ' pcs).',
        ]);

        return back()->with('success', 'Stok untuk ' . $product->nama . ' berhasil ditambah ' . $tambah . ' pcs. Total stok sekarang: ' . $newStok . ' pcs.');
    }
}