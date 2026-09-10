@extends('layouts.admin')

@section('title', 'Admin Dashboard - Aruna Coffee House')

@section('content')

<!-- Header Welcome & Quick Action -->
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <span class="badge rounded-pill px-3 py-1 mb-2" style="background-color: var(--kg-surface-light); border: 1px solid var(--kg-accent); color: var(--kg-gold); font-size: 0.8rem;">
            <i class="bi bi-shield-check me-1"></i> Mode Administrator & Monitoring Terpadu
        </span>
        <h1 class="h3 fw-extrabold text-white mb-1">
            Dashboard Monitoring Admin
        </h1>
        <p class="text-muted mb-0">Selamat datang, <strong class="text-white">{{ Auth::user()->name }}</strong>! Pantau performa omset, menu kafe, dan logistik stok secara real-time.</p>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.restocks.requests') }}" class="btn btn-kg-accent rounded-pill px-3 py-2 fw-bold d-flex align-items-center gap-2 shadow">
            <i class="bi bi-check2-circle fs-5"></i> Permintaan Restok
            @if($permintaanRestokPending->count() > 0)
                <span class="badge bg-danger rounded-pill">{{ $permintaanRestokPending->count() }}</span>
            @endif
        </a>
        <a href="{{ route('admin.products.create') }}" class="btn btn-kg-outline rounded-pill px-3 py-2 fw-bold d-flex align-items-center gap-2">
            <i class="bi bi-plus-lg text-warning"></i> Tambah Menu Baru
        </a>
    </div>
</div>

<!-- Key Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Total Pendapatan</span>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.4); color: #10b981;">
                    <i class="bi bi-wallet2 fs-5"></i>
                </div>
            </div>
            <h2 class="h3 fw-extrabold text-white mb-1">Rp {{ number_format($totalOmset, 0, ',', '.') }}</h2>
            <small class="text-muted"><i class="bi bi-check2 me-1 text-success"></i>{{ $totalPesananSelesai }} pesanan selesai</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Total Menu Aktif</span>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(59, 130, 246, 0.2); border: 1px solid rgba(59, 130, 246, 0.4); color: #60a5fa;">
                    <i class="bi bi-cup-hot fs-5"></i>
                </div>
            </div>
            <h2 class="h3 fw-extrabold text-white mb-1">{{ $totalProduk }} Menu</h2>
            <small class="text-muted"><i class="bi bi-star-fill me-1 text-warning"></i>{{ $totalBestseller }} produk Best Seller</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Stok Kritis (≤ 5 pcs)</span>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.4); color: #f87171;">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                </div>
            </div>
            <h2 class="h3 fw-extrabold {{ $stokTipis->count() > 0 ? 'text-danger' : 'text-success' }} mb-1">
                {{ $stokTipis->count() }} Menu
            </h2>
            <small class="text-muted">{{ $stokTipis->count() > 0 ? 'Perlu restok segera' : 'Semua stok aman' }}</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Permintaan Restok</span>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(245, 158, 11, 0.2); border: 1px solid rgba(245, 158, 11, 0.4); color: var(--kg-gold);">
                    <i class="bi bi-inbox-fill fs-5"></i>
                </div>
            </div>
            <h2 class="h3 fw-extrabold text-warning mb-1">{{ $permintaanRestokPending->count() }} Pending</h2>
            <small class="text-muted">Dari staf kasir / barista</small>
        </div>
    </div>
</div>

<!-- Permintaan Restok Pending Alert Board -->
@if($permintaanRestokPending->count() > 0)
    <div class="adm-card p-4 mb-4 border" style="border-color: var(--kg-accent) !important; background: linear-gradient(135deg, #241c17 0%, #171310 100%) !important;">
        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
            <h2 class="h5 fw-bold text-warning mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-bell-fill text-warning"></i> Ada {{ $permintaanRestokPending->count() }} Permintaan Restok Baru dari Penjual!
            </h2>
            <a href="{{ route('admin.restocks.requests') }}" class="btn btn-kg-accent btn-sm rounded-pill px-3 fw-bold shadow">
                Buka Halaman Approval <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Penjual / Kasir</th>
                        <th>Jumlah Diminta</th>
                        <th>Alasan</th>
                        <th>Waktu</th>
                        <th class="text-end">Aksi Cepat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permintaanRestokPending as $req)
                        <tr>
                            <td class="fw-bold text-white">{{ $req->product->nama }} (Sisa: {{ $req->product->stok }} pcs)</td>
                            <td>{{ $req->penjual ? $req->penjual->name : 'Staff Kasir' }}</td>
                            <td class="fw-bold text-warning">+{{ $req->jumlah_diminta }} pcs</td>
                            <td class="small text-muted">{{ $req->alasan }}</td>
                            <td class="small text-muted">{{ $req->created_at->diffForHumans() }}</td>
                            <td class="text-end">
                                <form action="{{ route('admin.restocks.requests.approve', $req->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 fw-bold">
                                        <i class="bi bi-check-lg me-1"></i> Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.restocks.requests.reject', $req->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tolak permintaan ini?')">
                                    @csrf
                                    <button type="submit" class="btn btn-kg-outline btn-sm rounded-pill px-2 text-danger">
                                        Tolak
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

