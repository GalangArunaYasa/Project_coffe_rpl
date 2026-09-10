@extends('layouts.penjual')

@section('title', 'Detail Pesanan: ' . $order->order_code . ' - Aruna Coffee')

@section('content')

<div class="mb-4">
    <a href="{{ route('penjual.orders.index') }}" class="btn btn-kg-outline btn-sm rounded-pill px-3 mb-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Antrean Pesanan
    </a>
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <span class="badge rounded-pill px-3 py-1 mb-2 d-inline-block" style="background-color: var(--kg-surface-light); border: 1px solid var(--kg-accent); color: var(--kg-gold); font-size: 0.8rem;">
                <i class="bi bi-receipt me-1"></i> Rincian Pesanan
            </span>
            <h1 class="h3 fw-extrabold text-white mb-0">Detail Pesanan #{{ $order->order_code }}</h1>
            <small class="text-muted">Masuk pada: {{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('order.receipt', $order->order_code) }}" target="_blank" class="btn btn-kg-accent rounded-pill px-4 fw-bold shadow">
                <i class="bi bi-printer me-1"></i> Cetak Struk
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    
    <!-- Item Menu -->
    <div class="col-lg-8">
        <div class="pos-card p-4 shadow-sm mb-4">
            <h2 class="h5 fw-bold text-white mb-3">Daftar Item Menu</h2>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Kustomisasi</th>
                            <th>Harga Satuan</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $it)
                            <tr>
                                <td class="fw-bold text-white">{{ $it->nama_produk }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $it->ukuran }}</span>
                                    <span class="badge {{ $it->suhu === 'Es' ? 'bg-info text-dark' : 'bg-danger' }}">{{ $it->suhu }}</span>
                                    <span class="badge bg-dark border border-secondary text-white">{{ $it->manis }}</span>
                                    @if($it->tambahan)
                                        <span class="badge bg-warning text-dark">{{ $it->tambahan }}</span>
                                    @endif
                                    @if($it->catatan_khusus)
                                        <small class="text-warning d-block mt-1">"{{ $it->catatan_khusus }}"</small>
                                    @endif
                                </td>
                                <td class="text-white">Rp {{ number_format($it->harga_satuan, 0, ',', '.') }}</td>
                                <td class="text-center fw-bold text-warning">{{ $it->jumlah }}</td>
                                <td class="text-end fw-bold text-white">Rp {{ number_format($it->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pt-3 mt-3 border-top" style="border-color: var(--kg-border) !important;">
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Subtotal Produk</span>
                    <span class="text-white">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Biaya Pengantaran</span>
                    <span class="text-white">Rp {{ number_format($order->ongkir, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: var(--kg-border) !important;">
                    <span class="fw-bold text-white fs-5">TOTAL TAGIHAN</span>
                    <span class="fs-4 fw-extrabold text-warning">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Panel Konfirmasi Pembayaran Kasir -->
        <div class="pos-card p-4 shadow-sm mb-4">
            <h2 class="h5 fw-bold text-white mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-wallet2 text-warning"></i> Kelola Status Pembayaran
            </h2>

            <div class="row align-items-center g-3">
                <div class="col-md-6">
                    <div class="p-3 rounded-4" style="background-color: var(--kg-surface-light); border: 1px solid rgba(255, 255, 255, 0.06);">
                        <div class="text-muted small mb-1">Status Pembayaran Saat Ini:</div>
                        @if($order->status_pembayaran === 'paid')
                            <span class="badge bg-success fs-6 px-3 py-2 rounded-pill fw-bold">
                                <i class="bi bi-check2-circle me-1"></i> LUNAS (PAID)
                            </span>
                            @if($order->uang_diterima)
                                <div class="small text-muted mt-2">
                                    <div>Diterima: <strong class="text-white">Rp {{ number_format($order->uang_diterima, 0, ',', '.') }}</strong></div>
                                    <div>Kembalian: <strong class="text-warning">Rp {{ number_format($order->uang_kembalian, 0, ',', '.') }}</strong></div>
                                </div>
                            @endif
                        @else
                            <span class="badge bg-danger fs-6 px-3 py-2 rounded-pill fw-bold">
                                <i class="bi bi-hourglass-split me-1"></i> BELUM BAYAR (UNPAID)
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <form action="{{ route('penjual.orders.updatePayment', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label text-white small fw-bold">Ubah Status Pembayaran:</label>
                            <select name="status_pembayaran" class="form-select form-select-sm kg-search-input rounded-3 mb-2" id="selectPaymentStatus">
                                <option value="paid" @selected($order->status_pembayaran === 'paid')>Lunas (Paid)</option>
                                <option value="unpaid" @selected($order->status_pembayaran === 'unpaid')>Belum Bayar (Unpaid)</option>
                            </select>
                        </div>

                        <div class="mb-2" id="cashInputContainer">
                            <label class="form-label text-white small">Uang Tunai Diterima (Opsional):</label>
                            <input type="number" name="uang_diterima" value="{{ $order->uang_diterima ?? $order->total_harga }}" class="form-control form-control-sm kg-search-input rounded-3" placeholder="Nominal uang tunai...">
                        </div>

                        <button type="submit" class="btn btn-kg-accent btn-sm rounded-pill px-4 fw-bold w-100">
                            <i class="bi bi-check-circle me-1"></i> Simpan Status Bayar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Status & Data Pelanggan -->
    <div class="col-lg-4">
        <div class="pos-card p-4 shadow-sm mb-4">
            <h2 class="h5 fw-bold text-white mb-3">Status Pesanan</h2>

            <div class="mb-3">
                <label class="text-muted small d-block">Status Tahapan Saat Ini:</label>
                <span class="badge {{ $order->status_badge_class }} fs-6 px-3 py-2 rounded-pill mt-1">
                    {{ $order->status_label }}
                </span>
            </div>

            <form action="{{ route('penjual.orders.updateStatus', $order->id) }}" method="POST" class="mb-3">
                @csrf
                <label class="form-label text-white small fw-bold">Update Tahapan Pesanan:</label>
                <div class="input-group">
                    <select name="status" class="form-select form-select-sm kg-search-input rounded-start-3">
                        <option value="menunggu_konfirmasi" @selected($order->status === 'menunggu_konfirmasi')>Menunggu Konfirmasi</option>
                        <option value="diproses" @selected($order->status === 'diproses')>Sedang Diracik Barista</option>
                        <option value="siap_diambil" @selected($order->status === 'siap_diambil')>
                            @if($order->tipe_pesanan === 'takeaway')
                                Siap Diambil di Kasir
                            @elseif($order->tipe_pesanan === 'dine_in')
                                Siap Diantar ke Meja
                            @elseif($order->tipe_pesanan === 'delivery')
                                Sedang Diantar ke Alamat
                            @else
                                Siap Diambil / Diantar
                            @endif
                        </option>
                        <option value="selesai" @selected($order->status === 'selesai')>Selesai</option>
                        <option value="dibatalkan" @selected($order->status === 'dibatalkan')>Dibatalkan</option>
                    </select>
                    <button type="submit" class="btn btn-kg-accent btn-sm rounded-end-3 fw-bold">Update</button>
                </div>
            </form>

            <hr style="border-color: var(--kg-border);">

            <div class="small text-white">
                <div class="mb-2"><strong class="text-muted">Nama Pemesan:</strong> {{ $order->nama_pemesan }}</div>
                <div class="mb-2"><strong class="text-muted">No. Kontak/WA:</strong> {{ $order->nomor_kontak }}</div>
                <div class="mb-2">
                    <strong class="text-muted">Metode Pengambilan:</strong> 
                    <span class="badge bg-secondary">{{ $order->tipe_pesanan_label }}</span>
                </div>
                @if($order->catatan_alamat)
                    <div class="mb-2">
                        <strong class="text-muted">{{ $order->tipe_pesanan === 'dine_in' ? 'Meja Kafe:' : 'Alamat:' }}</strong> 
                        <span class="text-warning">{{ $order->catatan_alamat }}</span>
                    </div>
                @endif
                <div class="mb-2"><strong class="text-muted">Metode Bayar:</strong> <span class="badge bg-warning text-dark text-uppercase fw-bold">{{ $order->metode_pembayaran }}</span></div>
                @if($order->catatan_pesanan)
                    <div class="mt-3 p-2 rounded-3" style="background-color: var(--kg-surface-light);">
                        <small class="text-muted d-block">Catatan Barista:</small>
                        <span class="font-monospace small text-white">"{{ $order->catatan_pesanan }}"</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
