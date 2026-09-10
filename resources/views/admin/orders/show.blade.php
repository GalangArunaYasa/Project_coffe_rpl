@extends('layouts.admin')

@section('title', 'Detail Transaksi #' . $order->order_code . ' - Admin Aruna Coffee')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-kg-outline btn-sm rounded-pill px-3 mb-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Monitoring Pesanan
    </a>
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <span class="badge rounded-pill px-3 py-1 mb-2 d-inline-block" style="background-color: var(--kg-surface-light); border: 1px solid var(--kg-accent); color: var(--kg-gold); font-size: 0.8rem;">
                <i class="bi bi-receipt me-1"></i> Rincian Invoice
            </span>
            <h1 class="h3 fw-extrabold text-white mb-0">Detail Transaksi #{{ $order->order_code }}</h1>
            <small class="text-muted">Tanggal: {{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB</small>
        </div>
        <a href="{{ route('order.receipt', $order->order_code) }}" target="_blank" class="btn btn-kg-accent rounded-pill px-4 fw-bold shadow">
            <i class="bi bi-printer me-1"></i> Cetak Struk / Invoice
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="adm-card p-4 shadow-sm mb-4">
            <h2 class="h5 fw-bold text-white mb-3">Item Pesanan</h2>

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
                    <span class="text-muted">Ongkir / Biaya Antar</span>
                    <span class="text-white">Rp {{ number_format($order->ongkir, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: var(--kg-border) !important;">
                    <span class="fw-bold text-white fs-5">TOTAL PEMBAYARAN</span>
                    <span class="fs-4 fw-extrabold text-warning">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Admin Quick Payment Status Action Panel -->
        <div class="adm-card p-4 shadow-sm mb-4">
            <h2 class="h5 fw-bold text-white mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-shield-check text-warning"></i> Kontrol Status Pembayaran
            </h2>

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 p-3 rounded-4" style="background-color: var(--kg-surface-light); border: 1px solid rgba(255, 255, 255, 0.05);">
                <div>
                    <span class="text-muted small d-block mb-1">Status Pembayaran Saat Ini:</span>
                    @if($order->status_pembayaran === 'paid')
                        <span class="badge bg-success fs-6 px-3 py-2 rounded-pill fw-bold">
                            <i class="bi bi-check2-circle me-1"></i> LUNAS (PAID)
                        </span>
                    @else
                        <span class="badge bg-danger fs-6 px-3 py-2 rounded-pill fw-bold">
                            <i class="bi bi-hourglass-split me-1"></i> BELUM BAYAR (UNPAID)
                        </span>
                    @endif
                </div>

                <form action="{{ route('admin.orders.updatePayment', $order->id) }}" method="POST" class="d-flex align-items-center gap-2">
                    @csrf
                    @if($order->status_pembayaran === 'paid')
                        <input type="hidden" name="status_pembayaran" value="unpaid">
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold" onclick="return confirm('Ubah status pembayaran menjadi Belum Bayar?')">
                            <i class="bi bi-x-circle me-1"></i> Set Belum Bayar
                        </button>
                    @else
                        <input type="hidden" name="status_pembayaran" value="paid">
                        <button type="submit" class="btn btn-success btn-sm rounded-pill px-4 fw-bold">
                            <i class="bi bi-check2-circle me-1"></i> Konfirmasi Lunas Sekarang
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="adm-card p-4 shadow-sm mb-4">
            <h2 class="h5 fw-bold text-white mb-3">Informasi Pelanggan & Status</h2>

            <div class="mb-3">
                <label class="text-muted small d-block">Status Pesanan:</label>
                <span class="badge {{ $order->status_badge_class }} fs-6 px-3 py-2 rounded-pill mt-1">
                    {{ $order->status_label }}
                </span>
            </div>

            <hr style="border-color: var(--kg-border);">

            <div class="small text-white">
                <div class="mb-2"><strong class="text-muted">Nama Pemesan:</strong> {{ $order->nama_pemesan }}</div>
                <div class="mb-2"><strong class="text-muted">No. Kontak/WA:</strong> {{ $order->nomor_kontak }}</div>
                <div class="mb-2">
                    <strong class="text-muted">Tipe Pesanan:</strong> 
                    <span class="badge bg-secondary">{{ $order->tipe_pesanan_label }}</span>
                </div>
                @if($order->catatan_alamat)
                    <div class="mb-2">
                        <strong class="text-muted">{{ $order->tipe_pesanan === 'dine_in' ? 'Meja Kafe:' : 'Alamat:' }}</strong> 
                        <span class="text-warning">{{ $order->catatan_alamat }}</span>
                    </div>
                @endif
                <div class="mb-2"><strong class="text-muted">Metode Bayar:</strong> <span class="badge bg-warning text-dark text-uppercase fw-bold">{{ $order->metode_pembayaran }}</span></div>
                <div class="mb-2">
                    <strong class="text-muted">Status Bayar:</strong>
                    @if($order->status_pembayaran === 'paid')
                        <span class="badge bg-success fw-bold">LUNAS</span>
                    @else
                        <span class="badge bg-danger fw-bold">BELUM BAYAR</span>
                    @endif
                </div>
                <div class="mb-2"><strong class="text-muted">Kasir / Handler:</strong> {{ $order->penjual ? $order->penjual->name : 'Customer Online' }}</div>
            </div>
        </div>
    </div>
</div>

@endsection
