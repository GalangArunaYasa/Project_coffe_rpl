@extends('layouts.penjual')

@section('title', 'Dashboard Penjual & Kasir - Aruna Coffee')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <span class="badge rounded-pill px-3 py-1 mb-2" style="background-color: var(--kg-surface-light); border: 1px solid var(--kg-accent); color: var(--kg-gold); font-size: 0.8rem;">
            <i class="bi bi-cup-hot me-1"></i> Operasional Kasir & Barista
        </span>
        <h1 class="h3 fw-extrabold text-white mb-1">
            Dashboard Kasir & Barista
        </h1>
        <p class="text-muted mb-0">Selamat bertugas, <strong class="text-white">{{ Auth::user()->name }}</strong>! Pantau antrean pesanan kafe dan operasional POS.</p>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('penjual.pos.index') }}" class="btn btn-kg-accent rounded-pill px-4 py-2 shadow d-flex align-items-center gap-2">
            <i class="bi bi-calculator-fill fs-5"></i> Buka Kasir POS
        </a>
        <a href="{{ route('penjual.orders.index') }}" class="btn btn-kg-outline rounded-pill px-4 py-2 shadow d-flex align-items-center gap-2">
            <i class="bi bi-receipt fs-5 text-warning"></i> Antrean Pesanan ({{ $pesananMenunggu + $pesananDiproses }})
        </a>
    </div>
</div>

<!-- Metrik Hari Ini -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Omset Kasir Hari Ini</span>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.4); color: #10b981;">
                    <i class="bi bi-cash-stack fs-5"></i>
                </div>
            </div>
            <h2 class="h3 fw-extrabold text-white mb-1">Rp {{ number_format($omsetHariIni, 0, ',', '.') }}</h2>
            <small class="text-muted">{{ $totalTransaksiHariIni }} transaksi lunas</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Pesanan Menunggu</span>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(245, 158, 11, 0.2); border: 1px solid rgba(245, 158, 11, 0.4); color: var(--kg-gold);">
                    <i class="bi bi-hourglass-split fs-5"></i>
                </div>
            </div>
            <h2 class="h3 fw-extrabold text-warning mb-1">{{ $pesananMenunggu }}</h2>
            <small class="text-muted">Butuh konfirmasi segera</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Sedang Diracik</span>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(59, 130, 246, 0.2); border: 1px solid rgba(59, 130, 246, 0.4); color: #60a5fa;">
                    <i class="bi bi-cup-hot fs-5"></i>
                </div>
            </div>
            <h2 class="h3 fw-extrabold text-info mb-1">{{ $pesananDiproses }}</h2>
            <small class="text-muted">Dalam proses penyajian</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Peringatan Stok Kritis</span>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.4); color: #f87171;">
                    <i class="bi bi-exclamation-octagon fs-5"></i>
                </div>
            </div>
            <h2 class="h3 fw-extrabold {{ $stokKritis->count() > 0 ? 'text-danger' : 'text-success' }} mb-1">
                {{ $stokKritis->count() }} Menu
            </h2>
            <small class="text-muted">Stok ≤ 5 pcs (Minta restok)</small>
        </div>
    </div>
</div>

<div class="row g-4">

    <!-- Antrean Pesanan Aktif -->
    <div class="col-lg-8">
        <div class="pos-card p-4 shadow-sm mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h5 fw-bold text-white mb-0">
                    <i class="bi bi-bell-fill text-warning me-2"></i> Antrean Pesanan Masuk (Real-time)
                </h2>
                <a href="{{ route('penjual.orders.index') }}" class="btn btn-kg-outline btn-sm rounded-pill px-3">
                    Lihat Semua
                </a>
            </div>

            @if($antreanPesanan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Order Code</th>
                                <th>Pemesan</th>
                                <th>Ringkasan Item</th>
                                <th>Status</th>
                                <th class="text-end">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($antreanPesanan as $ord)
                                <tr>
                                    <td class="fw-bold font-monospace text-warning">{{ $ord->order_code }}</td>
                                    <td>
                                        <div class="fw-bold text-white">{{ $ord->nama_pemesan }}</div>
                                        <small class="badge bg-secondary">{{ strtoupper($ord->tipe_pesanan) }}</small>
                                    </td>
                                    <td>
                                        <div class="small text-white">
                                            @foreach($ord->items as $item)
                                                <div>{{ $item->jumlah }}x {{ $item->nama_produk }} <span class="text-muted">({{ $item->suhu }}, {{ $item->ukuran }})</span></div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $ord->status_badge_class }} rounded-pill px-3 py-1">
                                            {{ $ord->status_label }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @if($ord->status === 'menunggu_konfirmasi')
                                                <form action="{{ route('penjual.orders.updateStatus', $ord->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="diproses">
                                                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">
                                                        <i class="bi bi-play-fill"></i> Racik Sekarang
                                                    </button>
                                                </form>
                                            @elseif($ord->status === 'diproses')
                                                <form action="{{ route('penjual.orders.updateStatus', $ord->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="siap_diambil">
                                                    <button type="submit" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold text-dark">
                                                        <i class="bi bi-check-lg"></i> Siap Diambil
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('penjual.orders.show', $ord->id) }}" class="btn btn-kg-outline btn-sm rounded-pill px-2" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-cup-hot fs-1 d-block mb-2 text-secondary"></i>
                    Tidak ada antrean pesanan aktif saat ini. Siap melayani pembeli baru!
                </div>
            @endif
        </div>
    </div>

    <!-- Stok Kafe Kritis & Minta Restok -->
    <div class="col-lg-4">
        <div class="pos-card p-4 shadow-sm mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h5 fw-bold text-white mb-0">
                    <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i> Stok Menu Kafe
                </h2>
                <a href="{{ route('penjual.restock.index') }}" class="btn btn-kg-outline btn-sm rounded-pill px-2 text-warning">
                    Minta Restok
                </a>
            </div>

            @if($stokKritis->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                <th class="text-center">Sisa</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stokKritis as $crit)
                                <tr>
                                    <td class="fw-bold text-white">{{ $crit->nama }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-danger rounded-pill px-2 py-1 fw-bold">{{ $crit->stok }} pcs</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('penjual.restock.index', ['product_id' => $crit->id]) }}" class="btn btn-kg-accent btn-sm rounded-pill px-3 fw-bold">
                                            Minta
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-check-circle-fill fs-2 text-success d-block mb-2"></i>
                    Semua stok menu kopi dalam kondisi cukup dan aman.
                </div>
            @endif
        </div>
    </div>

</div>

@endsection
