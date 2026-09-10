@extends('layouts.app')

@section('title', 'Lokasi Kafe Kami - Aruna Coffee House')

@section('content')

<div class="container-fluid px-3 px-lg-5 py-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">Lokasi Kafe</li>
        </ol>
    </nav>

    <div class="text-center mx-auto mb-5" style="max-width: 650px;">
        <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill mb-2">Kedai Kopi Rintisan Kami</span>
        <h1 class="h2 fw-extrabold text-white mb-2">Kunjungi Aruna Coffee House</h1>
        <p class="text-muted">Nikmati secangkir kopi hangat dan suasana kafe yang cozy untuk menemani aktivitas harianmu.</p>
    </div>

    <!-- Main Single Cafe Location Card -->
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="kg-card rounded-4 p-4 p-md-5 shadow-lg">
                <div class="row align-items-center gy-4">
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge bg-success rounded-pill px-3 py-2 fw-bold">
                                <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> BUKA SETIAP HARI
                            </span>
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold">
                                <i class="bi bi-star-fill me-1"></i> 4.9 (1.500+ Reviews)
                            </span>
                        </div>

                        <h2 class="h3 fw-bold text-white mb-2">Aruna Coffee House</h2>
                        <p class="text-muted fs-6 mb-3">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i> Jl. Pemuda Raya No. 18 (Kawasan Kampus & Pusat Kreatif), Kota Malang
                        </p>

                        <div class="p-3 rounded-4 mb-4" style="background-color: var(--kg-surface-light);">
                            <div class="row g-3 text-white small">
                                <div class="col-sm-6">
                                    <div><i class="bi bi-clock-fill text-warning me-2"></i> <strong>Jam Operasional:</strong></div>
                                    <div class="ps-4 text-muted">08.00 - 23.00 WIB (Buka Setiap Hari)</div>
                                </div>
                                <div class="col-sm-6">
                                    <div><i class="bi bi-whatsapp text-success me-2"></i> <strong>WhatsApp CS:</strong></div>
                                    <div class="ps-4">
                                        <a href="https://wa.me/62895326630712" target="_blank" rel="noopener noreferrer" class="text-warning text-decoration-none fw-bold">
                                            0895-3266-30712 <i class="bi bi-box-arrow-up-right small"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div><i class="bi bi-instagram text-danger me-2"></i> <strong>Instagram Resmi:</strong></div>
                                    <div class="ps-4">
                                        <a href="https://www.instagram.com/garunayanza" target="_blank" rel="noopener noreferrer" class="text-warning text-decoration-none fw-bold">
                                            @garunayanza <i class="bi bi-box-arrow-up-right small"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div><i class="bi bi-geo-alt-fill text-danger me-2"></i> <strong>Alamat Kafe:</strong></div>
                                    <div class="ps-4">
                                        <a href="https://maps.app.goo.gl/arKRVNFRJaMSyZPU8" target="_blank" rel="noopener noreferrer" class="text-white text-decoration-none">
                                            Jl. Pemuda Raya No. 18, Kota Malang <i class="bi bi-box-arrow-up-right text-warning small ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h3 class="h6 fw-bold text-white mb-2">Fasilitas Kafe:</h3>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-dark border border-secondary text-white py-2 px-3"><i class="bi bi-wifi text-warning me-1"></i> WiFi Kencang</span>
                                <span class="badge bg-dark border border-secondary text-white py-2 px-3"><i class="bi bi-plug text-warning me-1"></i> Stopkontak Meja</span>
                                <span class="badge bg-dark border border-secondary text-white py-2 px-3"><i class="bi bi-snow text-info me-1"></i> AC Indoor & Cozy Outdoor</span>
                                <span class="badge bg-dark border border-secondary text-white py-2 px-3"><i class="bi bi-music-note-beamed text-warning me-1"></i> Chill Music</span>
                                <span class="badge bg-dark border border-secondary text-white py-2 px-3"><i class="bi bi-p-square text-success me-1"></i> Parkir Luas</span>
                            </div>
                        </div>

                        <div class="d-flex gap-2 flex-wrap">
                            <a href="https://maps.app.goo.gl/arKRVNFRJaMSyZPU8" target="_blank" rel="noopener noreferrer" class="btn btn-kg-accent rounded-pill px-4 py-2 fw-bold shadow">
                                <i class="bi bi-geo-alt-fill me-1"></i> Buka di Google Maps <i class="bi bi-arrow-up-right ms-1"></i>
                            </a>
                            <a href="https://wa.me/62895326630712" target="_blank" rel="noopener noreferrer" class="btn btn-kg-outline rounded-pill px-4 py-2 fw-semibold text-success">
                                <i class="bi bi-whatsapp me-1"></i> Chat WhatsApp
                            </a>
                            <a href="{{ route('menu') }}" class="btn btn-kg-outline rounded-pill px-4 py-2 fw-semibold">
                                <i class="bi bi-cup-hot me-1 text-warning"></i> Lihat Menu Kopi
                            </a>
                        </div>
                    </div>

                    <div class="col-md-6 text-center">
                        <div class="rounded-4 overflow-hidden border shadow" style="border-color: rgba(255, 255, 255, 0.08);">
                            <img src="{{ asset('images/hero_coffee_bar.jpg') }}" alt="Aruna Coffee Shop" class="img-fluid w-100" style="max-height: 380px; object-fit: cover;">
                        </div>
                        <small class="d-block mt-2" style="color: #756c66; font-size: 0.75rem;">Suasana hangat dan cozy di Aruna Coffee House</small>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

@endsection
