@extends('layouts.app')

@section('title', 'Kopi Susu Gula Aren - Kopi Gerobakan')

@section('content')

@php
    // Data dipindah ke sini biar markup di bawah tidak berulang-ulang.
    // Nantinya idealnya dari controller/database.
    $thumbnails = [1, 2, 3, 4];

    $ukuranOptions = [
        ['id' => 'reguler', 'label' => 'Reguler', 'sub' => '250 ml', 'checked' => true],
        ['id' => 'large',   'label' => 'Large',   'sub' => '350 ml', 'checked' => false],
    ];

    $manisOptions = [
        ['id' => 'less',   'label' => 'Less Sugar', 'sub' => '25%', 'checked' => false],
        ['id' => 'normal', 'label' => 'Normal',     'sub' => '50%', 'checked' => true],
        ['id' => 'extra',  'label' => 'Extra',      'sub' => '75%', 'checked' => false],
        ['id' => 'no',     'label' => 'No Sugar',   'sub' => '0%',  'checked' => false],
    ];

    $suhuOptions = [
        ['id' => 'es',    'label' => 'Es',    'icon' => 'bi-snow2', 'checked' => true],
        ['id' => 'panas', 'label' => 'Panas', 'icon' => 'bi-fire',  'checked' => false],
    ];

    $cartItems = [
        ['nama' => 'Kopi Susu Gula Aren', 'catatan' => 'Reguler - Es - Normal', 'harga' => 12000, 'gambar' => 'KS'],
        ['nama' => 'Cappuccino',          'catatan' => 'Reguler - Panas - Normal', 'harga' => 13000, 'gambar' => 'CP'],
        ['nama' => 'Roti Bakar Cokelat',  'catatan' => null, 'harga' => 10000, 'gambar' => 'RB'],
    ];

    $subtotal = array_sum(array_column($cartItems, 'harga'));
    $ongkir   = 4000;
    $total    = $subtotal + $ongkir;

    $rekomendasi = [
        ['nama' => 'Es Kopi Hitam',   'harga' => 9000,  'gambar' => 'Es+Kopi'],
        ['nama' => 'Cappuccino',      'harga' => 13000, 'gambar' => 'Cappuccino'],
        ['nama' => 'Kopi Latte',      'harga' => 13000, 'gambar' => 'Kopi+Latte'],
        ['nama' => 'Chocolate',       'harga' => 12000, 'gambar' => 'Chocolate'],
        ['nama' => 'Matcha Latte',    'harga' => 14000, 'gambar' => 'Matcha+Latte'],
    ];

    // Palet placeholder dibuat lebih cerah: krem terang dengan aksen cokelat.
    $imgBg     = 'f5efe6';
    $imgAccent = 'a8632f';
@endphp

