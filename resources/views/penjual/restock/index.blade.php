@extends('layouts.penjual')

@section('title', 'Permintaan Restok Menu - Aruna Coffee')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <span class="badge rounded-pill px-3 py-1 mb-2" style="background-color: var(--kg-surface-light); border: 1px solid var(--kg-accent); color: var(--kg-gold); font-size: 0.8rem;">
            <i class="bi bi-box-seam me-1"></i> Pengadaan Bahan
        </span>
        <h1 class="h3 fw-extrabold text-white mb-1">
            Pengajuan Permintaan Restok ke Admin
        </h1>
        <p class="text-muted mb-0">Ajukan permohonan penambahan stok kopi atau bahan baku jika stok di kafe menipis.</p>
    </div>
</div>

<div class="row g-4">

    <!-- Form Ajukan Restok -->
    <div class="col-lg-5">
        <div class="pos-card p-4 shadow-sm mb-4">
            <h2 class="h5 fw-bold text-white mb-3">
                <i class="bi bi-send-plus-fill text-warning me-1"></i> Form Ajukan Restok
            </h2>

            <form action="{{ route('penjual.restock.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label text-white small fw-bold">Pilih Menu Produk Yang Ingin Direstok <span class="text-danger">*</span></label>
                    <select name="product_id" class="form-select kg-search-input rounded-3 py-2" required>
                        <option value="">-- Pilih Produk Menu --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" @selected($p->stok <= 5)>
                                {{ $p->nama }} (Sisa Stok: {{ $p->stok }} pcs)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-white small fw-bold">Jumlah Kebutuhan Restok (Pcs) <span class="text-danger">*</span></label>
                    <input type="number" name="jumlah_diminta" class="form-control kg-search-input rounded-3 py-2" placeholder="Contoh: 20" min="1" required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-white small fw-bold">Alasan / Catatan ke Admin</label>
                    <textarea name="alasan" class="form-control kg-search-input rounded-3" rows="3" placeholder="Contoh: Stok tinggal sedikit menjelang jam sibuk / ramai pembeli"></textarea>
                </div>

                <button type="submit" class="btn btn-kg-accent w-100 rounded-pill py-3 fw-bold shadow">
                    <i class="bi bi-send-fill me-1"></i> Kirim Permintaan ke Admin
                </button>
            </form>
        </div>

        <!-- Sisa Stok Produk Ringkas -->
        <div class="pos-card p-4 shadow-sm">
            <h2 class="h6 fw-bold text-white mb-3">
                <i class="bi bi-shield-exclamation text-danger me-1"></i> Menu Kritis (Stok ≤ 5)
            </h2>
            @if($stokKritis->count() > 0)
                <div class="list-group list-group-flush bg-transparent">
                    @foreach($stokKritis as $sk)
                        <div class="list-group-item bg-transparent px-0 py-2 border-bottom d-flex justify-content-between align-items-center" style="border-color: var(--kg-border) !important;">
                            <div>
                                <div class="text-white small fw-bold">{{ $sk->nama }}</div>
                                <small class="text-muted">{{ ucfirst($sk->kategori) }}</small>
                            </div>
                            <span class="badge bg-danger rounded-pill px-3 py-1 fw-bold">Sisa {{ $sk->stok }} pcs</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted small mb-0">Semua menu saat ini memiliki stok di atas 5 pcs.</p>
            @endif
        </div>
    </div>

    <!-- Riwayat Permintaan Restok -->
    <div class="col-lg-7">
        <div class="pos-card p-4 shadow-sm h-100">
            <h2 class="h5 fw-bold text-white mb-3">
                <i class="bi bi-clock-history text-info me-1"></i> Riwayat Pengajuan Permintaan Restok
            </h2>

            @if($requests->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Catatan / Alasan</th>
                                <th>Status</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $req)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-white">{{ $req->product->nama }}</div>
                                        <small class="text-muted">Sisa saat ini: <strong class="text-white">{{ $req->product->stok }} pcs</strong></small>
                                    </td>
                                    <td class="fw-bold text-warning">+{{ $req->jumlah_diminta }} pcs</td>
                                    <td>
                                        <div class="small text-white">{{ $req->alasan ?? '-' }}</div>
                                        @if($req->catatan_admin)
                                            <small class="text-info d-block mt-1">
                                                <strong>Admin ({{ $req->admin ? $req->admin->name : 'Admin' }}):</strong> "{{ $req->catatan_admin }}"
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($req->status === 'pending')
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-1 fw-bold">
                                                <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                            </span>
                                        @elseif($req->status === 'disetujui')
                                            <span class="badge bg-success rounded-pill px-3 py-1 fw-bold">
                                                <i class="bi bi-check-circle-fill me-1"></i> Disetujui
                                            </span>
                                        @else
                                            <span class="badge bg-danger rounded-pill px-3 py-1 fw-bold">
                                                <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="small text-muted">
                                        {{ $req->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $requests->links() }}
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-box2 fs-1 d-block mb-2 text-secondary"></i>
                    Belum ada riwayat pengajuan permintaan restok.
                </div>
            @endif
        </div>
    </div>

</div>

@endsection
