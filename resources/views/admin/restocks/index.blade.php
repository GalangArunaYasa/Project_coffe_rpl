@extends('layouts.admin')

@section('title', 'Manajemen Restok & Log Pengadaan - Admin Aruna Coffee')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <span class="badge rounded-pill px-3 py-1 mb-2" style="background-color: var(--kg-surface-light); border: 1px solid var(--kg-accent); color: var(--kg-gold); font-size: 0.8rem;">
            <i class="bi bi-box-seam me-1"></i> Logistik & Pengadaan Stok
        </span>
        <h1 class="h3 fw-extrabold text-white mb-1">
            Manajemen Restok & Log Pengadaan Stok
        </h1>
        <p class="text-muted mb-0">Lakukan restok produk secara manual dan pantau seluruh riwayat audit kartu stok produk kafe.</p>
    </div>

    <a href="{{ route('admin.restocks.requests') }}" class="btn btn-kg-accent rounded-pill px-4 py-2 fw-bold d-flex align-items-center gap-2 shadow">
        <i class="bi bi-check2-circle fs-5"></i> Permintaan Restok dari Penjual
    </a>
</div>

<div class="row g-4 mb-4">
    
    <!-- Form Restok Manual Admin -->
    <div class="col-lg-5">
        <div class="adm-card p-4 shadow-sm h-100">
            <h2 class="h5 fw-bold text-white mb-3">
                <i class="bi bi-plus-circle-fill text-warning me-1"></i> Form Input Restok Baru
            </h2>

            <form action="{{ route('admin.restocks.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label text-white small fw-bold">Pilih Menu Produk <span class="text-danger">*</span></label>
                    <select name="product_id" class="form-select kg-search-input rounded-3 py-2" required>
                        <option value="">-- Pilih Produk yang akan Diisi Ulang --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" @selected($p->stok <= 5)>
                                {{ $p->nama }} (Sisa Stok: {{ $p->stok }} pcs)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-white small fw-bold">Jumlah Tambahan Stok (Pcs) <span class="text-danger">*</span></label>
                    <input type="number" name="jumlah" class="form-control kg-search-input rounded-3 py-2" placeholder="Contoh: 25" min="1" required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-white small fw-bold">Catatan Pengadaan / Sumber Bahan</label>
                    <textarea name="catatan" class="form-control kg-search-input rounded-3" rows="3" placeholder="Contoh: Pengadaan bahan biji kopi robusta supplier lokal"></textarea>
                </div>

                <button type="submit" class="btn btn-kg-accent w-100 rounded-pill py-3 fw-bold shadow">
                    <i class="bi bi-box-arrow-in-down me-1"></i> Simpan & Update Stok
                </button>
            </form>
        </div>
    </div>

    <!-- Sisa Stok Produk Live -->
    <div class="col-lg-7">
        <div class="adm-card p-4 shadow-sm h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h5 fw-bold text-white mb-0">
                    <i class="bi bi-graph-up-arrow text-info me-1"></i> Ketersediaan Stok Menu Real-time
                </h2>
                <span class="badge bg-secondary rounded-pill px-3 py-1">{{ $products->count() }} Menu</span>
            </div>

            <div class="table-responsive overflow-auto" style="max-height: 380px;">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Status Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $prod)
                            <tr>
                                <td class="fw-bold text-white">{{ $prod->nama }}</td>
                                <td><span class="badge bg-secondary text-uppercase">{{ $prod->kategori }}</span></td>
                                <td class="text-white">Rp {{ number_format($prod->harga, 0, ',', '.') }}</td>
                                <td>
                                    @if($prod->stok <= 0)
                                        <span class="badge bg-danger rounded-pill px-3 py-1 fw-bold">Habis (0)</span>
                                    @elseif($prod->stok <= 5)
                                        <span class="badge bg-danger rounded-pill px-3 py-1 fw-bold">{{ $prod->stok }} pcs (Kritis)</span>
                                    @else
                                        <span class="badge bg-success rounded-pill px-3 py-1 fw-bold">{{ $prod->stok }} pcs</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Stock Audit Logs Table -->
<div class="adm-card p-4 shadow-sm">
    <h2 class="h5 fw-bold text-white mb-3">
        <i class="bi bi-clock-history text-success me-1"></i> Log Riwayat Audit Kartu Stok (Stock Logs)
    </h2>

    @if($logs->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Waktu Log</th>
                        <th>Produk</th>
                        <th>Admin / Pengubah</th>
                        <th class="text-center">Perubahan Jumlah</th>
                        <th class="text-center">Sebelum -> Sesudah</th>
                        <th>Sumber</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>
                                <span class="text-white d-block fw-semibold">{{ $log->created_at->translatedFormat('d M Y') }}</span>
                                <small class="text-muted">{{ $log->created_at->format('H:i') }} WIB</small>
                            </td>
                            <td class="fw-bold text-white">{{ $log->product ? $log->product->nama : 'Item Terhapus' }}</td>
                            <td>{{ $log->user ? $log->user->name : 'Sistem' }}</td>
                            <td class="text-center">
                                <span class="badge {{ $log->jumlah >= 0 ? 'bg-success' : 'bg-danger' }} fs-6 px-3 py-1 rounded-pill fw-bold">
                                    {{ $log->jumlah >= 0 ? '+' . $log->jumlah : $log->jumlah }} pcs
                                </span>
                            </td>
                            <td class="text-center font-monospace">
                                <span class="text-muted">{{ $log->stok_sebelumnya }}</span>
                                <i class="bi bi-arrow-right mx-1 text-warning"></i>
                                <span class="text-white fw-bold">{{ $log->stok_sesudahnya }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $log->sumber === 'approval_request' ? 'bg-info text-dark' : 'bg-secondary' }}">
                                    {{ $log->sumber === 'approval_request' ? 'Persetujuan Kasir' : 'Input Admin' }}
                                </span>
                            </td>
                            <td class="small text-muted">{{ $log->catatan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    @else
        <div class="text-center py-4 text-muted">
            Belum ada riwayat audit stok.
        </div>
    @endif
</div>

@endsection