<div class="container-fluid py-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/menu') }}" class="text-muted text-decoration-none">Menu Pesan</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/menu?kategori=kopi') }}" class="text-muted text-decoration-none">Kopi</a></li>
                <li class="breadcrumb-item active fw-semibold" aria-current="page">Kopi Susu Gula Aren</li>
            </ol>
        </div>
    </nav>

    <div class="row gy-4">

        <!-- Galeri Produk -->
        <div class="col-lg-5">
            <div class="position-relative mb-3">
                <span class="badge bg-light text-dark border position-absolute top-0 start-0 m-3 d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                    <i class="bi bi-star-fill text-warning"></i> 4.8
                    <span class="text-muted">| 234 terjual</span>
                </span>
                <img src="https://placehold.co/600x600/{{ $imgBg }}/{{ $imgAccent }}?text=Kopi+Susu+Gula+Aren"
                     class="img-fluid rounded-4 w-100" style="aspect-ratio: 1/1; object-fit: cover;"
                     alt="Kopi Susu Gula Aren">
            </div>

            <div class="d-flex gap-2 overflow-auto pb-1">
                @foreach ($thumbnails as $i)
                    <img src="https://placehold.co/100x100/{{ $imgBg }}/{{ $imgAccent }}?text={{ $i }}"
                         class="rounded-3 border {{ $loop->first ? 'border-2' : '' }}"
                         style="width: 80px; height: 80px; object-fit: cover; border-color: {{ $loop->first ? 'var(--kg-accent)' : 'var(--kg-border)' }} !important; cursor: pointer;"
                         alt="Thumbnail {{ $i }}">
                @endforeach
            </div>
        </div>

        <!-- Detail & Opsi -->
        <div class="col-lg-4">
            <h1 class="h3 fw-bold mb-2">Kopi Susu Gula Aren</h1>
            <p class="text-muted mb-3">
                Perpaduan kopi, susu segar dan gula aren asli. Manisnya pas, kopinya berasa.
            </p>
            <div class="fs-3 fw-bold mb-4" style="color: var(--kg-accent);">Rp 12.000</div>

            <!-- Ukuran -->
            <div class="mb-4">
                <label class="form-label fw-semibold small text-uppercase text-muted">Ukuran</label>
                <div class="d-flex gap-2">
                    @foreach ($ukuranOptions as $opt)
                        <input type="radio" class="btn-check" name="ukuran" id="ukuran-{{ $opt['id'] }}" autocomplete="off" @checked($opt['checked'])>
                        <label class="btn btn-outline-secondary rounded-3 px-4 py-2 text-start" for="ukuran-{{ $opt['id'] }}">
                            <span class="d-block fw-semibold">{{ $opt['label'] }}</span>
                            <small class="text-muted">{{ $opt['sub'] }}</small>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Level Manis -->
            <div class="mb-4">
                <label class="form-label fw-semibold small text-uppercase text-muted">Level Manis</label>
                <div class="d-flex gap-2 flex-wrap">
                    @foreach ($manisOptions as $opt)
                        <input type="radio" class="btn-check" name="manis" id="manis-{{ $opt['id'] }}" autocomplete="off" @checked($opt['checked'])>
                        <label class="btn btn-outline-secondary rounded-3 px-3 py-2 text-start" for="manis-{{ $opt['id'] }}">
                            <span class="d-block fw-semibold small">{{ $opt['label'] }}</span>
                            <small class="text-muted">{{ $opt['sub'] }}</small>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Es / Panas -->
            <div class="mb-4">
                <label class="form-label fw-semibold small text-uppercase text-muted">Es / Panas</label>
                <div class="d-flex gap-2">
                    @foreach ($suhuOptions as $opt)
                        <input type="radio" class="btn-check" name="suhu" id="suhu-{{ $opt['id'] }}" autocomplete="off" @checked($opt['checked'])>
                        <label class="btn btn-outline-secondary rounded-3 px-4 py-2 d-flex align-items-center gap-2" for="suhu-{{ $opt['id'] }}">
                            <i class="bi {{ $opt['icon'] }}"></i> {{ $opt['label'] }}
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Catatan -->
            <div class="mb-4">
                <label for="catatan" class="form-label fw-semibold small text-uppercase text-muted">Catatan (Opsional)</label>
                <textarea class="form-control kg-search-input rounded-3" id="catatan" rows="2" maxlength="100"
                          placeholder="Contoh: kurang manis, tanpa es, dll"></textarea>
                <small class="text-muted">0/100</small>
            </div>

            <!-- Qty & Tambah Keranjang -->
            <div class="d-flex align-items-center gap-3">
                <div class="input-group" style="width: 130px;">
                    <button class="btn btn-outline-secondary" type="button"><i class="bi bi-dash"></i></button>
                    <input type="text" class="form-control text-center kg-search-input" value="1" readonly>
                    <button class="btn btn-outline-secondary" type="button"><i class="bi bi-plus"></i></button>
                </div>
                <button class="btn btn-kg-accent flex-grow-1 rounded-3 py-2 fw-semibold">
                    <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                </button>
            </div>
        </div>

        <!-- Pesanan Kamu -->
        <div class="col-lg-3">
            <div class="card kg-card rounded-4 position-sticky" style="top: 90px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="h5 fw-bold mb-0">Pesanan Kamu</h2>
                        <span class="badge btn-kg-accent rounded-pill">{{ count($cartItems) }}</span>
                    </div>

                    @foreach ($cartItems as $item)
                        <div class="d-flex gap-2 mb-3">
                            <img src="https://placehold.co/60x60/{{ $imgBg }}/{{ $imgAccent }}?text={{ $item['gambar'] }}"
                                 class="rounded-3" style="width: 52px; height: 52px; object-fit: cover;" alt="{{ $item['nama'] }}">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="small fw-semibold">{{ $item['nama'] }}</div>
                                    <button class="btn btn-sm btn-link text-danger p-0"><i class="bi bi-trash"></i></button>
                                </div>
                                @if ($item['catatan'])
                                    <small class="text-muted d-block mb-1">{{ $item['catatan'] }}</small>
                                @endif
                                <div class="d-flex align-items-center justify-content-between {{ $item['catatan'] ? '' : 'mt-1' }}">
                                    <span class="small fw-semibold">Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
                                    <div class="input-group input-group-sm" style="width: 90px;">
                                        <button class="btn btn-outline-secondary btn-sm" type="button"><i class="bi bi-dash"></i></button>
                                        <input type="text" class="form-control text-center kg-search-input p-0" value="1" readonly>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"><i class="bi bi-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <hr style="border-color: var(--kg-border);">

                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="small text-muted">Subtotal</span>
                        <span class="small">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="small text-muted">Ongkir</span>
                        <span class="small">Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                    </div>

                    <hr style="border-color: var(--kg-border);">

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold fs-5" style="color: var(--kg-accent);">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ url('/checkout') }}" class="btn btn-kg-accent w-100 rounded-3 py-2 fw-semibold mb-3">
                        Lanjut ke Pembayaran <i class="bi bi-arrow-right"></i>
                    </a>

                    <div class="alert alert-light border kg-card rounded-3 d-flex gap-2 mb-0 py-2 px-3">
                        <i class="bi bi-info-circle mt-1"></i>
                        <div class="small">
                            <div>Pengantaran dalam radius 3 km</div>
                            <div class="text-muted">Estimasi sampai 20 - 30 menit</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Kamu Mungkin Juga Suka -->
    <section class="mt-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="h4 fw-bold mb-0">
                <i class="bi bi-cup-straw me-1" style="color: var(--kg-accent);"></i> Kamu Mungkin Juga Suka
            </h2>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 34px; height: 34px;">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 34px; height: 34px;">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>

        <div class="row row-cols-2 row-cols-md-5 g-3">
            @foreach ($rekomendasi as $item)
                <div class="col">
                    <div class="card kg-card rounded-4 h-100">
                        <img src="https://placehold.co/300x300/{{ $imgBg }}/{{ $imgAccent }}?text={{ $item['gambar'] }}"
                             class="card-img-top rounded-top-4" alt="{{ $item['nama'] }}">
                        <div class="card-body">
                            <h3 class="h6 fw-semibold mb-2">{{ $item['nama'] }}</h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fw-semibold small">Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
                                <button class="btn btn-kg-accent btn-sm rounded-circle" style="width: 30px; height: 30px;">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>

@endsection