@extends('layouts.admin')

@section('title', 'Monitoring Pesanan & Penjualan - Admin Aruna Coffee')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <span class="badge rounded-pill px-3 py-1 mb-2" style="background-color: var(--kg-surface-light); border: 1px solid var(--kg-accent); color: var(--kg-gold); font-size: 0.8rem;">
            <i class="bi bi-receipt-cutoff me-1"></i> Transaksi Global
        </span>
        <h1 class="h3 fw-extrabold text-white mb-1">
            Monitoring Penjualan & Transaksi Kafe
        </h1>
        <p class="text-muted mb-0">Pantau seluruh aliran pesanan baik dari pelanggan online maupun penjualan langsung di kasir POS.</p>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <span class="text-muted small fw-bold text-uppercase d-block mb-1" style="letter-spacing: 0.5px;">Total Omset Penjualan</span>
            <h2 class="h3 fw-extrabold text-white mb-1">Rp {{ number_format($totalOmset, 0, ',', '.') }}</h2>
            <small class="text-success"><i class="bi bi-check-circle me-1"></i>Semua transaksi lunas</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <span class="text-muted small fw-bold text-uppercase d-block mb-1" style="letter-spacing: 0.5px;">Total Pesanan</span>
            <h2 class="h3 fw-extrabold text-white mb-1">{{ $totalTransaksi }} Transaksi</h2>
            <small class="text-muted">Kasir & Online</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <span class="text-muted small fw-bold text-uppercase d-block mb-1" style="letter-spacing: 0.5px;">Pesanan Selesai</span>
            <h2 class="h3 fw-extrabold text-success mb-1">{{ $transaksiSelesai }}</h2>
            <small class="text-muted">Telah dinikmati pembeli</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <span class="text-muted small fw-bold text-uppercase d-block mb-1" style="letter-spacing: 0.5px;">Belum Lunas</span>
            <h2 class="h3 fw-extrabold text-danger mb-1">{{ $transaksiUnpaid }}</h2>
            <small class="text-warning">Menunggu bayar</small>
        </div>
    </div>
</div>

<!-- Filter Bar -->
<div class="adm-card p-3 mb-4 shadow-sm">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-3">
            <div class="input-group input-group-sm">
                <span class="input-group-text kg-search-input border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="cari" value="{{ $cari }}" class="form-control form-control-sm kg-search-input border-start-0" placeholder="Cari Kode Order, Nama Pemesan...">
            </div>
        </div>

        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm kg-search-input rounded-3">
                <option value="semua">Semua Status Pesanan</option>
                <option value="menunggu_konfirmasi" @selected($status === 'menunggu_konfirmasi')>Menunggu Konfirmasi</option>
                <option value="diproses" @selected($status === 'diproses')>Sedang Diracik</option>
                <option value="siap_diambil" @selected($status === 'siap_diambil')>Siap Diambil/Diantar</option>
                <option value="selesai" @selected($status === 'selesai')>Selesai</option>
                <option value="dibatalkan" @selected($status === 'dibatalkan')>Dibatalkan</option>
            </select>
        </div>

        <div class="col-md-3">
            <select name="pembayaran" class="form-select form-select-sm kg-search-input rounded-3">
                <option value="semua">Semua Status Bayar</option>
                <option value="paid" @selected($pembayaran === 'paid')>Lunas (Paid)</option>
                <option value="unpaid" @selected($pembayaran === 'unpaid')>Belum Bayar (Unpaid)</option>
            </select>
        </div>

        <div class="col-md-2">
            <select name="tipe" class="form-select form-select-sm kg-search-input rounded-3">
                <option value="semua">Semua Tipe Order</option>
                <option value="dine_in" @selected($tipe === 'dine_in')>Dine In</option>
                <option value="takeaway" @selected($tipe === 'takeaway')>Takeaway</option>
                <option value="delivery" @selected($tipe === 'delivery')>Delivery</option>
            </select>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-kg-accent btn-sm rounded-pill px-3 fw-bold">Filter</button>
            @if($cari || $status !== 'semua' || $tipe !== 'semua' || $pembayaran !== 'semua')
                <a href="{{ route('admin.orders.index') }}" class="btn btn-kg-outline btn-sm rounded-pill px-3">Reset</a>
            @endif
        </div>
    </form>
</div>

<!-- Orders Table -->
<div class="adm-card p-4 shadow-sm mb-4">
    @if($orders->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Kode Order</th>
                        <th>Tanggal</th>
                        <th>Pemesan</th>
                        <th>Kasir / Handler</th>
                        <th>Ringkasan Menu</th>
                        <th>Tipe / Bayar</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $ord)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.show', $ord->id) }}" class="fw-bold font-monospace text-warning text-decoration-none">
                                    {{ $ord->order_code }}
                                </a>
                                <small class="text-muted d-block">{{ $ord->created_at->format('d/m/Y H:i') }}</small>
                            </td>
                            <td>
                                <span class="text-white d-block fw-semibold">{{ $ord->created_at->translatedFormat('d M Y') }}</span>
                                <small class="text-muted">{{ $ord->created_at->format('H:i') }} WIB</small>
                            </td>
                            <td>
                                <div class="fw-bold text-white">{{ $ord->nama_pemesan }}</div>
                                <small class="text-muted">{{ $ord->nomor_kontak }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $ord->penjual ? $ord->penjual->name : ($ord->user_id ? 'Online' : 'Kasir Walk-in') }}
                                </span>
                            </td>
                            <td>
                                <div class="small text-white">
                                    @foreach($ord->items->take(2) as $it)
                                        <div>• {{ $it->nama_produk }} ({{ $it->jumlah }}x)</div>
                                    @endforeach
                                    @if($ord->items->count() > 2)
                                        <small class="text-muted">+ {{ $ord->items->count() - 2 }} item lainnya</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <span class="badge bg-secondary" style="font-size: 0.65rem;">{{ $ord->tipe_pesanan_label }}</span>
                                    <span class="badge {{ $ord->status_pembayaran === 'paid' ? 'bg-success' : 'bg-danger' }}" style="font-size: 0.65rem;">
                                        @if($ord->status_pembayaran === 'paid')
                                            <i class="bi bi-check2-circle me-1"></i>LUNAS ({{ strtoupper($ord->metode_pembayaran) }})
                                        @else
                                            <i class="bi bi-hourglass-split me-1"></i>BELUM BAYAR
                                        @endif
                                    </span>
                                </div>
                            </td>
                            <td class="fw-bold text-white fs-6">
                                Rp {{ number_format($ord->total_harga, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge {{ $ord->status_badge_class }} rounded-pill px-3 py-1">
                                    {{ $ord->status_label }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('admin.orders.show', $ord->id) }}" class="btn btn-kg-outline btn-sm rounded-pill px-3">
                                        Detail
                                    </a>
                                    <a href="{{ route('order.receipt', $ord->order_code) }}" target="_blank" class="btn btn-kg-outline btn-sm rounded-circle" title="Cetak Struk">
                                        <i class="bi bi-printer text-warning"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
            Tidak ada transaksi pesanan yang sesuai dengan filter.
        </div>
    @endif
</div>

@endsection
