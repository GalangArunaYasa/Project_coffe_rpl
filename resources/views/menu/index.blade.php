@extends('layouts.app')

@section('title', 'Kopi Susu Gula Aren - Kopi Gerobakan')

@section('content')

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
                    <span class="badge bg-dark bg-opacity-75 position-absolute top-0 start-0 m-3 d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                        <i class="bi bi-star-fill text-warning"></i> 4.8
                        <span class="text-muted">| 234 terjual</span>
                    </span>
                    <img src="https://placehold.co/600x600/171310/c0783f?text=Kopi+Susu+Gula+Aren"
                         class="img-fluid rounded-4 w-100" style="aspect-ratio: 1/1; object-fit: cover;"
                         alt="Kopi Susu Gula Aren">
                </div>

                <!-- Thumbnails -->
                <div class="d-flex gap-2 overflow-auto pb-1">
                    <img src="https://placehold.co/100x100/201a16/c0783f?text=1" class="rounded-3 border border-2" style="width: 80px; height: 80px; object-fit: cover; border-color: var(--kg-accent) !important; cursor: pointer;" alt="Thumbnail 1">
                    <img src="https://placehold.co/100x100/171310/6b5c50?text=2" class="rounded-3 border" style="width: 80px; height: 80px; object-fit: cover; border-color: var(--kg-border) !important; cursor: pointer;" alt="Thumbnail 2">
                    <img src="https://placehold.co/100x100/171310/6b5c50?text=3" class="rounded-3 border" style="width: 80px; height: 80px; object-fit: cover; border-color: var(--kg-border) !important; cursor: pointer;" alt="Thumbnail 3">
                    <img src="https://placehold.co/100x100/171310/6b5c50?text=4" class="rounded-3 border" style="width: 80px; height: 80px; object-fit: cover; border-color: var(--kg-border) !important; cursor: pointer;" alt="Thumbnail 4">
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
                        <input type="radio" class="btn-check" name="ukuran" id="ukuranReguler" autocomplete="off" checked>
                        <label class="btn btn-outline-light rounded-3 px-4 py-2 text-start" for="ukuranReguler">
                            <span class="d-block fw-semibold">Reguler</span>
                            <small class="text-muted">250 ml</small>
                        </label>

                        <input type="radio" class="btn-check" name="ukuran" id="ukuranLarge" autocomplete="off">
                        <label class="btn btn-outline-light rounded-3 px-4 py-2 text-start" for="ukuranLarge">
                            <span class="d-block fw-semibold">Large</span>
                            <small class="text-muted">350 ml</small>
                        </label>
                    </div>
                </div>

                <!-- Level Manis -->
                <div class="mb-4">
                    <label class="form-label fw-semibold small text-uppercase text-muted">Level Manis</label>
                    <div class="d-flex gap-2 flex-wrap">
                        <input type="radio" class="btn-check" name="manis" id="manisLess" autocomplete="off">
                        <label class="btn btn-outline-light rounded-3 px-3 py-2 text-start" for="manisLess">
                            <span class="d-block fw-semibold small">Less Sugar</span>
                            <small class="text-muted">25%</small>
                        </label>

                        <input type="radio" class="btn-check" name="manis" id="manisNormal" autocomplete="off" checked>
                        <label class="btn btn-outline-light rounded-3 px-3 py-2 text-start" for="manisNormal">
                            <span class="d-block fw-semibold small">Normal</span>
                            <small class="text-muted">50%</small>
                        </label>

                        <input type="radio" class="btn-check" name="manis" id="manisExtra" autocomplete="off">
                        <label class="btn btn-outline-light rounded-3 px-3 py-2 text-start" for="manisExtra">
                            <span class="d-block fw-semibold small">Extra</span>
                            <small class="text-muted">75%</small>
                        </label>

                        <input type="radio" class="btn-check" name="manis" id="manisNo" autocomplete="off">
                        <label class="btn btn-outline-light rounded-3 px-3 py-2 text-start" for="manisNo">
                            <span class="d-block fw-semibold small">No Sugar</span>
                            <small class="text-muted">0%</small>
                        </label>
                    </div>
                </div>

                <!-- Es / Panas -->
                <div class="mb-4">
                    <label class="form-label fw-semibold small text-uppercase text-muted">Es / Panas</label>
                    <div class="d-flex gap-2">
                        <input type="radio" class="btn-check" name="suhu" id="suhuEs" autocomplete="off" checked>
                        <label class="btn btn-outline-light rounded-3 px-4 py-2 d-flex align-items-center gap-2" for="suhuEs">
                            <i class="bi bi-snow2"></i> Es
                        </label>

                        <input type="radio" class="btn-check" name="suhu" id="suhuPanas" autocomplete="off">
                        <label class="btn btn-outline-light rounded-3 px-4 py-2 d-flex align-items-center gap-2" for="suhuPanas">
                            <i class="bi bi-fire"></i> Panas
                        </label>
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
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-dash"></i>
                        </button>
                        <input type="text" class="form-control text-center kg-search-input" value="1" readonly>
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                    <button class="btn btn-kg-accent flex-grow-1 rounded-3 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                    </button>
                </div>
            </div>

            <!-- Pesanan Kamu -->
            <div class="col-lg-3">
                <div class="card kg-card rounded-4 shadow-sm position-sticky" style="top: 90px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h2 class="h5 fw-bold mb-0">Pesanan Kamu</h2>
                            <span class="badge btn-kg-accent rounded-pill">3</span>
                        </div>

                        <!-- Item 1 -->
                        <div class="d-flex gap-2 mb-3">
                            <img src="https://placehold.co/60x60/171310/c0783f?text=KS" class="rounded-3" style="width: 52px; height: 52px; object-fit: cover;" alt="Kopi Susu Gula Aren">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="small fw-semibold">Kopi Susu Gula Aren</div>
                                    <button class="btn btn-sm btn-link text-danger p-0"><i class="bi bi-trash"></i></button>
                                </div>
                                <small class="text-muted d-block mb-1">Reguler - Es - Normal</small>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="small fw-semibold">Rp 12.000</span>
                                    <div class="input-group input-group-sm" style="width: 90px;">
                                        <button class="btn btn-outline-secondary btn-sm" type="button"><i class="bi bi-dash"></i></button>
                                        <input type="text" class="form-control text-center kg-search-input p-0" value="1" readonly>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"><i class="bi bi-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div class="d-flex gap-2 mb-3">
                            <img src="https://placehold.co/60x60/171310/c0783f?text=CP" class="rounded-3" style="width: 52px; height: 52px; object-fit: cover;" alt="Cappuccino">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="small fw-semibold">Cappuccino</div>
                                    <button class="btn btn-sm btn-link text-danger p-0"><i class="bi bi-trash"></i></button>
                                </div>
                                <small class="text-muted d-block mb-1">Reguler - Panas - Normal</small>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="small fw-semibold">Rp 13.000</span>
                                    <div class="input-group input-group-sm" style="width: 90px;">
                                        <button class="btn btn-outline-secondary btn-sm" type="button"><i class="bi bi-dash"></i></button>
                                        <input type="text" class="form-control text-center kg-search-input p-0" value="1" readonly>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"><i class="bi bi-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div class="d-flex gap-2 mb-4">
                            <img src="https://placehold.co/60x60/171310/c0783f?text=RB" class="rounded-3" style="width: 52px; height: 52px; object-fit: cover;" alt="Roti Bakar Cokelat">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="small fw-semibold">Roti Bakar Cokelat</div>
                                    <button class="btn btn-sm btn-link text-danger p-0"><i class="bi bi-trash"></i></button>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <span class="small fw-semibold">Rp 10.000</span>
                                    <div class="input-group input-group-sm" style="width: 90px;">
                                        <button class="btn btn-outline-secondary btn-sm" type="button"><i class="bi bi-dash"></i></button>
                                        <input type="text" class="form-control text-center kg-search-input p-0" value="1" readonly>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"><i class="bi bi-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr style="border-color: var(--kg-border);">

                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="small text-muted">Subtotal</span>
                            <span class="small">Rp 35.000</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="small text-muted">Ongkir</span>
                            <span class="small">Rp 4.000</span>
                        </div>

                        <hr style="border-color: var(--kg-border);">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold fs-5" style="color: var(--kg-accent);">Rp 39.000</span>
                        </div>

                        <a href="{{ url('/checkout') }}" class="btn btn-kg-accent w-100 rounded-3 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2 mb-3">
                            Lanjut ke Pembayaran <i class="bi bi-arrow-right"></i>
                        </a>

                        <div class="alert alert-secondary kg-card rounded-3 d-flex gap-2 mb-0 py-2 px-3">
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
                <h2 class="h4 fw-bold mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-cup-straw" style="color: var(--kg-accent);"></i>
                    Kamu Mungkin Juga Suka
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

                <div class="col">
                    <div class="card kg-card rounded-4 h-100 shadow-sm">
                        <img src="https://placehold.co/300x300/171310/c0783f?text=Es+Kopi" class="card-img-top rounded-top-4" alt="Es Kopi Hitam">
                        <div class="card-body">
                            <h3 class="h6 fw-semibold mb-2">Es Kopi Hitam</h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fw-semibold small">Rp 9.000</span>
                                <button class="btn btn-kg-accent btn-sm rounded-circle" style="width: 30px; height: 30px;">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card kg-card rounded-4 h-100 shadow-sm">
                        <img src="https://placehold.co/300x300/171310/c0783f?text=Cappuccino" class="card-img-top rounded-top-4" alt="Cappuccino">
                        <div class="card-body">
                            <h3 class="h6 fw-semibold mb-2">Cappuccino</h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fw-semibold small">Rp 13.000</span>
                                <button class="btn btn-kg-accent btn-sm rounded-circle" style="width: 30px; height: 30px;">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card kg-card rounded-4 h-100 shadow-sm">
                        <img src="https://placehold.co/300x300/171310/c0783f?text=Kopi+Latte" class="card-img-top rounded-top-4" alt="Kopi Latte">
                        <div class="card-body">
                            <h3 class="h6 fw-semibold mb-2">Kopi Latte</h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fw-semibold small">Rp 13.000</span>
                                <button class="btn btn-kg-accent btn-sm rounded-circle" style="width: 30px; height: 30px;">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card kg-card rounded-4 h-100 shadow-sm">
                        <img src="https://placehold.co/300x300/171310/c0783f?text=Chocolate" class="card-img-top rounded-top-4" alt="Chocolate">
                        <div class="card-body">
                            <h3 class="h6 fw-semibold mb-2">Chocolate</h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fw-semibold small">Rp 12.000</span>
                                <button class="btn btn-kg-accent btn-sm rounded-circle" style="width: 30px; height: 30px;">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card kg-card rounded-4 h-100 shadow-sm">
                        <img src="https://placehold.co/300x300/171310/c0783f?text=Matcha+Latte" class="card-img-top rounded-top-4" alt="Matcha Latte">
                        <div class="card-body">
                            <h3 class="h6 fw-semibold mb-2">Matcha Latte</h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fw-semibold small">Rp 14.000</span>
                                <button class="btn btn-kg-accent btn-sm rounded-circle" style="width: 30px; height: 30px;">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>

@endsection