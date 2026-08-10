@extends('layouts.admin')

@section('content')
<h2 class="mb-4">Edit Menu / Update Stok</h2>

<div class="card shadow-sm rounded-3">
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Menu</label>
                <input type="text" name="nama" class="form-control" value="{{ $product->nama }}" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-select" required>
                        <option value="kopi" {{ $product->kategori == 'kopi' ? 'selected' : '' }}>Kopi</option>
                        <option value="non-kopi" {{ $product->kategori == 'non-kopi' ? 'selected' : '' }}>Non Kopi</option>
                        <option value="signature" {{ $product->kategori == 'signature' ? 'selected' : '' }}>Signature</option>
                        <option value="snack" {{ $product->kategori == 'snack' ? 'selected' : '' }}>Snack</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tag</label>
                    <input type="text" name="tag" class="form-control" value="{{ $product->tag }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="harga" class="form-control" value="{{ $product->harga }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah Stok</label>
                    <input type="number" name="stok" class="form-control" value="{{ $product->stok }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ $product->deskripsi }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Ganti Foto Produk (Biarkan kosong jika tidak diganti)</label>
                <input type="file" name="gambar" class="form-control">
                @if($product->gambar)
                    <div class="mt-2">
                        <small class="text-muted">Foto saat ini:</small><br>
                        <img src="{{ asset('storage/' . $product->gambar) }}" width="100" class="rounded mt-1">
                    </div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Perbarui Produk</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection