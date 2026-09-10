@extends('layouts.app')

@section('title', 'Checkout Pembayaran - Aruna Coffee House')

@section('content')

<div class="container-fluid px-3 px-lg-4 py-3">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}" class="text-muted text-decoration-none">Keranjang</a></li>
            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">Checkout & Pembayaran</li>
        </ol>
    </nav>

    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <h1 class="h3 fw-extrabold text-white mb-0">
            <i class="bi bi-credit-card-2-front-fill me-2" style="color: var(--kg-accent);"></i> Form Checkout & Pembayaran
        </h1>
        <a href="{{ route('menu') }}" class="btn btn-sm btn-kg-outline rounded-pill px-3">
            <i class="bi bi-plus-lg me-1 text-warning"></i> Tambah Menu Lain
        </a>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
        @csrf

        <div class="row g-4">

            <!-- Left: Form Checkout Data -->
            <div class="col-lg-7">
                
                <!-- 1. Identitas Pemesan -->
                <div class="kg-card rounded-4 p-4 mb-4 shadow-sm">
                    <h2 class="h5 fw-bold text-white mb-3 d-flex align-items-center gap-2">
                        <span class="badge bg-warning text-dark rounded-circle fw-bold" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;">1</span>
                        Data Pemesan
                    </h2>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-white small fw-bold">Nama Lengkap Pemesan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pemesan" class="form-control kg-search-input rounded-3 py-2" value="{{ old('nama_pemesan', Auth::user()?->name) }}" placeholder="Contoh: Budi Santoso" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-white small fw-bold">Nomor WhatsApp / HP <span class="text-danger">*</span></label>
                            <input type="text" name="nomor_kontak" class="form-control kg-search-input rounded-3 py-2" value="{{ old('nomor_kontak') }}" placeholder="Contoh: 081234567890" required>
                        </div>
                    </div>
                </div>

                <!-- 2. Pilihan Tipe Pengambilan -->
                <div class="kg-card rounded-4 p-4 mb-4 shadow-sm">
                    <h2 class="h5 fw-bold text-white mb-3 d-flex align-items-center gap-2">
                        <span class="badge bg-warning text-dark rounded-circle fw-bold" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;">2</span>
                        Pilihan Tipe Pengambilan
                    </h2>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <input type="radio" class="btn-check" name="tipe_pesanan" id="tipeDineIn" value="dine_in" checked onchange="updateOngkir(0)">
                            <label class="btn btn-kg-outline w-100 rounded-3 p-3 text-start h-100" for="tipeDineIn">
                                <i class="bi bi-cup-straw fs-4 d-block mb-1 text-warning"></i>
                                <span class="fw-bold d-block text-white">Dine In (Kafe)</span>
                                <small class="text-muted">Minum di meja kafe</small>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <input type="radio" class="btn-check" name="tipe_pesanan" id="tipeTakeaway" value="takeaway" onchange="updateOngkir(0)">
                            <label class="btn btn-kg-outline w-100 rounded-3 p-3 text-start h-100" for="tipeTakeaway">
                                <i class="bi bi-bag-check fs-4 d-block mb-1 text-info"></i>
                                <span class="fw-bold d-block text-white">Takeaway</span>
                                <small class="text-muted">Bungkus & ambil di kasir</small>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <input type="radio" class="btn-check" name="tipe_pesanan" id="tipeDelivery" value="delivery" onchange="updateOngkir(5000)">
                            <label class="btn btn-kg-outline w-100 rounded-3 p-3 text-start h-100" for="tipeDelivery">
                                <i class="bi bi-scooter fs-4 d-block mb-1 text-success"></i>
                                <span class="fw-bold d-block text-white">Delivery (+5rb)</span>
                                <small class="text-muted">Antar radius kafe</small>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="form-label text-white small fw-bold">Nomor Meja Kafe / Alamat Pengantaran</label>
                        <textarea name="catatan_alamat" class="form-control kg-search-input rounded-3" rows="2" placeholder="Contoh: Meja No. 4 (Lantai 1) / Jl. Mawar No. 12 RT 01"></textarea>
                    </div>
                </div>

                <!-- 3. Metode Pembayaran Interaktif -->
                <div class="kg-card rounded-4 p-4 mb-4 shadow-sm">
                    <h2 class="h5 fw-bold text-white mb-3 d-flex align-items-center gap-2">
                        <span class="badge bg-warning text-dark rounded-circle fw-bold" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;">3</span>
                        Metode Pembayaran
                    </h2>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <input type="radio" class="btn-check" name="metode_pembayaran" id="payQris" value="qris" checked onchange="switchPaymentInfo('qris')">
                            <label class="btn btn-kg-outline w-100 rounded-3 p-3 text-start h-100" for="payQris">
                                <i class="bi bi-qr-code fs-4 d-block mb-1 text-warning"></i>
                                <span class="fw-bold d-block text-white">QRIS Instant</span>
                                <small class="text-muted">Gopay, OVO, Dana, BCA, dll</small>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <input type="radio" class="btn-check" name="metode_pembayaran" id="payCash" value="cash" onchange="switchPaymentInfo('cash')">
                            <label class="btn btn-kg-outline w-100 rounded-3 p-3 text-start h-100" for="payCash">
                                <i class="bi bi-cash-stack fs-4 d-block mb-1 text-success"></i>
                                <span class="fw-bold d-block text-white">Tunai (Cash)</span>
                                <small class="text-muted">Bayar di kasir kafe</small>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <input type="radio" class="btn-check" name="metode_pembayaran" id="payTransfer" value="transfer" onchange="switchPaymentInfo('transfer')">
                            <label class="btn btn-kg-outline w-100 rounded-3 p-3 text-start h-100" for="payTransfer">
                                <i class="bi bi-bank fs-4 d-block mb-1 text-info"></i>
                                <span class="fw-bold d-block text-white">Transfer Bank</span>
                                <small class="text-muted">BCA / Mandiri / BRI</small>
                            </label>
                        </div>
                    </div>

                    <!-- Panel Informasi Tambahan Metode Pembayaran -->
                    <div id="infoQris" class="p-3 rounded-4 mb-3" style="background-color: var(--kg-surface-light); border: 1px solid rgba(245, 158, 11, 0.3);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 bg-white rounded-3 shadow text-center" style="width: 70px; height: 70px;">
                                <i class="bi bi-qr-code text-dark fs-1"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-white small">QRIS Aruna Coffee House</div>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">NMID: ID10202600123 • Mendukung seluruh e-wallet & Mobile Banking</small>
                                <span class="badge bg-warning text-dark fw-bold mt-1" style="font-size: 0.65rem;">Scan & Konfirmasi Otomatis</span>
                            </div>
                        </div>
                    </div>

                    <div id="infoCash" class="p-3 rounded-4 mb-3 d-none" style="background-color: var(--kg-surface-light); border: 1px solid rgba(16, 185, 129, 0.3);">
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-cash-coin fs-2 text-success"></i>
                            <div>
                                <div class="fw-bold text-white small">Pembayaran Tunai di Kasir</div>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Silakan lakukan pembayaran langsung kepada kasir saat mengambil pesanan atau saat barista mengantarkan kopi ke meja Anda.</small>
                            </div>
                        </div>
                    </div>

                    <div id="infoTransfer" class="p-3 rounded-4 mb-3 d-none" style="background-color: var(--kg-surface-light); border: 1px solid rgba(59, 130, 246, 0.3);">
                        <div class="fw-bold text-white small mb-2"><i class="bi bi-bank me-1 text-info"></i> Rekening Resmi Aruna Coffee House:</div>
                        <div class="row g-2 small">
                            <div class="col-sm-6">
                                <div class="p-2 rounded-3 bg-dark border border-secondary text-white">
                                    <strong class="text-warning">BCA:</strong> 829-019-2026<br>
                                    <small class="text-muted">a/n Aruna Coffee House</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-2 rounded-3 bg-dark border border-secondary text-white">
                                    <strong class="text-info">Mandiri:</strong> 137-00-2910-2026<br>
                                    <small class="text-muted">a/n Aruna Coffee House</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="form-label text-white small fw-bold">Catatan Tambahan untuk Barista (Opsional)</label>
                        <input type="text" name="catatan_pesanan" class="form-control kg-search-input rounded-3 py-2" placeholder="Contoh: tolong seduh sedikit lebih panas ya">
                    </div>
                </div>

            </div>

            <!-- Right: Ringkasan Pesanan & Submit CTA -->
            <div class="col-lg-5">
                <div class="kg-card rounded-4 p-4 shadow-sm position-sticky" style="top: 90px;">
                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2" style="border-color: var(--kg-border) !important;">
                        <h2 class="h5 fw-bold text-white mb-0">Ringkasan Pesanan</h2>
                        <span class="badge bg-warning text-dark rounded-pill fw-bold">{{ array_sum(array_column($cart, 'jumlah')) }} Item</span>
                    </div>

                    <div class="mb-3 overflow-auto pe-1" style="max-height: 240px;">
                        @foreach($cart as $item)
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom" style="border-color: var(--kg-border) !important;">
                                <div class="me-2">
                                    <div class="fw-bold text-white small">{{ $item['nama'] }} <span class="text-warning">({{ $item['jumlah'] }}x)</span></div>
                                    <small class="text-muted d-block" style="font-size: 0.72rem;">
                                        {{ $item['ukuran'] ?? 'Reguler' }} • {{ $item['suhu'] ?? 'Es' }} ({{ $item['manis'] ?? 'Normal' }})
                                        @if(!empty($item['tambahan']))
                                            • <span class="text-info">{{ $item['tambahan'] }}</span>
                                        @endif
                                    </small>
                                    @if(!empty($item['catatan']))
                                        <small class="text-warning d-block" style="font-size: 0.7rem;">"{{ $item['catatan'] }}"</small>
                                    @endif
                                </div>
                                <span class="fw-bold text-white small text-nowrap">Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Subtotal Produk</span>
                        <span class="text-white small fw-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted small">Biaya Pengantaran / Layanan</span>
                        <span class="text-white small fw-semibold" id="labelOngkir">Rp 0</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top mb-4" style="border-color: var(--kg-border) !important;">
                        <span class="fw-bold text-white fs-6">TOTAL PEMBAYARAN</span>
                        <span class="fs-4 fw-extrabold text-warning" id="labelTotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="btn btn-kg-accent w-100 rounded-pill py-3 fw-bold fs-6 shadow d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-bag-check-fill"></i> Konfirmasi & Bayar Sekarang
                    </button>
                    
                    <small class="text-muted text-center d-block mt-3" style="font-size: 0.75rem;">
                        <i class="bi bi-shield-check text-success me-1"></i> Pesanan akan langsung masuk ke antrean racik barista kafe.
                    </small>
                </div>
            </div>

        </div>

    </form>

</div>

@push('scripts')
<script>
    const subtotal = {{ $subtotal }};

    function updateOngkir(ongkir) {
        const total = subtotal + ongkir;
        document.getElementById('labelOngkir').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(ongkir);
        document.getElementById('labelTotal').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }

    function switchPaymentInfo(method) {
        document.getElementById('infoQris').classList.add('d-none');
        document.getElementById('infoCash').classList.add('d-none');
        document.getElementById('infoTransfer').classList.add('d-none');

        if (method === 'qris') {
            document.getElementById('infoQris').classList.remove('d-none');
        } else if (method === 'cash') {
            document.getElementById('infoCash').classList.remove('d-none');
        } else if (method === 'transfer') {
            document.getElementById('infoTransfer').classList.remove('d-none');
        }
    }
</script>
@endpush

@endsection
