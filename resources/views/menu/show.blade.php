@extends('layouts.app')

@section('title', $product->nama . ' - Aruna Coffee House')

@section('content')

@php
    $imgPath = $product->gambar;
    if ($imgPath && (Str::startsWith($imgPath, 'http://') || Str::startsWith($imgPath, 'https://'))) {
        $imgUrl = $imgPath;
    } elseif ($imgPath && Str::startsWith($imgPath, 'images/')) {
        $imgUrl = asset($imgPath);
    } elseif ($imgPath) {
        $imgUrl = asset('storage/' . $imgPath);
    } else {
        $imgUrl = asset('images/products/kopi-susu-gula-aren.jpg');
    }

    $isCoffee = in_array(strtolower($product->kategori), ['kopi', 'signature', 'espresso']);
    $isSnack = in_array(strtolower($product->kategori), ['snack', 'makanan', 'pastry']);
    $isNonCoffee = in_array(strtolower($product->kategori), ['non-kopi', 'tea', 'matcha', 'chocolate']);
@endphp

<div class="container-fluid px-3 px-lg-4 py-3">

    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('menu') }}" class="text-muted text-decoration-none">Menu Kafe</a></li>
            <li class="breadcrumb-item"><a href="{{ route('menu', ['kategori' => $product->kategori]) }}" class="text-muted text-decoration-none text-capitalize">{{ $product->kategori }}</a></li>
            <li class="breadcrumb-item active text-white fw-bold text-truncate" style="max-width: 250px;" aria-current="page">{{ $product->nama }}</li>
        </ol>
    </nav>

    <!-- Main Product Detail Container (Shopee-Style Experience) -->
    <div class="kg-card rounded-4 p-4 p-lg-5 mb-4 shadow-lg position-relative" style="background: #14100e; border: 1px solid rgba(255, 255, 255, 0.08);">
        
        <form action="{{ route('cart.add') }}" method="POST" id="productDetailForm">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div class="row g-4 g-lg-5 align-items-start">
                
                <!-- Left: Big Product Image Showcase -->
                <div class="col-lg-5">
                    <div class="position-relative rounded-4 overflow-hidden shadow-lg mb-3" style="background: #090706; border: 1px solid rgba(255, 255, 255, 0.08);">
                        <img src="{{ $imgUrl }}" id="mainProductImage" alt="{{ $product->nama }}" class="img-fluid w-100" style="max-height: 420px; object-fit: cover; transition: transform 0.3s ease;">
                        
                        @if($product->is_bestseller || $product->tag)
                            <span class="badge position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill shadow fw-bold" style="background: var(--kg-accent-gradient); color: #fff; font-size: 0.75rem;">
                                <i class="bi bi-star-fill me-1"></i> {{ $product->is_bestseller ? 'Terlaris di Kafe' : $product->tag }}
                            </span>
                        @endif
                    </div>

                    <!-- Mini Value Badges -->
                    <div class="row g-2 text-center">
                        <div class="col-4">
                            <div class="p-2 rounded-3" style="background: #1a1410; border: 1px solid rgba(255, 255, 255, 0.05);">
                                <i class="bi bi-shield-check text-warning fs-5 d-block mb-1"></i>
                                <small class="text-white fw-semibold d-block" style="font-size: 0.7rem;">100% Biji Asli</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded-3" style="background: #1a1410; border: 1px solid rgba(255, 255, 255, 0.05);">
                                <i class="bi bi-droplet-half text-info fs-5 d-block mb-1"></i>
                                <small class="text-white fw-semibold d-block" style="font-size: 0.7rem;">Fresh Brewed</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded-3" style="background: #1a1410; border: 1px solid rgba(255, 255, 255, 0.05);">
                                <i class="bi bi-lightning-charge text-success fs-5 d-block mb-1"></i>
                                <small class="text-white fw-semibold d-block" style="font-size: 0.7rem;">Racik Cepat</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Product Information & Customization Form -->
                <div class="col-lg-7">
                    
                    <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                        <span class="badge rounded-pill text-uppercase px-3 py-1 fw-bold" style="background: #382419; color: var(--kg-accent); font-size: 0.75rem; border: 1px solid rgba(180, 123, 77, 0.3);">
                            {{ $product->kategori }}
                        </span>
                        <div class="d-flex align-items-center text-warning small gap-1">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="text-white fw-bold ms-1">4.9</span>
                            <span class="text-muted ms-1">(1.500+ Terjual)</span>
                        </div>
                    </div>

                    <h1 class="display-6 fw-extrabold text-white mb-2" style="letter-spacing: -0.02em;">
                        {{ $product->nama }}
                    </h1>

                    <p class="mb-4" style="color: #a39992; font-size: 0.95rem; line-height: 1.6;">
                        {{ $product->deskripsi }}
                    </p>

                    <!-- Real-Time Price Display Card -->
                    <div class="p-3 p-md-4 rounded-4 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: linear-gradient(135deg, #241913 0%, #15100c 100%); border: 1px solid rgba(180, 123, 77, 0.35);">
                        <div>
                            <span class="d-block text-muted small mb-1">Harga Satuan (Kustom Terpilih):</span>
                            <div class="d-flex align-items-baseline gap-2">
                                <span class="display-6 fw-extrabold text-white" id="displayUnitPrice" style="letter-spacing: -0.02em;">
                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                </span>
                                @if($product->harga >= 12000)
                                    <span class="badge rounded-pill px-2 py-1" style="background: #4a2815; color: var(--kg-gold); font-size: 0.7rem;">Hemat 20%</span>
                                @endif
                            </div>
                        </div>

                        <div class="text-end">
                            <span class="badge rounded-pill px-3 py-2 fw-semibold {{ $product->stok > 0 ? 'bg-success text-white' : 'bg-danger text-white' }}">
                                <i class="bi bi-box-seam me-1"></i> Stok Tersedia: {{ $product->stok }} pcs
                            </span>
                        </div>
                    </div>

                    <!-- Interactive Options & Variant Selection -->
                    <div class="d-flex flex-column gap-3 mb-4">
                        
                        @if($isCoffee)
                            <!-- 1. Pilihan Suhu Minuman -->
                            <div>
                                <label class="form-label text-white small fw-bold d-flex align-items-center gap-1 mb-2">
                                    <i class="bi bi-thermometer-half text-warning"></i> 1. Suhu Penyajian:
                                </label>
                                <div class="d-flex gap-2">
                                    <input type="radio" class="btn-check" name="suhu" id="d_suhuIce" value="Es" checked onchange="calcRealtimePrice()">
                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-2 small" for="d_suhuIce">
                                        <i class="bi bi-snow me-1 text-info"></i> Dingin
                                    </label>
                                    <input type="radio" class="btn-check" name="suhu" id="d_suhuHot" value="Panas" onchange="calcRealtimePrice()">
                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-2 small" for="d_suhuHot">
                                        <i class="bi bi-fire me-1 text-danger"></i> Hangat
                                    </label>
                                </div>
                            </div>

                            <!-- 2. Pilihan Gula -->
                            <div>
                                <label class="form-label text-white small fw-bold d-flex align-items-center gap-1 mb-2">
                                    <i class="bi bi-droplet-half text-warning"></i> 2. Takaran Gula:
                                </label>
                                <div class="row g-2">
                                    <div class="col-4">
                                        <input type="radio" class="btn-check" name="manis" id="d_manisNorm" value="Gula Normal" checked onchange="calcRealtimePrice()">
                                        <label class="btn btn-kg-outline w-100 rounded-3 py-2 small text-nowrap" for="d_manisNorm">Normal</label>
                                    </div>
                                    <div class="col-4">
                                        <input type="radio" class="btn-check" name="manis" id="d_manisLess" value="Sedikit Gula" onchange="calcRealtimePrice()">
                                        <label class="btn btn-kg-outline w-100 rounded-3 py-2 small text-nowrap" for="d_manisLess">Sedikit Gula</label>
                                    </div>
                                    <div class="col-4">
                                        <input type="radio" class="btn-check" name="manis" id="d_manisNo" value="Non Gula" onchange="calcRealtimePrice()">
                                        <label class="btn btn-kg-outline w-100 rounded-3 py-2 small text-nowrap" for="d_manisNo">Non Gula</label>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Ukuran Cup (Dynamic Price Impact) -->
                            <div>
                                <label class="form-label text-white small fw-bold d-flex align-items-center gap-1 mb-2">
                                    <i class="bi bi-cup text-warning"></i> 3. Ukuran Cup:
                                </label>
                                <div class="d-flex gap-2">
                                    <input type="radio" class="btn-check" name="ukuran" id="d_sizeReg" value="Reguler" data-price-extra="0" checked onchange="calcRealtimePrice()">
                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-2 small" for="d_sizeReg">
                                        Reguler
                                    </label>
                                    <input type="radio" class="btn-check" name="ukuran" id="d_sizeLrg" value="Large" data-price-extra="3000" onchange="calcRealtimePrice()">
                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-2 small" for="d_sizeLrg">
                                        Large (+3rb)
                                    </label>
                                </div>
                            </div>

                        @elseif($isSnack)
                            <!-- 1. Pilihan Suhu Makanan -->
                            <div>
                                <label class="form-label text-white small fw-bold d-flex align-items-center gap-1 mb-2">
                                    <i class="bi bi-fire text-warning"></i> 1. Cara Penyajian:
                                </label>
                                <div class="d-flex gap-2">
                                    <input type="radio" class="btn-check" name="suhu" id="d_snackWarm" value="Dipanaskan (Toasted)" checked onchange="calcRealtimePrice()">
                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-2 small" for="d_snackWarm">
                                        <i class="bi bi-fire me-1 text-warning"></i> Dipanaskan
                                    </label>
                                    <input type="radio" class="btn-check" name="suhu" id="d_snackNorm" value="Suhu Ruang" onchange="calcRealtimePrice()">
                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-2 small" for="d_snackNorm">
                                        Suhu Ruang
                                    </label>
                                </div>
                            </div>

                            <!-- 2. Pilihan Topping (Dynamic Price Impact) -->
                            <div>
                                <label class="form-label text-white small fw-bold d-flex align-items-center gap-1 mb-2">
                                    <i class="bi bi-plus-circle text-warning"></i> 2. Pilihan Topping:
                                </label>
                                <div class="d-flex gap-2">
                                    <input type="radio" class="btn-check" name="tambahan" id="d_topOrig" value="Original" data-price-extra="0" checked onchange="calcRealtimePrice()">
                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-2 small" for="d_topOrig">Original</label>
                                    <input type="radio" class="btn-check" name="tambahan" id="d_topExtra" value="Ekstra Keju/Topping" data-price-extra="4000" onchange="calcRealtimePrice()">
                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-2 small" for="d_topExtra">Ekstra Keju (+4rb)</label>
                                </div>
                            </div>

                        @else
                            <!-- 1. Suhu Non Kopi -->
                            <div>
                                <label class="form-label text-white small fw-bold d-flex align-items-center gap-1 mb-2">
                                    <i class="bi bi-thermometer-half text-warning"></i> 1. Suhu Minuman:
                                </label>
                                <div class="d-flex gap-2">
                                    <input type="radio" class="btn-check" name="suhu" id="d_nkIce" value="Es" checked onchange="calcRealtimePrice()">
                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-2 small" for="d_nkIce">
                                        <i class="bi bi-snow me-1 text-info"></i> Dingin
                                    </label>
                                    <input type="radio" class="btn-check" name="suhu" id="d_nkHot" value="Panas" onchange="calcRealtimePrice()">
                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-2 small" for="d_nkHot">
                                        <i class="bi bi-fire me-1 text-danger"></i> Hangat
                                    </label>
                                </div>
                            </div>

                            <!-- 2. Tingkat Manis Non Kopi -->
                            <div>
                                <label class="form-label text-white small fw-bold d-flex align-items-center gap-1 mb-2">
                                    <i class="bi bi-droplet-half text-warning"></i> 2. Tingkat Manis:
                                </label>
                                <div class="row g-2">
                                    <div class="col-4">
                                        <input type="radio" class="btn-check" name="manis" id="d_nkNorm" value="Normal Sweet" checked onchange="calcRealtimePrice()">
                                        <label class="btn btn-kg-outline w-100 rounded-3 py-2 small text-nowrap" for="d_nkNorm">Normal</label>
                                    </div>
                                    <div class="col-4">
                                        <input type="radio" class="btn-check" name="manis" id="d_nkLess" value="Less Sweet" onchange="calcRealtimePrice()">
                                        <label class="btn btn-kg-outline w-100 rounded-3 py-2 small text-nowrap" for="d_nkLess">Sedikit Gula</label>
                                    </div>
                                    <div class="col-4">
                                        <input type="radio" class="btn-check" name="manis" id="d_nkNo" value="Non Gula" onchange="calcRealtimePrice()">
                                        <label class="btn btn-kg-outline w-100 rounded-3 py-2 small text-nowrap" for="d_nkNo">Non Gula</label>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Pilihan Susu (Dynamic Price Impact) -->
                            <div>
                                <label class="form-label text-white small fw-bold d-flex align-items-center gap-1 mb-2">
                                    <i class="bi bi-cup text-warning"></i> 3. Pilihan Susu:
                                </label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="tambahan" id="d_milkFresh" value="Fresh Milk" data-price-extra="0" checked onchange="calcRealtimePrice()">
                                        <label class="btn btn-kg-outline w-100 rounded-3 py-2 small" for="d_milkFresh">Fresh Milk</label>
                                    </div>
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="tambahan" id="d_milkOat" value="Oat Milk" data-price-extra="4000" onchange="calcRealtimePrice()">
                                        <label class="btn btn-kg-outline w-100 rounded-3 py-2 small" for="d_milkOat">Oat Milk (+4rb)</label>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Catatan Barista -->
                        <div>
                            <label class="form-label text-white small fw-bold d-flex align-items-center gap-1 mb-2">
                                <i class="bi bi-chat-left-text text-warning"></i> Catatan Khusus untuk Barista (Opsional):
                            </label>
                            <input type="text" name="catatan" class="form-control kg-search-input rounded-3 py-2" placeholder="Contoh: sedikit es batu, seduh kental">
                        </div>

                        <!-- Quantity Selector & Grand Total Counter -->
                        <div class="p-3 rounded-4 mt-2 d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: #1a1410; border: 1px solid rgba(255, 255, 255, 0.05);">
                            <div>
                                <label class="text-white small fw-bold d-block mb-1">Jumlah Pesanan:</label>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-kg-outline btn-sm rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 32px; height: 32px;" onclick="decreaseQty()">-</button>
                                    <input type="number" id="detailQtyInput" name="jumlah" class="form-control form-control-sm kg-search-input text-center rounded-3 fw-bold" style="width: 65px;" value="1" min="1" max="{{ $product->stok }}" oninput="calcRealtimePrice()" required>
                                    <button type="button" class="btn btn-kg-outline btn-sm rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 32px; height: 32px;" onclick="increaseQty({{ $product->stok }})">+</button>
                                </div>
                            </div>

                            <div class="text-end">
                                <span class="d-block text-muted small">Total Pembayaran:</span>
                                <span class="fs-4 fw-extrabold" style="color: var(--kg-gold);" id="displayTotalPrice">
                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                    </div>

                    <!-- Action CTA Buttons -->
                    <div class="d-flex gap-3 flex-wrap">
                        <button type="submit" name="action_type" value="add_cart" class="btn btn-kg-outline rounded-pill px-4 py-3 fw-semibold flex-grow-1 d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-bag-plus fs-5" style="color: var(--kg-accent);"></i> + Masukkan Keranjang
                        </button>
                        <button type="submit" name="action_type" value="buy_now" class="btn btn-kg-accent rounded-pill px-5 py-3 fw-bold shadow flex-grow-1 d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-lightning-charge-fill fs-5"></i> Pesan & Bayar Sekarang
                        </button>
                    </div>

                </div>

            </div>
        </form>

    </div>

    <!-- Tab Sections: Story, Ingredients, Reviews -->
    <div class="kg-card rounded-4 p-4 shadow-sm mb-5" style="background: #14100e; border: 1px solid rgba(255, 255, 255, 0.06);">
        <ul class="nav nav-pills mb-4 gap-2 border-bottom pb-3" style="border-color: rgba(255, 255, 255, 0.08) !important;" id="productTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill px-4 py-2 fw-semibold" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc-content" type="button" role="tab">
                    <i class="bi bi-cup-hot me-1"></i> Cita Rasa & Karakteristik
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 py-2 fw-semibold" id="komposisi-tab" data-bs-toggle="tab" data-bs-target="#komposisi-content" type="button" role="tab">
                    <i class="bi bi-journal-text me-1"></i> Komposisi & Bahan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 py-2 fw-semibold" id="review-tab" data-bs-toggle="tab" data-bs-target="#review-content" type="button" role="tab">
                    <i class="bi bi-star-fill text-warning me-1"></i> Ulasan Pelanggan (4.9)
                </button>
            </li>
        </ul>

        <div class="tab-content" id="productTabContent">
            <!-- Tab 1: Cita Rasa -->
            <div class="tab-pane fade show active" id="desc-content" role="tabpanel">
                <div class="row g-4 align-items-center">
                    <div class="col-md-7">
                        <h4 class="h5 fw-bold text-white mb-2">Profil Cita Rasa {{ $product->nama }}</h4>
                        <p class="text-muted mb-3" style="line-height: 1.6;">
                            Diramu khusus oleh barista Aruna Coffee House dengan teknik ekstraksi presisi pada suhu 92°C untuk mengeluarkan aroma manis karamel alami tanpa rasa pahit berlebih. Sangat cocok dinikmati saat santai maupun menemani produktivitas harian Anda.
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-dark border border-secondary px-3 py-2 text-white">Acidity: Low (Halus di Lambung)</span>
                            <span class="badge bg-dark border border-secondary px-3 py-2 text-white">Body: Medium to Bold</span>
                            <span class="badge bg-dark border border-secondary px-3 py-2 text-white">Sweetness: Natural Caramel Sweet</span>
                        </div>
                    </div>
                    <div class="col-md-5 text-center">
                        <div class="p-3 rounded-4" style="background: #1a1410; border: 1px solid rgba(255, 255, 255, 0.05);">
                            <i class="bi bi-award-fill text-warning display-5 mb-2"></i>
                            <div class="fw-bold text-white small">Jaminan Rasa Autentik</div>
                            <small class="text-muted">Dibuat dari biji kopi arabika & robusta grade 1 nusantara.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Komposisi -->
            <div class="tab-pane fade" id="komposisi-content" role="tabpanel">
                <h4 class="h5 fw-bold text-white mb-3">Komposisi & Standar Kualitas</h4>
                <ul class="list-unstyled text-muted d-flex flex-column gap-2 mb-0">
                    <li><i class="bi bi-check-circle-fill text-warning me-2"></i> <strong>Espresso Roast:</strong> House blend biji pilihan roastery Aruna.</li>
                    <li><i class="bi bi-check-circle-fill text-warning me-2"></i> <strong>Susu:</strong> Susu pasteurisasi murni kualitas premium (atau Oat Milk bebas laktosa).</li>
                    <li><i class="bi bi-check-circle-fill text-warning me-2"></i> <strong>Gula:</strong> Pemanis organik asli tanpa pengawet buatan.</li>
                </ul>
            </div>

            <!-- Tab 3: Ulasan Pelanggan -->
            <div class="tab-pane fade" id="review-content" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background: #1a1410; border: 1px solid rgba(255, 255, 255, 0.04);">
                            <div class="d-flex justify-content-between mb-1">
                                <strong class="text-white small">Rangga P.</strong>
                                <span class="text-warning small"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></span>
                            </div>
                            <p class="text-muted small mb-0">"Kopinya creamy banget, gula arennya pas ga bikin eneg. Jadi langganan tiap sore!"</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background: #1a1410; border: 1px solid rgba(255, 255, 255, 0.04);">
                            <div class="d-flex justify-content-between mb-1">
                                <strong class="text-white small">Anisa K.</strong>
                                <span class="text-warning small"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></span>
                            </div>
                            <p class="text-muted small mb-0">"Packaging rapi, esnya gak gampang mencair. Large cup worth it banget!"</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Coffee Recommendations Section -->
    <div class="mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h3 class="h5 fw-bold text-white mb-0">
                <i class="bi bi-stars text-warning me-2"></i> Rekomendasi Menu Lainnya
            </h3>
            <a href="{{ route('menu') }}" class="btn btn-sm btn-kg-outline rounded-pill px-3">
                Lihat Semua Menu <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3">
            @foreach ($relatedProducts as $rel)
                @php
                    $rImgPath = $rel->gambar;
                    if ($rImgPath && (Str::startsWith($rImgPath, 'http://') || Str::startsWith($rImgPath, 'https://'))) {
                        $rImgUrl = $rImgPath;
                    } elseif ($rImgPath && Str::startsWith($rImgPath, 'images/')) {
                        $rImgUrl = asset($rImgPath);
                    } elseif ($rImgPath) {
                        $rImgUrl = asset('storage/' . $rImgPath);
                    } else {
                        $rImgUrl = asset('images/products/kopi-susu-gula-aren.jpg');
                    }
                @endphp

                <div class="col">
                    <a href="{{ route('menu.show', $rel->id) }}" class="card kg-card kg-card-hover rounded-4 h-100 p-3 text-decoration-none d-flex flex-column justify-content-between" style="background: #14100e; border: 1px solid rgba(255, 255, 255, 0.06);">
                        <div>
                            <div class="text-center mb-2 overflow-hidden rounded-3" style="background: #0d0a08;">
                                <img src="{{ $rImgUrl }}" class="w-100 rounded-3" style="height: 125px; object-fit: cover;" alt="{{ $rel->nama }}">
                            </div>
                            <div class="fw-bold text-white small text-truncate">{{ $rel->nama }}</div>
                            <p class="small mb-2" style="color: #948b85; font-size: 0.72rem; line-height: 1.35; min-height: 28px;">
                                {{ Str::limit($rel->deskripsi, 45) }}
                            </p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between pt-2 border-top" style="border-color: rgba(255, 255, 255, 0.06) !important;">
                            <span class="fw-bold text-white small">Rp {{ number_format($rel->harga, 0, ',', '.') }}</span>
                            <span class="badge rounded-pill text-uppercase" style="background: #241913; color: var(--kg-accent); font-size: 0.65rem;">{{ $rel->kategori }}</span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

