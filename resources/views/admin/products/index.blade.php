@extends('layouts.admin')

@section('title', 'Kelola Menu & Produk - Admin Aruna Coffee')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <span class="badge rounded-pill px-3 py-1 mb-2" style="background-color: var(--kg-surface-light); border: 1px solid var(--kg-accent); color: var(--kg-gold); font-size: 0.8rem;">
            <i class="bi bi-cup-hot me-1"></i> Manajemen Master Menu
        </span>
        <h1 class="h3 fw-extrabold text-white mb-1">
            Daftar Menu & Stok Produk
        </h1>
        <p class="text-muted mb-0">Kelola daftar menu kopi, harga satuan, ketersediaan stok fisik, dan status Best Seller.</p>
    </div>

    <a href="{{ route('admin.products.create') }}" class="btn btn-kg-accent rounded-pill px-4 py-2 fw-bold d-flex align-items-center gap-2 shadow">
        <i class="bi bi-plus-lg fs-5"></i> Tambah Menu Baru
    </a>
</div>

<!-- Search & Filter Card -->
<div class="adm-card p-3 mb-4 shadow-sm">
    <form action="{{ route('admin.products.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-5">
            <div class="input-group input-group-sm">
                <span class="input-group-text kg-search-input border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="cari" value="{{ $cari }}" class="form-control form-control-sm kg-search-input border-start-0" placeholder="Cari nama produk, deskripsi, tag...">
            </div>
        </div>
        <div class="col-md-3">
            <select name="kategori" class="form-select form-select-sm kg-search-input rounded-3">
                <option value="semua">Semua Kategori</option>
                <option value="signature" @selected($kategori === 'signature')>Signature</option>
                <option value="kopi" @selected($kategori === 'kopi')>Kopi</option>
                <option value="non-kopi" @selected($kategori === 'non-kopi')>Non Kopi</option>
                <option value="snack" @selected($kategori === 'snack')>Snack</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-kg-accent btn-sm rounded-pill px-3 fw-bold">Cari</button>
            @if($cari || ($kategori && $kategori !== 'semua'))
                <a href="{{ route('admin.products.index') }}" class="btn btn-kg-outline btn-sm rounded-pill px-3">Reset</a>
            @endif
        </div>
    </form>
</div>

<!-- Products Table -->
<div class="adm-card p-4 shadow-sm mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 70px;">Foto</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Sisa Stok</th>
                    <th>Best Seller</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            @if($product->gambar)
                                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" width="56" height="56" class="rounded-3 object-fit-cover shadow-sm">
                            @else
                                <img src="https://images.unsplash.com/photo-1541167760496-1628856ab772?w=100&auto=format&fit=crop&q=80" alt="{{ $product->nama }}" width="56" height="56" class="rounded-3 object-fit-cover shadow-sm">
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-white fs-6">{{ $product->nama }}</div>
                            @if($product->tag)
                                <span class="badge bg-dark border border-secondary text-warning" style="font-size: 0.65rem;">{{ $product->tag }}</span>
                            @endif
                            @if(!$product->is_active)
                                <span class="badge bg-danger" style="font-size: 0.65rem;">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary text-uppercase fw-semibold">{{ $product->kategori }}</span>
                        </td>
                        <td class="fw-bold text-white">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($product->stok <= 0)
                                    <span class="badge bg-danger rounded-pill px-3 py-1 fw-bold">Habis (0)</span>
                                @elseif($product->stok <= 5)
                                    <span class="badge bg-danger rounded-pill px-3 py-1 fw-bold">{{ $product->stok }} pcs (Kritis)</span>
                                @else
                                    <span class="badge bg-success rounded-pill px-3 py-1 fw-bold">{{ $product->stok }} pcs</span>
                                @endif

                                <!-- Quick Restock Modal Trigger -->
                                <button type="button" class="btn btn-kg-outline btn-sm rounded-circle py-0 px-2 text-warning" data-bs-toggle="modal" data-bs-target="#quickRestockModal{{ $product->id }}" title="Restok Cepat">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                        </td>
                        <td>
                            <form action="{{ route('admin.products.toggleBestseller', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm rounded-pill px-3 {{ $product->is_bestseller ? 'btn-kg-accent text-white fw-bold' : 'btn-kg-outline text-muted' }}">
                                    <i class="bi {{ $product->is_bestseller ? 'bi-star-fill text-warning' : 'bi-star' }} me-1"></i>
                                    {{ $product->is_bestseller ? 'Best Seller' : 'Biasa' }}
                                </button>
                            </form>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-kg-outline btn-sm rounded-pill px-3">
                                    <i class="bi bi-pencil me-1 text-warning"></i> Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu {{ $product->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-kg-outline btn-sm rounded-circle text-danger" title="Hapus Menu">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Quick Restock -->
                    <div class="modal fade" id="quickRestockModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content text-white">
                                <form action="{{ route('admin.products.quickRestock', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-header border-bottom">
                                        <h5 class="modal-title fw-bold text-warning">
                                            <i class="bi bi-box-seam me-2"></i> Restok Cepat: {{ $product->nama }}
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="mb-3">
                                            <label class="text-muted small d-block">Stok Saat Ini:</label>
                                            <span class="fs-4 fw-bold text-white">{{ $product->stok }} Pcs</span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-white small fw-semibold">Jumlah Tambahan Stok (Pcs) <span class="text-danger">*</span></label>
                                            <input type="number" name="tambah_stok" class="form-control kg-search-input rounded-3" value="20" min="1" required>
                                        </div>
                                        <small class="text-muted">Aksi ini akan langsung menambah angka stok produk dan mencatatnya ke log audit restok.</small>
                                    </div>
                                    <div class="modal-footer border-top">
                                        <button type="button" class="btn btn-kg-outline rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-kg-accent rounded-pill px-4 fw-bold">
                                            Tambah Stok Sekarang
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            Belum ada produk. Silakan klik tombol "Tambah Menu Baru" di atas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>

@endsection