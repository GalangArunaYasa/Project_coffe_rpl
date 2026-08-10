@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Kelola Menu & Stok</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i> Tambah Menu Baru</a>
</div>

<div class="card shadow-sm rounded-3">
    <div class="card-body p-0">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Gambar</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Best Seller?</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        @if($product->gambar)
                            <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" width="50" height="50" class="rounded object-fit-cover">
                        @else
                            <span class="text-muted small">Tanpa Gambar</span>
                        @endif
                    </td>
                    <td class="fw-bold">{{ $product->nama }}</td>
                    <td><span class="badge bg-info text-dark">{{ ucfirst($product->kategori) }}</span></td>
                    <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td>
                        @if($product->stok <= 5)
                            <span class="badge bg-danger">{{ $product->stok }} (Kritis)</span>
                        @else
                            <span class="badge bg-success">{{ $product->stok }}</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.products.toggleBestseller', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $product->is_bestseller ? 'btn-warning' : 'btn-outline-secondary' }}">
                                <i class="bi {{ $product->is_bestseller ? 'bi-star-fill' : 'bi-star' }}"></i>
                                {{ $product->is_bestseller ? 'Best Seller' : 'Biasa' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">Belum ada produk. Klik tombol "Tambah Menu Baru" di atas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $products->links() }}
</div>
@endsection