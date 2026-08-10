@extends('layouts.admin')

@section('content')
<h2 class="mb-4">Dashboard Monitoring Admin</h2>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card bg-primary text-white p-3 shadow-sm rounded-3">
            <h5>Total Produk Menu</h5>
            <h2 class="fw-bold mb-0">{{ $totalProduk }}</h2>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-warning text-dark p-3 shadow-sm rounded-3">
            <h5>Peringatan Stok Tipis (≤ 5 Pcs)</h5>
            <h2 class="fw-bold mb-0">{{ $stokTipis->count() }}</h2>
        </div>
    </div>
</div>

<div class="card shadow-sm rounded-3">
    <div class="card-header bg-white fw-bold">Daftar Menu yang Perlu Diisi Ulang Stoknya</div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Sisa Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stokTipis as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td><span class="badge bg-secondary">{{ ucfirst($item->kategori) }}</span></td>
                    <td><span class="badge bg-danger">{{ $item->stok }} Pcs</span></td>
                    <td>
                        <a href="{{ route('admin.products.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">Tambah Stok</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-3 text-muted">Semua stok produk aman 👍</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection