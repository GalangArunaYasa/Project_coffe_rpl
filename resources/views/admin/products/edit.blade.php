@extends('layouts.admin')

@section('title', 'Edit Menu: ' . $product->nama . ' - Admin Aruna Coffee')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.products.index') }}" class="btn btn-kg-outline btn-sm rounded-pill px-3 mb-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Menu
    </a>
    <span class="badge rounded-pill px-3 py-1 mb-2 d-block w-fit" style="background-color: var(--kg-surface-light); border: 1px solid var(--kg-accent); color: var(--kg-gold); font-size: 0.8rem; width: fit-content;">
        <i class="bi bi-pencil-square me-1"></i> Edit Menu
    </span>
    <h1 class="h3 fw-extrabold text-white mb-1">Edit Menu: {{ $product->nama }}</h1>
    <p class="text-muted mb-0">Perbarui rincian produk, harga jual, foto, dan ketersediaan stok fisik.</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="adm-card p-4 p-md-5 shadow-sm">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label text-white small fw-bold">Nama Menu Produk <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control kg-search-input rounded-3 py-2" value="{{ old('nama', $product->nama) }}" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-white small fw-bold">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori" class="form-select kg-search-input rounded-3 py-2" required>
                            <option value="signature" @selected(old('kategori', $product->kategori) === 'signature')>Signature</option>
                            <option value="kopi" @selected(old('kategori', $product->kategori) === 'kopi')>Kopi / Espresso</option>
                            <option value="non-kopi" @selected(old('kategori', $product->kategori) === 'non-kopi')>Non Kopi</option>
                            <option value="snack" @selected(old('kategori', $product->kategori) === 'snack')>Snack & Roti</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-white small fw-bold">Tag / Label (Opsional)</label>
                        <input type="text" name="tag" class="form-control kg-search-input rounded-3 py-2" value="{{ old('tag', $product->tag) }}" placeholder="Contoh: Favorit, Baru, Renyah">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-white small fw-bold">Harga Jual (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="harga" class="form-control kg-search-input rounded-3 py-2" value="{{ old('harga', $product->harga) }}" min="0" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-white small fw-bold">Sisa Stok (Pcs) <span class="text-danger">*</span></label>
                        <input type="number" name="stok" class="form-control kg-search-input rounded-3 py-2" value="{{ old('stok', $product->stok) }}" min="0" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-white small fw-bold">Deskripsi Menu</label>
                    <textarea name="deskripsi" class="form-control kg-search-input rounded-3" rows="3">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label text-white small fw-bold">Foto Produk</label>
                    @if($product->gambar)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" width="100" height="100" class="rounded-3 object-fit-cover border" style="border-color: var(--kg-border) !important;">
                        </div>
                    @endif
                    <input type="file" name="gambar" class="form-control kg-search-input rounded-3" accept="image/*">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto saat ini.</small>
                </div>

                <div class="mb-4 d-flex gap-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_bestseller" id="is_bestseller" value="1" @checked(old('is_bestseller', $product->is_bestseller))>
                        <label class="form-check-label text-white small fw-bold" for="is_bestseller">Best Seller</label>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', $product->is_active))>
                        <label class="form-check-label text-white small fw-bold" for="is_active">Aktif (Tampil di Menu)</label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-kg-accent rounded-pill px-5 py-3 fw-bold shadow">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-kg-outline rounded-pill px-4 py-3">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection