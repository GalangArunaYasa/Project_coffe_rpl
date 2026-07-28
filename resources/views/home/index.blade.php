@extends('layouts.app')

@section('title', 'Beranda - Kopi Gerobakan')

@section('content')

    <!-- Hero Section -->
    <section class="container-fluid py-5">
        <div class="row align-items-center gy-4">
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold mb-3">
                    Kopi Nikmat,<br>
                    <span style="color: var(--kg-accent);">Harga Bersahabat.</span>
                </h1>
                <p class="lead text-muted mb-4">
                    Kopi gerobakan, rasa premium, harga tetap ramah di kantong.
                    Pesan sekarang, nikmati dimana saja!
                </p>
                <div class="d-flex flex-wrap gap-3 mb-5">
                    <a href="{{ url('/pesan') }}" class="btn btn-kg-accent btn-lg rounded-3 px-4 fw-semibold d-inline-flex align-items-center gap-2">
                        Pesan Sekarang <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ url('/menu') }}" class="btn btn-outline-light btn-lg rounded-3 px-4 fw-semibold">
                        Lihat Menu
                    </a>
                </div>

                <!-- Highlights -->
                <div class="row gy-3">
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center justify-content-center rounded-circle kg-card" style="width: 44px; height: 44px;">
                                <i class="bi bi-cup-hot" style="color: var(--kg-accent);"></i>
                            </div>
                            <div>
                                <div class="fw-semibold small">Rasa Premium</div>
                                <small class="text-muted">Biji pilihan terbaik</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center justify-content-center rounded-circle kg-card" style="width: 44px; height: 44px;">
                                <i class="bi bi-scooter" style="color: var(--kg-accent);"></i>
                            </div>
                            <div>
                                <div class="fw-semibold small">Pesan & Antar</div>
                                <small class="text-muted">Cepat sampai tujuan</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center justify-content-center rounded-circle kg-card" style="width: 44px; height: 44px;">
                                <i class="bi bi-wallet2" style="color: var(--kg-accent);"></i>
                            </div>
                            <div>
                                <div class="fw-semibold small">Pembayaran Mudah</div>
                                <small class="text-muted">Banyak metode bayar</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 d-none d-lg-block text-center">
                <img src="https://placehold.co/600x400/171310/c0783f?text=Kopi+Gerobakan"
                     alt="Gerobak Kopi" class="img-fluid rounded-4 shadow">
            </div>
        </div>
    </section>

    <!-- Menu Populer & Pesanan -->
    <section class="container-fluid pb-5">
        <div class="row gy-4">

            <!-- Menu Populer -->
            <div class="col-lg-8 order-lg-1">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h2 class="h4 fw-bold mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-cup-straw" style="color: var(--kg-accent);"></i>
                        Menu Populer
                    </h2>
                    <a href="{{ url('/menu') }}" class="btn btn-sm btn-outline-secondary rounded-3">
                        Lihat Semua
                    </a>
                </div>

                <div class="row row-cols-2 row-cols-lg-4 g-3">

                    <div class="col">
                        <div class="card kg-card rounded-4 h-100 shadow-sm">
                            <img src="https://placehold.co/300x300/171310/c0783f?text=Kopi+Susu"
                                 class="card-img-top rounded-top-4" alt="Kopi Susu Gula Aren">
                            <div class="card-body">
                                <h3 class="h6 fw-semibold mb-1">Kopi Susu Gula Aren</h3>
                                <p class="small text-muted mb-2">Perpaduan kopi, susu segar dan gula aren asli.</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="fw-semibold">Rp 12.000</span>
                                    <button class="btn btn-kg-accent btn-sm rounded-circle" style="width: 32px; height: 32px;">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card kg-card rounded-4 h-100 shadow-sm">
                            <img src="https://placehold.co/300x300/171310/c0783f?text=Es+Kopi"
                                 class="card-img-top rounded-top-4" alt="Es Kopi Hitam">
                            <div class="card-body">
                                <h3 class="h6 fw-semibold mb-1">Es Kopi Hitam</h3>
                                <p class="small text-muted mb-2">Kopi hitam segar pilihan biji terbaik.</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="fw-semibold">Rp 9.000</span>
                                    <button class="btn btn-kg-accent btn-sm rounded-circle" style="width: 32px; height: 32px;">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card kg-card rounded-4 h-100 shadow-sm">
                            <img src="https://placehold.co/300x300/171310/c0783f?text=Cappuccino"
                                 class="card-img-top rounded-top-4" alt="Cappuccino">
                            <div class="card-body">
                                <h3 class="h6 fw-semibold mb-1">Cappuccino</h3>
                                <p class="small text-muted mb-2">Kopi dengan busa susu lembut dan nikmat.</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="fw-semibold">Rp 13.000</span>
                                    <button class="btn btn-kg-accent btn-sm rounded-circle" style="width: 32px; height: 32px;">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card kg-card rounded-4 h-100 shadow-sm">
                            <img src="https://placehold.co/300x300/171310/c0783f?text=Kopi+Latte"
                                 class="card-img-top rounded-top-4" alt="Kopi Latte">
                            <div class="card-body">
                                <h3 class="h6 fw-semibold mb-1">Kopi Latte</h3>
                                <p class="small text-muted mb-2">Kopi latte dengan rasa yang creamy.</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="fw-semibold">Rp 13.000</span>
                                    <button class="btn btn-kg-accent btn-sm rounded-circle" style="width: 32px; height: 32px;">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Pesanan Kamu -->
            <div class="col-lg-4 order-lg-2">
                <div class="card kg-card rounded-4 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h2 class="h5 fw-bold mb-0">Pesanan Kamu</h2>
                            <span class="badge btn-kg-accent rounded-pill">2</span>
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="https://placehold.co/60x60/171310/c0783f?text=KS"
                                 class="rounded-3" alt="Kopi Susu Gula Aren" style="width: 56px; height: 56px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <div class="small fw-semibold">Kopi Susu Gula Aren</div>
                                <small class="text-muted">x1</small>
                            </div>
                            <span class="small fw-semibold">Rp 12.000</span>
                            <button class="btn btn-sm btn-link text-danger p-0">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-4">
                            <img src="https://placehold.co/60x60/171310/c0783f?text=CP"
                                 class="rounded-3" alt="Cappuccino" style="width: 56px; height: 56px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <div class="small fw-semibold">Cappuccino</div>
                                <small class="text-muted">x1</small>
                            </div>
                            <span class="small fw-semibold">Rp 13.000</span>
                            <button class="btn btn-sm btn-link text-danger p-0">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>

                        <hr style="border-color: var(--kg-border);">

                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="small text-muted">Subtotal</span>
                            <span class="small">Rp 25.000</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="small text-muted">Ongkir</span>
                            <span class="small">Rp 4.000</span>
                        </div>

                        <hr style="border-color: var(--kg-border);">

                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold fs-5" style="color: var(--kg-accent);">Rp 29.000</span>
                        </div>

                        <a href="{{ url('/checkout') }}" class="btn btn-kg-accent w-100 rounded-3 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                            Lanjut ke Pembayaran <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection