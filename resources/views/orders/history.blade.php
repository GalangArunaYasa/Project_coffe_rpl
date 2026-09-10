@extends('layouts.app')

@section('title', 'Riwayat Pesanan - Aruna Coffee House')

@section('content')

<div class="container-fluid px-3 px-lg-5 py-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">Riwayat Pesanan</li>
        </ol>
    </nav>

    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-extrabold text-white mb-1">
                <i class="bi bi-clock-history me-2" style="color: var(--kg-accent);"></i> Riwayat Pesanan Saya
            </h1>
            <p class="text-muted mb-0">Pantau seluruh riwayat transaksi kopi yang pernah Anda nikmati di Aruna Coffee.</p>
        </div>
        <a href="{{ route('menu') }}" class="btn btn-kg-accent rounded-pill px-4 fw-bold shadow">
            <i class="bi bi-plus-lg me-1"></i> Pesan Kopi Baru
        </a>
    </div>

    @if($orders->count() > 0)
        <div class="kg-card rounded-4 shadow-sm p-3 p-md-4 mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Kode Order</th>
                            <th>Tanggal</th>
                            <th>Ringkasan Menu</th>
                            <th>Tipe / Pembayaran</th>
                            <th>Total</th>
                            <th>Status Pesanan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $ord)
                            <tr>
                                <td class="fw-bold font-monospace text-warning">
                                    {{ $ord->order_code }}
                                </td>
                                <td>
                                    <span class="text-white d-block fw-semibold">{{ $ord->created_at->translatedFormat('d M Y') }}</span>
                                    <small class="text-muted">{{ $ord->created_at->format('H:i') }} WIB</small>
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
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('order.track', $ord->order_code) }}" class="btn btn-kg-accent btn-sm rounded-pill px-3" title="Lacak Live">
                                            <i class="bi bi-radar"></i> Lacak
                                        </a>
                                        <a href="{{ route('order.receipt', $ord->order_code) }}" target="_blank" class="btn btn-kg-outline btn-sm rounded-pill px-3" title="Lihat Struk">
                                            <i class="bi bi-printer text-warning"></i> Struk
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
        </div>
    @else
        <div class="text-center py-5 kg-card rounded-4 p-5 shadow-sm">
            <div class="avatar-initial mx-auto mb-3" style="width: 70px; height: 70px; font-size: 2rem;">
                <i class="bi bi-receipt"></i>
            </div>
            <h3 class="fw-bold text-white mb-2">Belum Ada Riwayat Pesanan</h3>
            <p class="text-muted mb-4">Anda belum pernah melakukan pemesanan di Aruna Coffee House.</p>
            <a href="{{ route('menu') }}" class="btn btn-kg-accent btn-lg rounded-pill px-5 fw-bold shadow">
                <i class="bi bi-cup-hot me-1"></i> Pesan Sekarang
            </a>
        </div>
    @endif

</div>

@endsection
