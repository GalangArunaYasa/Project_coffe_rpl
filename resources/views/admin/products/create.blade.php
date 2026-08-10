@extends('layouts.admin')

@section('content')
<h2 class="mb-4">Tambah Menu Kopi Baru</h2>

<div class="card shadow-sm rounded-3">
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Menu</label>
                <input type="text" name="nama" class="form-control" required placeholder="Contoh: Kopi Susu Gula Aren">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-select" required>
                        <option value="kopi">Kopi</option>
                        <option value="non-kopi">Non Kopi</option>
                        <option value="signature">Signature</option>
                        <option value="snack">Snack</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tag (Opsional)</label>
                    <input type="text" name="tag" class="form-control" placeholder="Contoh: Best Seller / Promo">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="harga" class="form-control" required placeholder="15000">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah Stok Perdana</label>
                    <input type="number" name="stok" class="form-control" value="20" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi rasa atau bahan..."></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Foto Produk</label>
                <input type="file" name="gambar" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Menu</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection