@extends('layouts.app')

@section('title', 'Keranjang Belanja - Aruna Coffee House')

@section('content')

<div class="container-fluid px-3 px-lg-5 py-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('menu') }}" class="text-muted text-decoration-none">Menu Kopi</a></li>
            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">Keranjang Belanja</li>
        </ol>
    </nav>

    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <h1 class="h3 fw-extrabold text-white mb-0">
            <i class="bi bi-bag-heart-fill me-2" style="color: var(--kg-accent);"></i> Keranjang Pesanan Kamu
        </h1>
        @if(count($cart) > 0)
            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan seluruh isi keranjang?')">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                    <i class="bi bi-trash3 me-1"></i> Kosongkan Keranjang
                </button>
            </form>
        @endif
    </div>

    @if(count($cart) > 0)
        <div class="row g-4">
            
            <!-- Items List -->
            <div class="col-lg-8">
                <div class="kg-card rounded-4 p-3 p-md-4 shadow-sm mb-4">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Menu</th>
                                    <th>Kustomisasi</th>
                                    <th>Harga</th>
                                    <th class="text-center" style="width: 140px;">Jumlah</th>
                                    <th class="text-end">Subtotal</th>
                                    <th class="text-center" style="width: 50px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $key => $item)
                                    @php
                                        $cImg = $item['gambar'] ?? null;
                                        if ($cImg && (Str::startsWith($cImg, 'http://') || Str::startsWith($cImg, 'https://'))) {
                                            $cUrl = $cImg;
                                        } elseif ($cImg && Str::startsWith($cImg, 'images/')) {
                                            $cUrl = asset($cImg);
                                        } elseif ($cImg) {
                                            $cUrl = asset('storage/' . $cImg);
                                        } else {
                                            $cUrl = asset('images/products/kopi-susu-gula-aren.jpg');
                                        }
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $cUrl }}" alt="{{ $item['nama'] }}" class="rounded-3 shadow-sm" style="width: 54px; height: 54px; object-fit: cover;">
                                                <div>
                                                    <div class="fw-bold text-white fs-6">{{ $item['nama'] }}</div>
                                                    <small class="text-muted text-uppercase" style="font-size: 0.7rem;">{{ $item['kategori'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                <span class="badge bg-secondary" style="font-size: 0.7rem;">{{ $item['ukuran'] ?? 'Reguler' }}</span>
                                                <span class="badge {{ ($item['suhu'] ?? 'Es') === 'Es' ? 'bg-info text-dark' : 'bg-danger' }}" style="font-size: 0.7rem;">{{ $item['suhu'] ?? 'Es' }}</span>
                                                <span class="badge bg-dark border border-secondary text-white" style="font-size: 0.7rem;">{{ $item['manis'] ?? 'Normal' }}</span>
                                                @if(!empty($item['tambahan']))
                                                    <span class="badge bg-warning text-dark fw-bold" style="font-size: 0.7rem;">{{ $item['tambahan'] }}</span>
                                                @endif
                                            </div>
                                            @if(!empty($item['catatan']))
                                                <small class="text-warning d-block mt-1" style="font-size: 0.75rem;">
                                                    <i class="bi bi-chat-left-text me-1"></i> "{{ $item['catatan'] }}"
                                                </small>
                                            @endif
                                        </td>
                                        <td class="fw-semibold text-white">
                                            Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                <form action="{{ route('cart.update', $key) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="minus">
                                                    <button type="submit" class="btn btn-kg-outline btn-sm rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 30px; height: 30px;">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                </form>

                                                <span class="fw-bold text-white px-2">{{ $item['jumlah'] }}</span>

                                                <form action="{{ route('cart.update', $key) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="plus">
                                                    <button type="submit" class="btn btn-kg-outline btn-sm rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 30px; height: 30px;">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="text-end fw-bold text-white fs-6">
                                            Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('cart.remove', $key) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-link text-danger p-0" title="Hapus dari keranjang">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top" style="border-color: var(--kg-border) !important;">
                        <a href="{{ route('menu') }}" class="btn btn-kg-outline rounded-pill px-4">
                            <i class="bi bi-arrow-left me-1"></i> Tambah Menu Lain
                        </a>
                    </div>
                </div>
            </div>

            <!-- Summary & Checkout CTA -->
            <div class="col-lg-4">
                <div class="kg-card rounded-4 p-4 shadow-sm position-sticky" style="top: 90px;">
                    <h2 class="h5 fw-bold text-white mb-3">Ringkasan Pembelian</h2>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Menu ({{ array_sum(array_column($cart, 'jumlah')) }} pcs)</span>
                        <span class="text-white fw-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Biaya Layanan / Antar</span>
                        <span class="text-success fw-semibold">Disesuaikan di Checkout</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top mb-4" style="border-color: var(--kg-border) !important;">
                        <span class="fw-bold text-white fs-6">SUBTOTAL</span>
                        <span class="fs-4 fw-extrabold text-warning">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-kg-accent w-100 rounded-pill py-3 fw-bold fs-6 shadow d-flex align-items-center justify-content-center gap-2">
                        Lanjut ke Pembayaran <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>
    @else
        <div class="kg-card rounded-4 p-5 text-center my-4">
            <div class="avatar-initial mx-auto mb-3" style="width: 72px; height: 72px; font-size: 2rem;">
                <i class="bi bi-cart-x"></i>
            </div>
            <h2 class="h4 fw-bold text-white mb-2">Keranjang Belanja Masih Kosong</h2>
            <p class="text-muted mb-4" style="max-width: 480px; margin: 0 auto;">Kamu belum menambahkan kopi atau makanan apapun ke dalam keranjang. Yuk cari menu favoritmu sekarang!</p>
            <a href="{{ route('menu') }}" class="btn btn-kg-accent rounded-pill px-5 py-3 fw-bold shadow">
                <i class="bi bi-grid-fill me-2"></i> Eksplorasi Menu Kopi
            </a>
        </div>
    @endif

</div>

@endsection
