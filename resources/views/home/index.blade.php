@extends('layouts.app')

@section('title', 'Kopi Aruna - Kopi Nikmat, Harga Bersahabat')

@section('content')

<div class="container-fluid px-3 px-lg-4 py-3">

    <!-- 1. Hero Section (Matching Reference Picture) -->
    <section class="kg-card rounded-4 p-4 p-lg-5 mb-4 position-relative overflow-hidden" style="background: radial-gradient(ellipse at top right, #241913 0%, #120e0c 100%); border: 1px solid rgba(255, 255, 255, 0.08);">
        <div class="row align-items-center gy-4">
            
            <!-- Left Hero Content -->
            <div class="col-lg-7">
                <h1 class="display-4 fw-extrabold text-white mb-2" style="letter-spacing: -0.02em; line-height: 1.15;">
                    Kopi Nikmat,<br>
                    <span style="color: var(--kg-accent);">Harga Bersahabat.</span>
                </h1>

                <p class="mb-4" style="color: #948b85; font-size: 0.98rem; line-height: 1.6; max-width: 480px;">
                    Kopi berkualitas, rasa premium, harga tetap ramah di kantong. Pesan sekarang, nikmati dimana saja!
                </p>

                <div class="d-flex flex-wrap gap-3 mb-4 pb-2">
                    <a href="{{ route('menu') }}" class="btn btn-kg-accent px-4 py-2 fw-semibold d-flex align-items-center gap-2">
                        Pesan Sekarang <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ route('menu') }}" class="btn btn-kg-outline px-4 py-2 fw-semibold">
                        Lihat Menu
                    </a>
                </div>

                <!-- 3 Feature Badges -->
                <div class="d-flex flex-wrap gap-4 pt-3 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: #261a14; border: 1px solid rgba(180, 123, 77, 0.3); color: var(--kg-accent);">
                            <i class="bi bi-cup-hot fs-6"></i>
                        </div>
                        <div>
                            <div class="fw-semibold text-white small lh-sm">Rasa Premium</div>
                            <div style="color: #756c66; font-size: 0.72rem;">Biji pilihan terbaik</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: #261a14; border: 1px solid rgba(180, 123, 77, 0.3); color: var(--kg-accent);">
                            <i class="bi bi-scooter fs-6"></i>
                        </div>
                        <div>
                            <div class="fw-semibold text-white small lh-sm">Pesan & Antar</div>
                            <div style="color: #756c66; font-size: 0.72rem;">Cepat sampai tujuan</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: #261a14; border: 1px solid rgba(180, 123, 77, 0.3); color: var(--kg-accent);">
                            <i class="bi bi-wallet2 fs-6"></i>
                        </div>
                        <div>
                            <div class="fw-semibold text-white small lh-sm">Pembayaran Mudah</div>
                            <div style="color: #756c66; font-size: 0.72rem;">Banyak metode bayar</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Hero Image Showcase -->
            <div class="col-lg-5 text-center">
                <div class="rounded-4 overflow-hidden shadow-lg border position-relative" style="border-color: rgba(255, 255, 255, 0.08); background: #17120f;">
                    <img src="{{ asset('images/hero_coffee_bar.jpg') }}" alt="Kopi Aruna Coffee Bar" class="img-fluid w-100" style="max-height: 330px; object-fit: cover;">
                </div>
            </div>

        </div>
    </section>

    <!-- 2. Main Content Row: Menu Populer Grid (Left) & Pesanan Kamu Widget (Right) -->
    <div class="row g-4">
        
        <!-- Left: Menu Populer Cards Grid -->
        <div class="col-lg-8">
            
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-cup-hot" style="color: var(--kg-accent); font-size: 1.15rem;"></i>
                    <h2 class="h6 fw-bold text-white mb-0">Menu Populer</h2>
                </div>
                <a href="{{ route('menu') }}" class="btn btn-sm btn-kg-outline rounded-pill px-3 py-1" style="font-size: 0.78rem;">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3 mb-4">
                @forelse ($rekomendasi as $item)
                    @php
                        $imgPath = $item->gambar;
                        if ($imgPath && (Str::startsWith($imgPath, 'http://') || Str::startsWith($imgPath, 'https://'))) {
                            $imgUrl = $imgPath;
                        } elseif ($imgPath && Str::startsWith($imgPath, 'images/')) {
                            $imgUrl = asset($imgPath);
                        } elseif ($imgPath) {
                            $imgUrl = asset('storage/' . $imgPath);
                        } else {
                            $imgUrl = asset('images/products/kopi-susu-gula-aren.jpg');
                        }
                    @endphp

                    <div class="col">
                        <div class="card kg-card kg-card-hover rounded-4 h-100 p-3 position-relative d-flex flex-column justify-content-between" 
                             style="background: #14100e; border: 1px solid rgba(255, 255, 255, 0.06);">
                            
                            @if($item->is_bestseller || $item->tag)
                                <span class="badge position-absolute top-0 start-0 m-2 fw-semibold rounded-pill shadow px-2 py-1" style="background: var(--kg-accent-gradient); color: #fff; font-size: 0.62rem; z-index: 2;">
                                    <i class="bi bi-star-fill me-1"></i> {{ $item->is_bestseller ? 'Populer' : $item->tag }}
                                </span>
                            @endif

                            <!-- Klik kartu membuka halaman detail seperti Shopee -->
                            <a href="{{ route('menu.show', $item->id) }}" class="text-decoration-none d-block">
                                <div class="text-center mb-3 overflow-hidden rounded-3" style="background: #0d0a08;">
                                    <img src="{{ $imgUrl }}" class="w-100 rounded-3" style="height: 135px; object-fit: cover;" alt="{{ $item->nama }}">
                                </div>

                                <div class="fw-bold text-white small mb-1 text-truncate" title="{{ $item->nama }}">{{ $item->nama }}</div>
                                <p class="mb-2" style="color: #948b85; font-size: 0.72rem; line-height: 1.35; min-height: 28px;">
                                    {{ Str::limit($item->deskripsi, 46) }}
                                </p>
                            </a>

                            <!-- Bagian Bawah: Harga & Tombol Pesan Langsung Membuka Pilihan Varian -->
                            <div class="d-flex align-items-center justify-content-between pt-2 mt-1" style="border-top: 1px solid rgba(255, 255, 255, 0.06);">
                                <a href="{{ route('menu.show', $item->id) }}" class="fw-bold text-white small text-decoration-none" style="font-size: 0.9rem;">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </a>

                                @if($item->stok > 0)
                                    <!-- Menekan tombol plus langsung membuka popup pilihan kustom & varian -->
                                    <button type="button" class="rounded-circle d-flex align-items-center justify-content-center border-0 text-white" 
                                            style="width: 30px; height: 30px; background: #2a1d17; transition: all 0.2s;" 
                                            data-bs-toggle="modal" data-bs-target="#quickOrderModal{{ $item->id }}" 
                                            title="Pesan & Kustomisasi Varian">
                                        <i class="bi bi-plus fs-5"></i>
                                    </button>
                                @else
                                    <span class="badge bg-danger rounded-pill" style="font-size: 0.62rem;">Habis</span>
                                @endif
                            </div>

                        </div>
                    </div>

                    <!-- Quick Order Modal (Muncul saat user menekan tombol pesan / +) -->
                    <div class="modal fade" id="quickOrderModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content kg-card text-white rounded-4 border overflow-hidden" style="border-color: rgba(255, 255, 255, 0.1);">
                                <form action="{{ route('cart.add') }}" method="POST" id="quickForm{{ $item->id }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->id }}">

                                    <div class="modal-header border-bottom p-3 px-4" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge rounded-pill text-uppercase px-2 py-1" style="background: #382419; color: var(--kg-accent); font-size: 0.68rem; border: 1px solid rgba(180, 123, 77, 0.3);">{{ $item->kategori }}</span>
                                            <h5 class="modal-title fw-bold text-white mb-0">{{ $item->nama }}</h5>
                                        </div>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body p-4">
                                        <div class="row g-4">
                                            
                                            <!-- Product Image & Live Price Box -->
                                            <div class="col-md-5 text-center">
                                                <div class="rounded-4 overflow-hidden mb-3 border shadow" style="border-color: rgba(255, 255, 255, 0.08); background: #0d0a08;">
                                                    <img src="{{ $imgUrl }}" class="w-100" style="height: 200px; object-fit: cover;" alt="{{ $item->nama }}">
                                                </div>

                                                <!-- Real-Time Price Display Box inside Modal -->
                                                <div class="p-3 rounded-3 text-start mb-2" style="background-color: #1a1410; border: 1px solid rgba(255, 255, 255, 0.06);">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <span style="color: #948b85;" class="small">Harga Satuan:</span>
                                                        <span class="fw-bold" style="color: var(--kg-accent);" id="quickUnitPrice{{ $item->id }}">
                                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                                        </span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center pt-1 border-top" style="border-color: rgba(255, 255, 255, 0.06) !important;">
                                                        <span class="text-white small fw-bold">Total Harga:</span>
                                                        <span class="fs-5 fw-extrabold text-white" id="quickTotalPrice{{ $item->id }}">
                                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <small class="d-block {{ $item->stok > 0 ? 'text-success' : 'text-danger' }} fw-semibold">
                                                    <i class="bi bi-box-seam me-1"></i> Sisa Stok: {{ $item->stok }} pcs
                                                </small>
                                            </div>

                                            <!-- Dynamic Customization Options Based on Category -->
                                            <div class="col-md-7">
                                                <p class="small mb-3" style="color: #b5aba4; line-height: 1.5;">
                                                    {{ $item->deskripsi }}
                                                </p>

                                                @php
                                                    $isCoffee = in_array(strtolower($item->kategori), ['kopi', 'signature', 'espresso']);
                                                    $isSnack = in_array(strtolower($item->kategori), ['snack', 'makanan', 'pastry']);
                                                    $isNonCoffee = in_array(strtolower($item->kategori), ['non-kopi', 'tea', 'matcha', 'chocolate']);
                                                @endphp                                                @if($isCoffee)
                                                    <!-- Pilihan Khusus Minuman Kopi -->
                                                    <div class="mb-3">
                                                        <label class="form-label text-white small fw-bold"><i class="bi bi-thermometer-half text-warning me-1"></i> 1. Suhu Penyajian</label>
                                                        <div class="d-flex gap-2">
                                                            <input type="radio" class="btn-check" name="suhu" id="h_suhuIce{{ $item->id }}" value="Es" checked onchange="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                            <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="h_suhuIce{{ $item->id }}">
                                                                <i class="bi bi-snow me-1 text-info"></i> Dingin
                                                            </label>
                                                            <input type="radio" class="btn-check" name="suhu" id="h_suhuHot{{ $item->id }}" value="Panas" onchange="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                            <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="h_suhuHot{{ $item->id }}">
                                                                <i class="bi bi-fire me-1 text-danger"></i> Hangat
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-white small fw-bold"><i class="bi bi-droplet-half text-warning me-1"></i> 2. Takaran Gula</label>
                                                        <div class="row g-2">
                                                            <div class="col-4">
                                                                <input type="radio" class="btn-check" name="manis" id="h_manisNorm{{ $item->id }}" value="Gula Normal" checked onchange="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                                <label class="btn btn-kg-outline w-100 rounded-3 py-1 small text-nowrap" for="h_manisNorm{{ $item->id }}">Normal</label>
                                                            </div>
                                                            <div class="col-4">
                                                                <input type="radio" class="btn-check" name="manis" id="h_manisLess{{ $item->id }}" value="Sedikit Gula" onchange="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                                <label class="btn btn-kg-outline w-100 rounded-3 py-1 small text-nowrap" for="h_manisLess{{ $item->id }}">Sedikit Gula</label>
                                                            </div>
                                                            <div class="col-4">
                                                                <input type="radio" class="btn-check" name="manis" id="h_manisNo{{ $item->id }}" value="Non Gula" onchange="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                                <label class="btn btn-kg-outline w-100 rounded-3 py-1 small text-nowrap" for="h_manisNo{{ $item->id }}">Non Gula</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Ukuran Cup dengan Tambahan Harga Otomatis -->
                                                    <div class="mb-3">
                                                        <label class="form-label text-white small fw-bold"><i class="bi bi-cup text-warning me-1"></i> 3. Ukuran Cup</label>
                                                        <div class="d-flex gap-2">
                                                            <input type="radio" class="btn-check" name="ukuran" id="h_sizeReg{{ $item->id }}" value="Reguler" data-price-extra="0" checked onchange="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                            <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="h_sizeReg{{ $item->id }}">Reguler</label>
                                                            <input type="radio" class="btn-check" name="ukuran" id="h_sizeLrg{{ $item->id }}" value="Large" data-price-extra="3000" onchange="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                            <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="h_sizeLrg{{ $item->id }}">Large (+3rb)</label>
                                                        </div>
                                                    </div>

                                                @elseif($isSnack)
                                                    <!-- Pilihan Khusus Makanan / Camilan -->
                                                    <div class="mb-3">
                                                        <label class="form-label text-white small fw-bold"><i class="bi bi-fire text-warning me-1"></i> 1. Cara Penyajian</label>
                                                        <div class="d-flex gap-2">
                                                            <input type="radio" class="btn-check" name="suhu" id="h_snackWarm{{ $item->id }}" value="Dipanaskan (Toasted)" checked onchange="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                            <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="h_snackWarm{{ $item->id }}">
                                                                <i class="bi bi-fire me-1 text-warning"></i> Dipanaskan
                                                            </label>
                                                            <input type="radio" class="btn-check" name="suhu" id="h_snackNorm{{ $item->id }}" value="Suhu Ruang" onchange="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                            <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="h_snackNorm{{ $item->id }}">
                                                                Suhu Ruang
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-white small fw-bold"><i class="bi bi-plus-circle text-warning me-1"></i> 2. Pilihan Topping</label>
                                                        <div class="d-flex gap-2">
                                                            <input type="radio" class="btn-check" name="tambahan" id="h_topOrig{{ $item->id }}" value="Original" data-price-extra="0" checked onchange="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                            <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="h_topOrig{{ $item->id }}">Original</label>
                                                            <input type="radio" class="btn-check" name="tambahan" id="h_topExtra{{ $item->id }}" value="Ekstra Keju/Topping" data-price-extra="4000" onchange="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                            <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="h_topExtra{{ $item->id }}">Ekstra Keju (+4rb)</label>
                                                        </div>
                                                    </div>

                                                @else
                                                    <!-- Pilihan Khusus Non-Kopi -->
                                                    <div class="mb-3">
                                                        <label class="form-label text-white small fw-bold"><i class="bi bi-thermometer-half text-warning me-1"></i> 1. Suhu Minuman</label>
                                                        <div class="d-flex gap-2">
                                                            <input type="radio" class="btn-check" name="suhu" id="h_nkIce{{ $item->id }}" value="Es" checked onchange="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                            <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="h_nkIce{{ $item->id }}">
                                                                <i class="bi bi-snow me-1 text-info"></i> Dingin
                                                            </label>
                                                            <input type="radio" class="btn-check" name="suhu" id="h_nkHot{{ $item->id }}" value="Panas" onchange="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                            <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="h_nkHot{{ $item->id }}">
                                                                <i class="bi bi-fire me-1 text-danger"></i> Hangat
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-white small fw-bold"><i class="bi bi-droplet-half text-warning me-1"></i> 2. Tingkat Manis</label>
                                                        <div class="row g-2">
                                                            <div class="col-4">
                                                                <input type="radio" class="btn-check" name="manis" id="h_nkNorm{{ $item->id }}" value="Normal Sweet" checked onchange="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                                <label class="btn btn-kg-outline w-100 rounded-3 py-1 small text-nowrap" for="h_nkNorm{{ $item->id }}">Normal</label>
                                                            </div>
                                                            <div class="col-4">
                                                                <input type="radio" class="btn-check" name="manis" id="h_nkLess{{ $item->id }}" value="Less Sweet" onchange="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                                <label class="btn btn-kg-outline w-100 rounded-3 py-1 small text-nowrap" for="h_nkLess{{ $item->id }}">Sedikit Gula</label>
                                                            </div>
                                                            <div class="col-4">
                                                                <input type="radio" class="btn-check" name="manis" id="h_nkNo{{ $item->id }}" value="Non Gula" onchange="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                                <label class="btn btn-kg-outline w-100 rounded-3 py-1 small text-nowrap" for="h_nkNo{{ $item->id }}">Non Gula</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-white small fw-bold"><i class="bi bi-cup text-warning me-1"></i> 3. Pilihan Susu</label>
                                                        <div class="row g-2">
                                                            <div class="col-6">
                                                                <input type="radio" class="btn-check" name="tambahan" id="h_milkFresh{{ $item->id }}" value="Fresh Milk" data-price-extra="0" checked onchange="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                                <label class="btn btn-kg-outline w-100 rounded-3 py-1 small" for="h_milkFresh{{ $item->id }}">Fresh Milk</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <input type="radio" class="btn-check" name="tambahan" id="h_milkOat{{ $item->id }}" value="Oat Milk" data-price-extra="4000" onchange="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                                <label class="btn btn-kg-outline w-100 rounded-3 py-1 small" for="h_milkOat{{ $item->id }}">Oat Milk (+4rb)</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- Catatan Khusus untuk Barista -->
                                                <div class="mb-3">
                                                    <label class="form-label text-white small fw-bold"><i class="bi bi-chat-left-text text-warning me-1"></i> Catatan untuk Barista (Opsional)</label>
                                                    <input type="text" name="catatan" class="form-control form-control-sm kg-search-input rounded-3 py-2" placeholder="Contoh: sedikit es batu, seduh kental">
                                                </div>

                                                <!-- Jumlah Pcs dengan Real-time Recalculation -->
                                                <div class="d-flex align-items-center justify-content-between pt-2 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                                                    <span class="fw-bold text-white small">Jumlah Pesanan:</span>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <button type="button" class="btn btn-kg-outline btn-sm rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 28px; height: 28px;" onclick="let input = document.getElementById('h_qty{{ $item->id }}'); if(input.value > 1) { input.value--; calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }}); }">-</button>
                                                        <input type="number" id="h_qty{{ $item->id }}" name="jumlah" class="form-control form-control-sm kg-search-input text-center rounded-3 fw-bold" style="width: 60px;" value="1" min="1" max="{{ $item->stok }}" oninput="calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }})" required>
                                                        <button type="button" class="btn btn-kg-outline btn-sm rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 28px; height: 28px;" onclick="let input = document.getElementById('h_qty{{ $item->id }}'); if(input.value < {{ $item->stok }}) { input.value++; calcQuickPrice({{ $item->id }}, {{ (int)$item->harga }}); }">+</button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="modal-footer border-top p-3 px-4 d-flex justify-content-between" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                                        <a href="{{ route('menu.show', $item->id) }}" class="btn btn-kg-outline rounded-pill px-3 py-2 small">
                                            <i class="bi bi-eye me-1"></i> Buka Halaman Detail
                                        </a>
                                        
                                        <div class="d-flex gap-2">
                                            <button type="submit" name="action_type" value="add_cart" class="btn btn-kg-outline rounded-pill px-3 py-2 fw-semibold">
                                                <i class="bi bi-bag-plus me-1" style="color: var(--kg-accent);"></i> + Masukkan Keranjang
                                            </button>
                                            <button type="submit" name="action_type" value="buy_now" class="btn btn-kg-accent rounded-pill px-4 py-2 fw-semibold shadow">
                                                <i class="bi bi-lightning-charge-fill me-1"></i> Pesan Langsung
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-12 text-center py-4 text-muted small">
                        Belum ada menu populer yang ditampilkan.
                    </div>
                @endforelse
            </div>

            <!-- 3 Langkah Pemesanan Cepat -->
            <div class="kg-card rounded-4 p-4 shadow-sm" style="background: #14100e; border: 1px solid rgba(255, 255, 255, 0.06);">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h3 class="h6 fw-bold text-white mb-0"><i class="bi bi-info-circle-fill me-2" style="color: var(--kg-accent);"></i> Cara Mudah Memesan di Kopi Aruna</h3>
                </div>
                <div class="row g-3 text-center">
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background-color: #1a1410; border: 1px solid rgba(255, 255, 255, 0.04);">
                            <span class="badge fw-bold rounded-circle mb-2" style="background: var(--kg-accent); color: #fff; width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;">1</span>
                            <div class="fw-semibold text-white small">Pilih Menu</div>
                            <small style="color: #756c66; font-size: 0.72rem;">Klik kartu untuk detail atau (+) untuk varian</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background-color: #1a1410; border: 1px solid rgba(255, 255, 255, 0.04);">
                            <span class="badge fw-bold rounded-circle mb-2" style="background: var(--kg-accent); color: #fff; width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;">2</span>
                            <div class="fw-semibold text-white small">Kustom & Hitung</div>
                            <small style="color: #756c66; font-size: 0.72rem;">Harga otomatis terhitung sesuai pilihan ukuran</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background-color: #1a1410; border: 1px solid rgba(255, 255, 255, 0.04);">
                            <span class="badge fw-bold rounded-circle mb-2" style="background: var(--kg-accent); color: #fff; width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;">3</span>
                            <div class="fw-semibold text-white small">Checkout Instan</div>
                            <small style="color: #756c66; font-size: 0.72rem;">Bayar QRIS/Tunai & pantau pesanan</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right: Pesanan Kamu Widget (Matching Reference Photo) -->
        <div class="col-lg-4">
            <div class="kg-card rounded-4 p-4 shadow-sm position-sticky" style="top: 90px; background: #14100e; border: 1px solid rgba(255, 255, 255, 0.06);">
                
                @php 
                    $cart = session()->get('cart', []);
                    $cartQty = array_sum(array_column($cart, 'jumlah'));
                    $cartSubtotal = 0;
                    foreach($cart as $c) { $cartSubtotal += ($c['harga'] * $c['jumlah']); }
                    $ongkirEstimate = count($cart) > 0 ? 4000 : 0;
                    $grandTotal = $cartSubtotal + $ongkirEstimate;
                @endphp

                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                    <h3 class="h6 fw-bold text-white mb-0">
                        Pesanan Kamu
                    </h3>
                    @if($cartQty > 0)
                        <span class="badge rounded-circle fw-bold d-flex align-items-center justify-content-center" style="width: 22px; height: 22px; background: #382419; color: var(--kg-accent); font-size: 0.72rem; border: 1px solid rgba(180, 123, 77, 0.3);">{{ $cartQty }}</span>
                    @endif
                </div>

                @if(count($cart) > 0)
                    <!-- Active Cart Items List -->
                    <div class="d-flex flex-column gap-3 mb-3 overflow-auto pe-1" style="max-height: 240px;">
                        @foreach($cart as $cKey => $cItem)
                            @php
                                $cImgPath = $cItem['gambar'] ?? null;
                                if ($cImgPath && (Str::startsWith($cImgPath, 'http://') || Str::startsWith($cImgPath, 'https://'))) {
                                    $cImgUrl = $cImgPath;
                                } elseif ($cImgPath && Str::startsWith($cImgPath, 'images/')) {
                                    $cImgUrl = asset($cImgPath);
                                } elseif ($cImgPath) {
                                    $cImgUrl = asset('storage/' . $cImgPath);
                                } else {
                                    $cImgUrl = asset('images/products/kopi-susu-gula-aren.jpg');
                                }
                            @endphp

                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $cImgUrl }}" class="rounded-3" style="width: 40px; height: 40px; object-fit: cover;" alt="{{ $cItem['nama'] }}">
                                    <div>
                                        <div class="fw-semibold text-white small text-truncate" style="max-width: 120px;">{{ $cItem['nama'] }}</div>
                                        <small style="color: #756c66; font-size: 0.72rem;">x{{ $cItem['jumlah'] }}</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-semibold text-white small">Rp {{ number_format($cItem['harga'] * $cItem['jumlah'], 0, ',', '.') }}</span>
                                    <form action="{{ route('cart.remove', $cKey) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-link text-white-50 p-0" title="Hapus">
                                            <i class="bi bi-trash" style="font-size: 0.85rem;"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Cart Summary Totals -->
                    <div class="pt-2 border-top mb-3" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                        <div class="d-flex justify-content-between small mb-1" style="color: #948b85;">
                            <span>Subtotal</span>
                            <span class="text-white">Rp {{ number_format($cartSubtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between small mb-2" style="color: #948b85;">
                            <span>Ongkir</span>
                            <span class="text-white">Rp {{ number_format($ongkirEstimate, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                            <span class="fw-bold text-white fs-6">Total</span>
                            <span class="fs-5 fw-extrabold text-white">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-kg-accent w-100 rounded-pill py-2 fw-semibold text-center shadow">
                        Lanjut ke Pembayaran <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-4 text-muted small">
                        <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #1f1814; color: #756c66;">
                            <i class="bi bi-bag fs-4"></i>
                        </div>
                        <div class="fw-semibold text-white mb-1">Pesanan Kamu Kosong</div>
                        <p style="color: #756c66; font-size: 0.75rem;" class="mb-3">Pilih dan klik menu di sebelah kiri untuk mulai memesan.</p>
                        <a href="{{ route('menu') }}" class="btn btn-kg-outline btn-sm rounded-pill px-3">
                            Lihat Semua Menu
                        </a>
                    </div>
                @endif

            </div>
        </div>

    </div>

</div>

@push('scripts')
<script>
    function calcQuickPrice(productId, basePrice) {
        const form = document.getElementById('quickForm' + productId);
        if (!form) return;

        let currentUnitPrice = basePrice;

        // Cek radio ukuran cup atau tambahan yang memiliki data-price-extra
        const checkedRadios = form.querySelectorAll('input[type="radio"]:checked');
        checkedRadios.forEach(radio => {
            const extra = parseInt(radio.getAttribute('data-price-extra') || 0);
            currentUnitPrice += extra;
        });

        // Ambil Qty
        const qtyInput = document.getElementById('h_qty' + productId);
        let qty = parseInt(qtyInput ? qtyInput.value : 1) || 1;
        if (qty < 1) qty = 1;

        const grandTotal = currentUnitPrice * qty;

        // Update UI Real-Time
        const unitEl = document.getElementById('quickUnitPrice' + productId);
        const totalEl = document.getElementById('quickTotalPrice' + productId);

        if (unitEl) unitEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(currentUnitPrice);
        if (totalEl) totalEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(grandTotal);
    }
</script>
@endpush

@endsection