<div class="row g-4">

    <!-- Daftar Stok Kritis & Quick Restock -->
    <div class="col-lg-6">
        <div class="adm-card p-4 shadow-sm h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h5 fw-bold text-white mb-0">
                    <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i> Menu Perlu Diisi Ulang (Stok ≤ 5)
                </h2>
                <a href="{{ route('admin.restocks.index') }}" class="btn btn-kg-outline btn-sm rounded-pill px-3">
                    Buka Restok
                </a>
            </div>

            @if($stokTipis->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Nama Menu</th>
                                <th>Sisa Stok</th>
                                <th class="text-end">Restok Cepat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stokTipis as $stk)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-white">{{ $stk->nama }}</div>
                                        <small class="text-muted">{{ ucfirst($stk->kategori) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger rounded-pill px-3 py-1 fw-bold">{{ $stk->stok }} Pcs</span>
                                    </td>
                                    <td class="text-end">
                                        <form action="{{ route('admin.products.quickRestock', $stk->id) }}" method="POST" class="d-flex justify-content-end gap-1">
                                            @csrf
                                            <input type="hidden" name="tambah_stok" value="20">
                                            <button type="submit" class="btn btn-kg-accent btn-sm rounded-pill px-3 fw-bold">
                                                + 20 pcs
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-shield-check fs-1 text-success d-block mb-1"></i>
                    Semua stok produk berada dalam batas aman.
                </div>
            @endif
        </div>
    </div>

    <!-- Top 5 Produk Terlaris -->
    <div class="col-lg-6">
        <div class="adm-card p-4 shadow-sm h-100">
            <h2 class="h5 fw-bold text-white mb-3">
                <i class="bi bi-trophy-fill text-warning me-2"></i> 5 Menu Paling Laris Terjual
            </h2>

            @if($topProducts->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Peringkat & Menu</th>
                                <th class="text-center">Total Terjual</th>
                                <th class="text-end">Total Omset</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $index => $top)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge {{ $index === 0 ? 'bg-warning text-dark' : ($index === 1 ? 'bg-secondary' : 'bg-dark border border-secondary text-white') }} rounded-circle" style="width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center; font-weight: 700;">
                                                {{ $index + 1 }}
                                            </span>
                                            <span class="fw-bold text-white">{{ $top->nama_produk }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center fw-bold text-warning">{{ $top->total_terjual }} pcs</td>
                                    <td class="text-end fw-bold text-success">Rp {{ number_format($top->total_omset, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    Belum ada transaksi penjualan yang tercatat.
                </div>
            @endif
        </div>
    </div>

</div>

<!-- Transaksi Terbaru -->
<div class="adm-card p-4 shadow-sm mt-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h5 fw-bold text-white mb-0">
            <i class="bi bi-clock-history text-info me-2"></i> Transaksi Penjualan Terbaru
        </h2>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-kg-outline btn-sm rounded-pill px-3">
            Lihat Semua Pesanan
        </a>
    </div>

    @if($transaksiTerbaru->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Order Code</th>
                        <th>Pemesan</th>
                        <th>Penjual / Kasir</th>
                        <th>Total</th>
                        <th>Metode Bayar</th>
                        <th>Status</th>
                        <th class="text-end">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksiTerbaru as $tr)
                        <tr>
                            <td class="fw-bold font-monospace text-warning">{{ $tr->order_code }}</td>
                            <td>{{ $tr->nama_pemesan }}</td>
                            <td>{{ $tr->penjual ? $tr->penjual->name : 'Online Customer' }}</td>
                            <td class="fw-bold text-white">Rp {{ number_format($tr->total_harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $tr->status_pembayaran === 'paid' ? 'bg-success' : 'bg-danger' }}">
                                    {{ strtoupper($tr->metode_pembayaran) }} ({{ $tr->status_pembayaran }})
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $tr->status_badge_class }} rounded-pill px-3 py-1">
                                    {{ $tr->status_label }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.orders.show', $tr->id) }}" class="btn btn-kg-outline btn-sm rounded-pill px-3">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-4 text-muted">
            Belum ada transaksi.
        </div>
    @endif
</div>

@endsection