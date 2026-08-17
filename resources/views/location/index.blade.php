@extends('layouts.app')

@section('title', 'Lokasi Kami - Kopi Gerobakan')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,700;0,9..144,800;0,9..144,900;1,9..144,600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .kg-location-page {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #f5f0ec;
        min-height: 100vh;
    }

    .kg-location-page h1,
    .kg-location-page h2,
    .kg-location-page h3,
    .kg-location-page h4 {
        font-family: 'Fraunces', serif;
    }

    .kg-text-accent {
        color: var(--kg-accent, #c0783f);
    }

    /* ---------- PAGE HEADER ---------- */
    .kg-page-header-title {
        font-weight: 800;
        font-size: clamp(2rem, 4vw, 2.75rem);
        line-height: 1.15;
        letter-spacing: -0.02em;
    }

    .kg-page-header-subtitle {
        color: var(--kg-text-muted, #a89c92);
        font-size: clamp(0.95rem, 1.8vw, 1.05rem);
        max-width: 600px;
    }

    /* ---------- LOCATION LIST CARD ---------- */
    .kg-location-list-card {
        background: var(--kg-surface, #171310);
        border: 1px solid var(--kg-border, #2c241f);
        border-radius: 1.5rem;
        padding: 1.75rem 1.5rem;
        box-shadow: 0 16px 36px -12px rgba(0, 0, 0, 0.5);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .kg-list-card-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.25rem;
    }

    .kg-loc-item-card {
        background: #1c1613;
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 1.15rem;
        padding: 1.15rem 1.25rem;
        margin-bottom: 1rem;
        transition: border-color 0.2s ease, transform 0.2s ease;
    }

    .kg-loc-item-card:hover {
        border-color: rgba(192, 120, 63, 0.35);
        transform: translateY(-2px);
    }

    .kg-loc-icon-box {
        width: 46px;
        height: 46px;
        background: rgba(192, 120, 63, 0.12);
        border: 1px solid rgba(192, 120, 63, 0.3);
        border-radius: 12px;
        color: var(--kg-accent, #c0783f);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .kg-loc-name {
        font-weight: 700;
        font-size: 0.98rem;
        color: #ffffff;
        letter-spacing: -0.01em;
        margin-bottom: 0.35rem;
    }

    .kg-loc-meta {
        font-size: 0.8rem;
        color: var(--kg-text-muted, #a89c92);
        display: flex;
        align-items: center;
        gap: 0.35rem;
        margin-bottom: 0.2rem;
    }

    .kg-loc-meta i {
        font-size: 0.85rem;
        color: var(--kg-accent, #c0783f);
    }

    .kg-status-open {
        font-size: 0.78rem;
        font-weight: 600;
        color: #4ade80;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .kg-status-dot {
        width: 7px;
        height: 7px;
        background-color: #22c55e;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 8px rgba(34, 197, 94, 0.6);
    }

    .btn-kg-route {
        background: rgba(192, 120, 63, 0.18);
        border: 1px solid rgba(192, 120, 63, 0.4);
        color: #f5f0ec;
        font-size: 0.82rem;
        font-weight: 600;
        padding: 0.45rem 0.9rem;
        border-radius: 0.65rem;
        text-decoration: none;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        white-space: nowrap;
    }

    .btn-kg-route:hover {
        background: var(--kg-accent, #c0783f);
        border-color: var(--kg-accent, #c0783f);
        color: #ffffff;
        transform: translateX(2px);
    }

    .kg-btn-view-all {
        background: transparent;
        border: 1px dashed rgba(255, 255, 255, 0.15);
        color: var(--kg-text-muted, #a89c92);
        font-size: 0.85rem;
        font-weight: 600;
        padding: 0.75rem;
        border-radius: 0.95rem;
        text-align: center;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
        text-decoration: none;
        transition: all 0.2s ease;
        margin-top: auto;
    }

    .kg-btn-view-all:hover {
        border-color: var(--kg-accent, #c0783f);
        color: #ffffff;
        background: rgba(192, 120, 63, 0.08);
    }

    /* ---------- MAP AREA CARD ---------- */
    .kg-map-card {
        position: relative;
        background: var(--kg-surface, #171310);
        border: 1px solid var(--kg-border, #2c241f);
        border-radius: 1.5rem;
        overflow: hidden;
        min-height: 480px;
        height: 100%;
        box-shadow: 0 16px 36px -12px rgba(0, 0, 0, 0.5);
    }

    .kg-map-bg-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        z-index: 1;
        image-rendering: -webkit-optimize-contrast;
        image-rendering: auto;
    }

    .kg-map-overlay {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at center, rgba(23, 19, 16, 0.15) 0%, rgba(23, 19, 16, 0.6) 100%);
        z-index: 2;
        pointer-events: none;
    }

    .kg-map-ui-layer {
        position: absolute;
        inset: 0;
        z-index: 3;
        pointer-events: auto;
    }

    /* Markers on Map */
    .kg-map-marker-wrap {
        position: absolute;
        transform: translate(-50%, -50%);
        cursor: pointer;
        z-index: 5;
    }

    .kg-main-marker-pulse {
        position: absolute;
        width: 48px;
        height: 48px;
        background: rgba(192, 120, 63, 0.35);
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        animation: kgPulse 2.2s infinite ease-out;
        pointer-events: none;
    }

    @keyframes kgPulse {
        0% {
            transform: translate(-50%, -50%) scale(0.6);
            opacity: 0.9;
        }
        70% {
            transform: translate(-50%, -50%) scale(1.6);
            opacity: 0;
        }
        100% {
            transform: translate(-50%, -50%) scale(1.6);
            opacity: 0;
        }
    }

    .kg-map-pin-btn {
        width: 38px;
        height: 38px;
        background: linear-gradient(135deg, #d98a4e 0%, #b86b32 100%);
        border: 2px solid #ffffff;
        border-radius: 50%;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.6);
        position: relative;
        z-index: 2;
    }

    .kg-secondary-pin-btn {
        width: 32px;
        height: 32px;
        background: rgba(23, 19, 16, 0.85);
        border: 2px solid var(--kg-accent, #c0783f);
        border-radius: 50%;
        color: var(--kg-accent, #c0783f);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        transition: transform 0.2s ease;
    }

    .kg-secondary-pin-btn:hover {
        transform: scale(1.15);
        background: var(--kg-accent, #c0783f);
        color: #ffffff;
    }

    /* Popup card on map */
    .kg-map-popup-card {
        position: absolute;
        top: 34%;
        left: 63%;
        transform: translateY(-50%);
        background: rgba(23, 19, 16, 0.94);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(192, 120, 63, 0.4);
        border-radius: 1.15rem;
        padding: 1rem 1.25rem;
        box-shadow: 0 18px 36px rgba(0, 0, 0, 0.65);
        z-index: 6;
        min-width: 220px;
        max-width: 260px;
    }

    @media (max-width: 991.98px) {
        .kg-map-popup-card {
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
    }

    .kg-popup-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.3rem;
        line-height: 1.25;
    }

    /* ---------- INFORMASI LOKASI (3 ITEM) ---------- */
    .kg-info-card {
        background: var(--kg-surface, #171310);
        border: 1px solid var(--kg-border, #2c241f);
        border-radius: 1.5rem;
        padding: 1.75rem 2rem;
        box-shadow: 0 16px 36px -12px rgba(0, 0, 0, 0.5);
    }

    .kg-info-card-header {
        font-size: 1.05rem;
        font-weight: 700;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .kg-feature-item {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .kg-feature-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: #241d18;
        border: 1px solid rgba(192, 120, 63, 0.35);
        color: var(--kg-accent, #c0783f);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .kg-feature-title {
        font-weight: 700;
        font-size: 1rem;
        color: #ffffff;
        margin-bottom: 0.2rem;
    }

    .kg-feature-desc {
        color: var(--kg-text-muted, #a89c92);
        font-size: 0.84rem;
        line-height: 1.5;
        margin-bottom: 0;
    }

    /* ---------- CTA BANNER CARD ---------- */
    .kg-cta-card {
        position: relative;
        background: var(--kg-surface, #171310);
        border: 1px solid var(--kg-border, #2c241f);
        border-radius: 1.5rem;
        padding: 2.25rem 2rem;
        overflow: hidden;
        box-shadow: 0 16px 36px -12px rgba(0, 0, 0, 0.5);
    }

    @media (min-width: 992px) {
        .kg-cta-card {
            padding: 3.25rem 3.5rem;
            min-height: 200px;
        }
    }

    .kg-cta-bg-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center 60%;
        z-index: 1;
        image-rendering: -webkit-optimize-contrast;
        image-rendering: auto;
    }

    .kg-cta-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            90deg,
            rgba(23, 19, 16, 0.95) 0%,
            rgba(23, 19, 16, 0.78) 28%,
            rgba(23, 19, 16, 0.3) 50%,
            rgba(23, 19, 16, 0.78) 72%,
            rgba(23, 19, 16, 0.95) 100%
        );
        z-index: 2;
    }

    @media (max-width: 767.98px) {
        .kg-cta-overlay {
            background: linear-gradient(
                180deg,
                rgba(23, 19, 16, 0.95) 0%,
                rgba(23, 19, 16, 0.88) 100%
            );
        }
    }

    .kg-cta-content {
        position: relative;
        z-index: 3;
    }

    .kg-cta-heading-left {
        font-weight: 800;
        font-size: clamp(1.35rem, 2.3vw, 1.65rem);
        color: #ffffff;
        line-height: 1.25;
    }

    .kg-cta-desc-left {
        color: #d1c7be;
        font-size: 0.9rem;
        line-height: 1.65;
        max-width: 460px;
    }
</style>

<div class="kg-location-page py-4 py-lg-4 px-3 px-lg-4">
    <div class="container-fluid p-0">

        {{-- ===================== 1. HEADER HALAMAN ===================== --}}
        <div class="mb-4 mb-lg-4">
            <h1 class="kg-page-header-title mb-2">
                Temukan <br><span class="kg-text-accent">Gerobakan Kami</span>
            </h1>
            <p class="kg-page-header-subtitle mb-0">
                Temukan lokasi Kopi Gerobakan terdekat dan nikmati kopi favoritmu.
            </p>
        </div>

        {{-- ===================== 2. SECTION UTAMA (DAFTAR LOKASI & MAP) ===================== --}}
        <div class="row g-4 mb-4 mb-lg-5 align-items-stretch">
            
            {{-- KOLOM KIRI: DAFTAR LOKASI TERDEKAT --}}
            <div class="col-lg-5 col-xl-5">
                <div class="kg-location-list-card">
                    <div class="kg-list-card-title">
                        <i class="bi bi-geo-alt-fill" style="color: var(--kg-accent);"></i>
                        <span>Lokasi Terdekat</span>
                    </div>

                    <div class="kg-loc-items-wrap">
                        @foreach ($locations as $loc)
                            <div class="kg-loc-item-card">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="kg-loc-icon-box">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </div>

                                    <div class="flex-grow-1">
                                        <h3 class="kg-loc-name">{{ $loc['name'] }}</h3>
                                        <div class="kg-loc-meta">
                                            <i class="bi bi-geo-alt"></i>
                                            <span>{{ $loc['address'] }}</span>
                                        </div>
                                        <div class="kg-loc-meta">
                                            <i class="bi bi-clock"></i>
                                            <span>{{ $loc['hours'] }}</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-2 pt-1">
                                            <span class="kg-status-open">
                                                <span class="kg-status-dot"></span> {{ $loc['status'] }}
                                            </span>
                                            <button type="button" class="btn-kg-route">
                                                Lihat Rute <i class="bi bi-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a href="#mapArea" class="kg-btn-view-all">
                        <i class="bi bi-list"></i> Lihat Semua Lokasi
                    </a>
                </div>
            </div>

            {{-- KOLOM KANAN: MAP BESAR DENGAN OVERLAY PIN & POPUP --}}
            <div class="col-lg-7 col-xl-7" id="mapArea">
                <div class="kg-map-card">
                    <img src="{{ asset('image/lokasi/map.jpg') }}" alt="Peta Lokasi Kopi Gerobakan" class="kg-map-bg-img">
                    <div class="kg-map-overlay"></div>

                    <div class="kg-map-ui-layer">
                        {{-- Main Marker (Metro Pusat) --}}
                        <div class="kg-map-marker-wrap" style="top: 34%; left: 58%;">
                            <div class="kg-main-marker-pulse"></div>
                            <div class="kg-map-pin-btn">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                        </div>

                        {{-- Main Marker Popup Card --}}
                        <div class="kg-map-popup-card">
                            <h4 class="kg-popup-title">Kopi Gerobakan – Metro Pusat</h4>
                            <div class="kg-status-open mb-2">
                                <span class="kg-status-dot"></span> Buka sekarang
                            </div>
                            <button type="button" class="btn btn-kg-accent btn-sm rounded-3 px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1">
                                Lihat Rute <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>

                        {{-- Secondary Marker (Metro Timur) --}}
                        <div class="kg-map-marker-wrap" style="top: 44%; left: 34%;" title="Kopi Gerobakan – Metro Timur">
                            <div class="kg-secondary-pin-btn">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                        </div>

                        {{-- Additional Ambient Marker (Tejosari) --}}
                        @foreach ($extraPins as $extra)
                            <div class="kg-map-marker-wrap" style="top: {{ $extra['pin_top'] }}; left: {{ $extra['pin_left'] }};" title="{{ $extra['name'] }}">
                                <div class="kg-secondary-pin-btn">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        {{-- ===================== 3. SECTION INFORMASI LOKASI (3 ITEM) ===================== --}}
        <section class="kg-info-card mb-4 mb-lg-5">
            <div class="kg-info-card-header">
                <i class="bi bi-info-circle" style="color: var(--kg-accent);"></i>
                <span>Informasi Lokasi</span>
            </div>

            <div class="row g-4 row-cols-1 row-cols-md-3">
                @foreach ($infoFeatures as $feat)
                    <div class="col">
                        <div class="kg-feature-item">
                            <div class="kg-feature-icon-box">
                                <i class="bi {{ $feat['icon'] }}"></i>
                            </div>
                            <div>
                                <h4 class="kg-feature-title">{{ $feat['title'] }}</h4>
                                <p class="kg-feature-desc">{!! $feat['desc'] !!}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- ===================== 4. SECTION CTA / PENUTUP ===================== --}}
        <section class="kg-cta-card mb-3">
            <img src="{{ asset('image/about/coffetentang.jpg') }}"
                 alt="Kopi Gerobakan"
                 class="kg-cta-bg-img">
            <div class="kg-cta-overlay"></div>

            <div class="kg-cta-content">
                <div class="row g-4 align-items-center justify-content-between">
                    <div class="col-lg-6 col-md-7">
                        <h3 class="kg-cta-heading-left mb-2">Sudah menemukan lokasi favoritmu?</h3>
                        <p class="kg-cta-desc-left mb-0">
                            Pesan sekarang dan nikmati kopi favoritmu dari gerobakan terdekat.
                        </p>
                    </div>

                    <div class="col-lg-5 col-md-5 text-md-end">
                        <a href="{{ url('/payment') }}" class="btn btn-kg-accent btn-lg rounded-3 px-4 py-2.5 d-inline-flex align-items-center gap-2 fw-bold">
                            Pesan Sekarang <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

@endsection
