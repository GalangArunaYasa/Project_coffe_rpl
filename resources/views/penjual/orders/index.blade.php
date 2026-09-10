@extends('layouts.penjual')

@section('title', 'Manajemen Antrean Pesanan - Aruna Coffee')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <span class="badge rounded-pill px-3 py-1 mb-2" style="background-color: var(--kg-surface-light); border: 1px solid var(--kg-accent); color: var(--kg-gold); font-size: 0.8rem;">
            <i class="bi bi-receipt-cutoff me-1"></i> Manajemen Pesanan
        </span>
        <h1 class="h3 fw-extrabold text-white mb-1">
            Antrean Pesanan Masuk Pelanggan
        </h1>
        <p class="text-muted mb-0">Kelola dan update tahapan pesanan yang masuk secara real-time dari racik hingga selesai serta verifikasi pembayaran.</p>
    </div>
</div>

<!-- Filter Tabs: Status Pesanan -->
<div class="d-flex gap-2 flex-wrap mb-3 pb-1">
    <a href="{{ route('penjual.orders.index', ['status' => 'semua', 'pembayaran' => $pembayaran, 'cari' => $cari]) }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold {{ $status === 'semua' ? 'btn-kg-accent text-white' : 'btn-kg-outline' }}">
        Semua ({{ $counts['semua'] }})
    </a>
    <a href="{{ route('penjual.orders.index', ['status' => 'menunggu_konfirmasi', 'pembayaran' => $pembayaran, 'cari' => $cari]) }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold {{ $status === 'menunggu_konfirmasi' ? 'btn-warning text-dark' : 'btn-kg-outline' }}">
        <i class="bi bi-hourglass-split me-1"></i> Menunggu ({{ $counts['menunggu_konfirmasi'] }})
    </a>
    <a href="{{ route('penjual.orders.index', ['status' => 'diproses', 'pembayaran' => $pembayaran, 'cari' => $cari]) }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold {{ $status === 'diproses' ? 'btn-info text-dark' : 'btn-kg-outline' }}">
        <i class="bi bi-cup-hot-fill me-1"></i> Sedang Diracik ({{ $counts['diproses'] }})
    </a>
    <a href="{{ route('penjual.orders.index', ['status' => 'siap_diambil', 'pembayaran' => $pembayaran, 'cari' => $cari]) }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold {{ $status === 'siap_diambil' ? 'btn-primary text-white' : 'btn-kg-outline' }}">
        <i class="bi bi-bell-fill me-1"></i> Siap Diambil/Diantar ({{ $counts['siap_diambil'] }})
    </a>
    <a href="{{ route('penjual.orders.index', ['status' => 'selesai', 'pembayaran' => $pembayaran, 'cari' => $cari]) }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold {{ $status === 'selesai' ? 'btn-success text-white' : 'btn-kg-outline' }}">
        <i class="bi bi-check-circle-fill me-1"></i> Selesai ({{ $counts['selesai'] }})
    </a>
    <a href="{{ route('penjual.orders.index', ['status' => 'dibatalkan', 'pembayaran' => $pembayaran, 'cari' => $cari]) }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold {{ $status === 'dibatalkan' ? 'btn-danger text-white' : 'btn-kg-outline' }}">
        <i class="bi bi-x-circle-fill me-1"></i> Dibatalkan ({{ $counts['dibatalkan'] }})
    </a>
</div>

<!-- Filter Tabs: Status Pembayaran -->
<div class="d-flex align-items-center gap-2 flex-wrap mb-4 p-2 rounded-4" style="background-color: var(--kg-surface-light); border: 1px solid rgba(255, 255, 255, 0.05);">
    <span class="text-muted small fw-bold ms-2"><i class="bi bi-wallet2 me-1"></i> Filter Status Bayar:</span>
    <a href="{{ route('penjual.orders.index', ['status' => $status, 'pembayaran' => 'semua', 'cari' => $cari]) }}" class="btn btn-sm rounded-pill px-3 py-1 {{ $pembayaran === 'semua' ? 'btn-secondary text-white fw-bold' : 'btn-kg-outline text-muted' }}" style="font-size: 0.8rem;">
        Semua Pembayaran
    </a>
    <a href="{{ route('penjual.orders.index', ['status' => $status, 'pembayaran' => 'unpaid', 'cari' => $cari]) }}" class="btn btn-sm rounded-pill px-3 py-1 {{ $pembayaran === 'unpaid' ? 'btn-danger text-white fw-bold' : 'btn-kg-outline text-muted' }}" style="font-size: 0.8rem;">
        <i class="bi bi-exclamation-circle me-1"></i> Belum Bayar ({{ $counts['unpaid'] }})
    </a>
    <a href="{{ route('penjual.orders.index', ['status' => $status, 'pembayaran' => 'paid', 'cari' => $cari]) }}" class="btn btn-sm rounded-pill px-3 py-1 {{ $pembayaran === 'paid' ? 'btn-success text-white fw-bold' : 'btn-kg-outline text-muted' }}" style="font-size: 0.8rem;">
        <i class="bi bi-check2-circle me-1"></i> Lunas ({{ $counts['paid'] }})
    </a>