</div>

@push('scripts')
<script>
    const baseProductPrice = {{ (int)$product->harga }};

    function decreaseQty() {
        let input = document.getElementById('detailQtyInput');
        if (input.value > 1) {
            input.value--;
            calcRealtimePrice();
        }
    }

    function increaseQty(maxStock) {
        let input = document.getElementById('detailQtyInput');
        if (parseInt(input.value) < maxStock) {
            input.value++;
            calcRealtimePrice();
        }
    }

    function calcRealtimePrice() {
        let currentUnitPrice = baseProductPrice;

        // Cek radio ukuran cup atau tambahan yang memiliki data-price-extra
        const checkedRadios = document.querySelectorAll('#productDetailForm input[type="radio"]:checked');
        checkedRadios.forEach(radio => {
            const extra = parseInt(radio.getAttribute('data-price-extra') || 0);
            currentUnitPrice += extra;
        });

        // Ambil Qty
        const qtyInput = document.getElementById('detailQtyInput');
        let qty = parseInt(qtyInput.value) || 1;
        if (qty < 1) qty = 1;

        const grandTotal = currentUnitPrice * qty;

        // Update UI secara real-time
        document.getElementById('displayUnitPrice').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(currentUnitPrice);
        document.getElementById('displayTotalPrice').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(grandTotal);
    }

    document.addEventListener('DOMContentLoaded', function() {
        calcRealtimePrice();
    });
</script>
@endpush

@endsection
