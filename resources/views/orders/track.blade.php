@extends('layouts.app')

@section('title', 'Lacak Pesanan: ' . $order->order_code . ' - Aruna Coffee House')

@section('content')

<div class="container-fluid px-3 px-lg-5 py-4">

    <!-- Header Tracker -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill mb-1">
                <i class="bi bi-radar me-1"></i> Live Order Tracker
            </span>
            <h1 class="h3 fw-extrabold text-white mb-0">Status Pesanan: {{ $order->order_code }}</h1>
            <small class="text-muted">Dibuat pada: {{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB</small>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('order.receipt', $order->order_code) }}" target="_blank" class="btn btn-kg-outline rounded-pill px-3">
                <i class="bi bi-printer me-1 text-warning"></i> Cetak Struk
            </a>
            <a href="{{ route('menu') }}" class="btn btn-kg-accent rounded-pill px-4 fw-bold shadow">
                <i class="bi bi-plus-lg me-1"></i> Pesan Menu Lain
            </a>
        </div>
    </div>

    <!-- Live Status Tracker Card -->
    <div class="kg-card rounded-4 p-4 p-md-5 mb-4 shadow-sm" style="background: #14100e; border: 1px solid rgba(255, 255, 255, 0.08);">
        
        <!-- Status Header Badge & Dynamic Description -->
        <div class="text-center mb-4">
            <span class="badge {{ $order->status_badge_class }} fs-6 px-4 py-2 rounded-pill shadow">
                Status Saat Ini: {{ $order->status_label }}
            </span>

            @if($order->status === 'menunggu_konfirmasi')
                <p class="text-muted mt-2 small">Pesanan Anda telah masuk dan sedang menunggu konfirmasi dari kasir/barista kafe.</p>
            @elseif($order->status === 'diproses')
                <p class="text-info mt-2 small fw-semibold">
                    <i class="bi bi-cup-hot-fill me-1"></i> Barista kami sedang meracik minuman pesanan Anda dengan penuh cita rasa.
                </p>
            @elseif($order->status === 'siap_diambil')
                @if($order->tipe_pesanan === 'takeaway')
                    <p class="text-warning mt-2 small fw-bold">
                        <i class="bi bi-bell-fill me-1"></i> Minuman Anda sudah siap! Silakan langsung ambil di meja kasir kafe.
                    </p>
                @elseif($order->tipe_pesanan === 'dine_in')
                    <p class="text-warning mt-2 small fw-bold">
                        <i class="bi bi-bell-fill me-1"></i> Minuman Anda sudah siap! Barista kami segera mengantarkannya ke {{ $order->catatan_alamat ? 'Meja ' . $order->catatan_alamat : 'meja Anda' }}.
                    </p>
                @elseif($order->tipe_pesanan === 'delivery')
                    <p class="text-warning mt-2 small fw-bold">
                        <i class="bi bi-bell-fill me-1"></i> Minuman Anda sudah siap dan sedang dalam perjalanan diantar ke alamat Anda ({{ $order->catatan_alamat }}).
                    </p>
                @else
                    <p class="text-warning mt-2 small fw-bold">
                        <i class="bi bi-bell-fill me-1"></i> Minuman Anda sudah siap! Silakan ambil atau tunggu diantarkan.
                    </p>
                @endif
            @elseif($order->status === 'selesai')
                <p class="text-success mt-2 small fw-semibold">
                    <i class="bi bi-check-circle-fill me-1"></i> Pesanan telah selesai. Terima kasih telah menikmati kopi di Aruna Coffee House!
                </p>
            @elseif($order->status === 'dibatalkan')
                <p class="text-danger mt-2 small fw-semibold">
                    <i class="bi bi-x-circle-fill me-1"></i> Pesanan telah dibatalkan.
                </p>
            @endif
        </div>

        <!-- Visual Step Indicator -->
        <div class="row text-center gy-4 position-relative">
            @php
                $step = match($order->status) {
                    'menunggu_konfirmasi' => 1,
                    'diproses' => 2,
                    'siap_diambil' => 3,
                    'selesai' => 4,
                    default => 0,
                };
            @endphp

            <div class="col-3">
                <div class="avatar-initial mx-auto mb-2 {{ $step >= 1 ? 'shadow-lg' : 'bg-secondary opacity-50' }}" style="width: 52px; height: 52px; {{ $step >= 1 ? 'background: var(--kg-accent-gradient);' : '' }}">
                    <i class="bi bi-clock-history fs-4"></i>
                </div>
                <div class="fw-bold {{ $step >= 1 ? 'text-white' : 'text-muted' }} small">1. Diterima</div>
                <small class="text-muted d-none d-sm-block" style="font-size: 0.7rem;">Menunggu Konfirmasi</small>
            </div>

            <div class="col-3">
                <div class="avatar-initial mx-auto mb-2 {{ $step >= 2 ? 'shadow-lg' : 'bg-secondary opacity-50' }}" style="width: 52px; height: 52px; {{ $step >= 2 ? 'background: var(--kg-accent-gradient);' : '' }}">
                    <i class="bi bi-cup-hot-fill fs-4"></i>
                </div>
                <div class="fw-bold {{ $step >= 2 ? 'text-white' : 'text-muted' }} small">2. Diracik</div>
                <small class="text-muted d-none d-sm-block" style="font-size: 0.7rem;">Proses Seduh Barista</small>
            </div>

            <div class="col-3">
                <div class="avatar-initial mx-auto mb-2 {{ $step >= 3 ? 'shadow-lg' : 'bg-secondary opacity-50' }}" style="width: 52px; height: 52px; {{ $step >= 3 ? 'background: var(--kg-accent-gradient);' : '' }}">
                    @if($order->tipe_pesanan === 'delivery')
                        <i class="bi bi-scooter fs-4"></i>
                    @elseif($order->tipe_pesanan === 'dine_in')
                        <i class="bi bi-cup-straw fs-4"></i>
                    @else
                        <i class="bi bi-bag-check-fill fs-4"></i>
                    @endif
                </div>
                <div class="fw-bold {{ $step >= 3 ? 'text-white' : 'text-muted' }} small">
                    @if($order->tipe_pesanan === 'takeaway')
                        3. Siap Diambil
                    @elseif($order->tipe_pesanan === 'dine_in')
                        3. Siap Diantar
                    @elseif($order->tipe_pesanan === 'delivery')
                        3. Sedang Diantar
                    @else
                        3. Siap
                    @endif
                </div>
                <small class="text-muted d-none d-sm-block" style="font-size: 0.7rem;">
                    @if($order->tipe_pesanan === 'takeaway')
                        Di Meja Kasir
                    @elseif($order->tipe_pesanan === 'dine_in')
                        Ke Meja Kafe
                    @elseif($order->tipe_pesanan === 'delivery')
                        Ke Alamat Tujuan
                    @else
                        Siap Diambil/Diantar
                    @endif
                </small>
            </div>

            <div class="col-3">
                <div class="avatar-initial mx-auto mb-2 {{ $step >= 4 ? 'shadow-lg' : 'bg-secondary opacity-50' }}" style="width: 52px; height: 52px; {{ $step >= 4 ? 'background: var(--kg-accent-gradient);' : '' }}">
                    <i class="bi bi-check-circle-fill fs-4"></i>
                </div>
                <div class="fw-bold {{ $step >= 4 ? 'text-white' : 'text-muted' }} small">4. Selesai</div>
                <small class="text-muted d-none d-sm-block" style="font-size: 0.7rem;">Pesanan Tuntas</small>
            </div>
        </div>

    </div>

    <!-- Status Pembayaran Box (Paid vs Unpaid) -->
    <div class="row mb-4">
        <div class="col-12">
            @if($order->status_pembayaran === 'paid')
                <div class="p-3 p-md-4 rounded-4 shadow-sm d-flex align-items-center justify-content-between flex-wrap gap-3" 
                     style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(6, 78, 59, 0.25) 100%); border: 1px solid rgba(16, 185, 129, 0.4);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-success text-white" style="width: 48px; height: 48px;">
                            <i class="bi bi-patch-check-fill fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-extrabold text-white fs-6">Pembayaran Lunas (Terverifikasi)</div>
                            <small class="text-muted d-block">
                                Nominal tagihan sebesar <strong class="text-warning">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong> telah dibayar melalui <span class="badge bg-dark border border-secondary text-uppercase">{{ $order->metode_pembayaran }}</span>.
                            </small>
                        </div>
                    </div>
                    <span class="badge bg-success px-3 py-2 rounded-pill fw-bold">
                        <i class="bi bi-check2-all me-1"></i> LUNAS (PAID)
                    </span>
                </div>
            @else
                <div class="p-3 p-md-4 rounded-4 shadow-sm" 
                     style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.12) 0%, rgba(120, 53, 15, 0.22) 100%); border: 1px solid rgba(245, 158, 11, 0.4);">
                    
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 pb-2 border-bottom" style="border-color: rgba(245, 158, 11, 0.25) !important;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-warning text-dark fw-bold" style="width: 36px; height: 36px;">
                                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                            </div>
                            <div>
                                <h3 class="h6 fw-bold text-white mb-0">Menunggu Pembayaran (Belum Bayar)</h3>
                                <small class="text-muted">Total tagihan yang harus dibayar: <strong class="text-warning">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong></small>
                            </div>
                        </div>
                        <span class="badge bg-danger px-3 py-2 rounded-pill fw-bold">
                            <i class="bi bi-hourglass-top me-1"></i> BELUM LUNAS
                        </span>
                    </div>

                    <!-- Instruksi berdasarkan Metode Bayar -->
                    @if($order->metode_pembayaran === 'qris')
                        <div class="row align-items-center g-3">
                            <div class="col-auto text-center">
                                <div class="p-2 bg-white rounded-3 shadow d-inline-block text-center" style="width: 100px; height: 100px;">
                                    <i class="bi bi-qr-code text-dark display-6 d-block mt-2"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-white small">Scan QRIS Aruna Coffee House</div>
                                <p class="text-muted small mb-2" style="line-height: 1.4;">
                                    Buka aplikasi GoPay, OVO, Dana, ShopeePay, BCA Mobile, atau m-Banking Anda, lalu scan kode QR di samping dan lakukan pembayaran sebesar <strong>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong>.
                                </p>
                                <small class="badge bg-secondary font-monospace">NMID: ID10202600123</small>
                            </div>
                        </div>
                    @elseif($order->metode_pembayaran === 'transfer')
                        <div>
                            <p class="text-muted small mb-2">Silakan transfer tepat sebesar <strong class="text-warning">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong> ke salah satu rekening kafe:</p>
                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <div class="p-2 px-3 rounded-3 bg-dark border border-secondary text-white small">
                                        <div class="fw-bold text-warning"><i class="bi bi-bank me-1"></i> Bank BCA</div>
                                        <div class="fs-6 font-monospace fw-bold text-white">829-019-2026</div>
                                        <small class="text-muted">a/n Aruna Coffee House</small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-2 px-3 rounded-3 bg-dark border border-secondary text-white small">
                                        <div class="fw-bold text-info"><i class="bi bi-bank me-1"></i> Bank Mandiri</div>
                                        <div class="fs-6 font-monospace fw-bold text-white">137-00-2910-2026</div>
                                        <small class="text-muted">a/n Aruna Coffee House</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-cash-coin fs-2 text-warning"></i>
                            <div>
                                <div class="fw-bold text-white small">Pembayaran Tunai (Cash di Kasir)</div>
                                <small class="text-muted d-block">
                                    Silakan lakukan pembayaran tunai sebesar <strong>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong> di meja kasir kafe saat mengambil minuman atau saat barista mengantarkannya ke meja Anda.
                                </small>
                            </div>
                        </div>
                    @endif

                </div>
            @endif
        </div>
    </div>

    <div class="row g-4">

        <!-- Detail Pesanan -->
        <div class="col-lg-7">
            <div class="kg-card rounded-4 p-4 shadow-sm mb-4" style="background: #14100e; border: 1px solid rgba(255, 255, 255, 0.08);">
                <h2 class="h5 fw-bold text-white mb-3">Daftar Minuman & Camilan</h2>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                <th>Kustomisasi</th>
                                <th>Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $it)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-white">{{ $it->nama_produk }}</div>
                                        <small class="text-muted">Rp {{ number_format($it->harga_satuan, 0, ',', '.') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <span class="badge bg-secondary" style="font-size: 0.65rem;">{{ $it->ukuran }}</span>
                                            <span class="badge {{ $it->suhu === 'Es' ? 'bg-info text-dark' : 'bg-danger' }}" style="font-size: 0.65rem;">{{ $it->suhu }}</span>
                                            <span class="badge bg-dark border border-secondary text-white" style="font-size: 0.65rem;">{{ $it->manis }}</span>
                                            @if($it->tambahan)
                                                <span class="badge bg-warning text-dark" style="font-size: 0.65rem;">{{ $it->tambahan }}</span>
                                            @endif
                                        </div>
                                        @if($it->catatan_khusus)
                                            <small class="text-warning d-block mt-1">"{{ $it->catatan_khusus }}"</small>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-center text-white">{{ $it->jumlah }}</td>
                                    <td class="text-end fw-bold text-white">
                                        Rp {{ number_format($it->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pt-3 border-top mt-3" style="border-color: var(--kg-border) !important;">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Subtotal</span>
                        <span class="text-white small">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Biaya Antar / Layanan</span>
                        <span class="text-white small">Rp {{ number_format($order->ongkir, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: var(--kg-border) !important;">
                        <span class="fw-bold text-white fs-6">TOTAL PEMBAYARAN</span>
                        <span class="fs-4 fw-extrabold text-warning">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Penerima & Status Bayar -->
        <div class="col-lg-5">
            <div class="kg-card rounded-4 p-4 shadow-sm mb-4" style="background: #14100e; border: 1px solid rgba(255, 255, 255, 0.08);">
                <h2 class="h5 fw-bold text-white mb-3">Informasi Pengambilan</h2>

                <div class="mb-3">
                    <label class="text-muted small d-block">Nama Pemesan:</label>
                    <span class="fw-bold text-white fs-6">{{ $order->nama_pemesan }}</span>
                </div>

                <div class="mb-3">
                    <label class="text-muted small d-block">Nomor Kontak / WhatsApp:</label>
                    <span class="fw-bold text-white font-monospace">{{ $order->nomor_kontak }}</span>
                </div>

                <div class="mb-3">
                    <label class="text-muted small d-block">Metode Pengambilan:</label>
                    <div class="d-flex align-items-center gap-2 mt-1">
                        @if($order->tipe_pesanan === 'takeaway')
                            <span class="badge bg-info text-dark fw-bold px-3 py-2 rounded-pill">
                                <i class="bi bi-bag-check me-1"></i> Ambil Sendiri di Kasir (Takeaway)
                            </span>
                        @elseif($order->tipe_pesanan === 'dine_in')
                            <span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill">
                                <i class="bi bi-cup-straw me-1"></i> Minum di Tempat (Dine In)
                            </span>
                        @elseif($order->tipe_pesanan === 'delivery')
                            <span class="badge bg-success text-white fw-bold px-3 py-2 rounded-pill">
                                <i class="bi bi-scooter me-1"></i> Pesan Antar ke Alamat (Delivery)
                            </span>
                        @else
                            <span class="badge bg-secondary text-uppercase">{{ $order->tipe_pesanan }}</span>
                        @endif
                    </div>
                </div>

                @if($order->catatan_alamat)
                    <div class="mb-3">
                        <label class="text-muted small d-block">
                            {{ $order->tipe_pesanan === 'dine_in' ? 'Nomor Meja Kafe:' : 'Alamat Pengantaran / Catatan Lokasi:' }}
                        </label>
                        <div class="p-2 px-3 rounded-3 text-white fw-semibold" style="background-color: var(--kg-surface-light); border: 1px solid rgba(255, 255, 255, 0.06);">
                            <i class="bi bi-geo-alt-fill text-warning me-1"></i> {{ $order->catatan_alamat }}
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="text-muted small d-block">Metode Pembayaran:</label>
                    <div class="d-flex align-items-center gap-2 mt-1">
                        <span class="badge bg-warning text-dark text-uppercase fw-bold">{{ $order->metode_pembayaran }}</span>
                        @if($order->status_pembayaran === 'paid')
                            <span class="badge bg-success fw-bold"><i class="bi bi-check2-circle me-1"></i>LUNAS</span>
                        @else
                            <span class="badge bg-danger fw-bold"><i class="bi bi-hourglass-split me-1"></i>BELUM BAYAR</span>
                        @endif
                    </div>
                </div>

                @if($order->catatan_pesanan)
                    <div class="p-3 rounded-3" style="background-color: var(--kg-surface-light); border: 1px solid rgba(255, 255, 255, 0.06);">
                        <label class="text-muted small d-block"><i class="bi bi-chat-left-text me-1 text-warning"></i> Catatan untuk Barista:</label>
                        <span class="text-white small font-monospace">"{{ $order->catatan_pesanan }}"</span>
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>

@endsection