</div>

<!-- Search Bar -->
<div class="pos-card p-3 mb-4 shadow-sm">
    <form action="{{ route('penjual.orders.index') }}" method="GET" class="row g-2 align-items-center">
        @if($status !== 'semua')
            <input type="hidden" name="status" value="{{ $status }}">
        @endif
        @if($pembayaran !== 'semua')
            <input type="hidden" name="pembayaran" value="{{ $pembayaran }}">
        @endif
        <div class="col-md-5">
            <div class="input-group input-group-sm">
                <span class="input-group-text kg-search-input border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="cari" value="{{ $cari }}" class="form-control form-control-sm kg-search-input border-start-0" placeholder="Cari Kode Order, Nama Pemesan, No HP...">
            </div>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-kg-accent btn-sm rounded-pill px-3 fw-bold">Filter</button>
            @if($cari || $status !== 'semua' || $pembayaran !== 'semua')
                <a href="{{ route('penjual.orders.index') }}" class="btn btn-kg-outline btn-sm rounded-pill px-3">Reset</a>
            @endif
        </div>
    </form>
</div>

<!-- Orders Table -->
<div class="pos-card p-4 shadow-sm mb-4">
    @if($orders->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Order Code</th>
                        <th>Pemesan</th>
                        <th>Menu & Kustomisasi</th>
                        <th>Tipe / Status Bayar</th>
                        <th>Total</th>
                        <th>Status Pesanan</th>
                        <th class="text-end">Aksi Barista / Kasir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $ord)
                        <tr>
                            <td>
                                <a href="{{ route('penjual.orders.show', $ord->id) }}" class="fw-bold font-monospace text-warning text-decoration-none">
                                    {{ $ord->order_code }}
                                </a>
                                <small class="text-muted d-block">{{ $ord->created_at->format('d/m/Y H:i') }}</small>
                            </td>
                            <td>
                                <div class="fw-bold text-white">{{ $ord->nama_pemesan }}</div>
                                <small class="text-muted d-block">{{ $ord->nomor_kontak }}</small>
                                @if($ord->catatan_alamat)
                                    <small class="text-info d-block" style="font-size: 0.75rem;">
                                        <i class="bi bi-geo-alt-fill me-1"></i> {{ $ord->catatan_alamat }}
                                    </small>
                                @endif
                            </td>
                            <td>
                                <div class="small text-white">
                                    @foreach($ord->items as $it)
                                        <div>
                                            • <strong>{{ $it->nama_produk }}</strong> ({{ $it->jumlah }}x)
                                            <span class="text-muted" style="font-size: 0.7rem;">[{{ $it->ukuran }}, {{ $it->suhu }}, {{ $it->manis }}]</span>
                                            @if($it->catatan_khusus)
                                                <small class="text-warning d-block ms-2">"{{ $it->catatan_khusus }}"</small>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <span class="badge bg-secondary" style="font-size: 0.65rem;">
                                        {{ $ord->tipe_pesanan_label }}
                                    </span>
                                    
                                    @if($ord->status_pembayaran === 'paid')
                                        <span class="badge bg-success fw-bold" style="font-size: 0.65rem;">
                                            <i class="bi bi-check2-circle me-1"></i>LUNAS ({{ strtoupper($ord->metode_pembayaran) }})
                                        </span>
                                    @else
                                        <span class="badge bg-danger fw-bold" style="font-size: 0.65rem;">
                                            <i class="bi bi-hourglass-split me-1"></i>BELUM BAYAR
                                        </span>
                                        <!-- Quick 1-Click Pay Confirmation Button for Cashier -->
                                        <form action="{{ route('penjual.orders.updatePayment', $ord->id) }}" method="POST" class="d-inline mt-1">
                                            @csrf
                                            <input type="hidden" name="status_pembayaran" value="paid">
                                            <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-2 py-0 fw-bold w-100" style="font-size: 0.68rem;" title="Klik untuk konfirmasi terima pembayaran">
                                                <i class="bi bi-check-lg"></i> Tandai Lunas
                                            </button>
                                        </form>
                                    @endif
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
                                <div class="d-flex justify-content-end gap-1 flex-wrap">
                                    @if($ord->status === 'menunggu_konfirmasi')
                                        <form action="{{ route('penjual.orders.updateStatus', $ord->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="diproses">
                                            <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">
                                                <i class="bi bi-play-fill"></i> Racik
                                            </button>
                                        </form>
                                    @elseif($ord->status === 'diproses')
                                        <form action="{{ route('penjual.orders.updateStatus', $ord->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="siap_diambil">
                                            <button type="submit" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold text-dark">
                                                <i class="bi bi-check-lg"></i> Siap
                                            </button>
                                        </form>
                                    @elseif($ord->status === 'siap_diambil')
                                        <form action="{{ route('penjual.orders.updateStatus', $ord->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 fw-bold">
                                                <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('penjual.orders.show', $ord->id) }}" class="btn btn-kg-outline btn-sm rounded-pill px-2" title="Detail Pesanan">
                                        <i class="bi bi-eye"></i>
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
            Tidak ada pesanan yang sesuai filter ini.
        </div>
    @endif
</div>

@endsection
