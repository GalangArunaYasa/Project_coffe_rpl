@extends('layouts.app')

@section('title', 'Tentang Kami - Kopi Gerobakan')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,700;0,9..144,800;0,9..144,900;1,9..144,600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .kg-about-page {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #f5f0ec;
        min-height: 100vh;
    }

    .kg-about-page h1,
    .kg-about-page h2,
    .kg-about-page h3,
    .kg-about-page h4 {
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

    /* ---------- HERO ABOUT CARD ---------- */
    .kg-hero-card {
        background: var(--kg-surface, #171310);
        border: 1px solid var(--kg-border, #2c241f);
        border-radius: 1.5rem;
        padding: 2rem;
        box-shadow: 0 16px 36px -12px rgba(0, 0, 0, 0.5);
    }

    @media (min-width: 992px) {
        .kg-hero-card {
            padding: 2.5rem 3rem;
        }
    }

    .kg-hero-img-wrap {
        border-radius: 1.25rem;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: var(--kg-surface-light, #201a16);
        aspect-ratio: 16 / 11;
        width: 100%;
        box-shadow: 0 8px 24px -6px rgba(0, 0, 0, 0.4);
    }

    .kg-hero-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center center;
        display: block;
        image-rendering: -webkit-optimize-contrast;
        image-rendering: auto;
        transform: translateZ(0);
        backface-visibility: hidden;
    }

    .kg-hero-title {
        font-weight: 800;
        font-size: clamp(1.75rem, 3.2vw, 2.4rem);
        line-height: 1.18;
        color: #f5f0ec;
    }

    .kg-hero-text {
        color: #c4b5a8;
        font-size: 0.98rem;
        line-height: 1.7;
    }

    /* ---------- TEAM SECTION ---------- */
    .kg-section-heading {
        font-weight: 800;
        font-size: clamp(1.6rem, 3vw, 2.2rem);
        line-height: 1.2;
    }

    .kg-section-subheading {
        color: var(--kg-text-muted, #a89c92);
        font-size: 0.95rem;
    }

    .kg-team-card {
        background: var(--kg-surface, #171310);
        border: 1px solid var(--kg-border, #2c241f);
        border-radius: 1.25rem;
        padding: 1.25rem 1.15rem;
        transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        position: relative;
    }

    .kg-team-card:hover {
        transform: translateY(-5px);
        border-color: rgba(192, 120, 63, 0.4);
        box-shadow: 0 16px 30px -10px rgba(0, 0, 0, 0.55);
    }

    .kg-team-badge-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        color: #f5f0ec;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 8px;
        padding: 0.2rem 0.55rem;
        margin-bottom: 0.85rem;
    }

    .kg-team-photo-box {
        border-radius: 0.95rem;
        overflow: hidden;
        background: var(--kg-surface-light, #201a16);
        border: 1px solid rgba(255, 255, 255, 0.06);
        margin-bottom: 1rem;
        aspect-ratio: 1 / 1;
    }

    .kg-team-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .kg-member-name {
        font-weight: 700;
        font-size: 1.02rem;
        color: #ffffff;
        letter-spacing: -0.01em;
        margin-bottom: 0.2rem;
    }

    .kg-member-role {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--kg-accent, #c0783f);
        margin-bottom: 0.65rem;
        display: block;
    }

    .kg-member-desc {
        color: var(--kg-text-muted, #a89c92);
        font-size: 0.78rem;
        line-height: 1.55;
        margin-bottom: 0.95rem;
    }

    .kg-team-socials {
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        padding-top: 0.75rem;
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }

    .kg-social-item {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        color: #8e8175;
        font-size: 0.74rem;
        text-decoration: none;
        transition: color 0.15s ease;
        word-break: break-all;
    }

    .kg-social-item i {
        font-size: 0.85rem;
        color: var(--kg-accent, #c0783f);
        flex-shrink: 0;
    }

    .kg-social-item:hover {
        color: #f5f0ec;
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
                rgba(23, 19, 16, 0.92) 0%,
                rgba(23, 19, 16, 0.85) 100%
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
        max-width: 440px;
    }

    .kg-cta-heading-right {
        font-weight: 800;
        font-size: clamp(1.3rem, 2.2vw, 1.65rem);
        line-height: 1.28;
        color: #ffffff;
    }

    .btn-kg-outline-light {
        background: rgba(23, 19, 16, 0.4);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #f5f0ec;
        font-weight: 600;
        transition: all 0.15s ease;
    }

    .btn-kg-outline-light:hover {
        background: rgba(255, 255, 255, 0.12);
        border-color: rgba(255, 255, 255, 0.45);
        color: #ffffff;
    }
</style>

<div class="kg-about-page py-4 py-lg-4 px-3 px-lg-4">
    <div class="container-fluid p-0">

        {{-- ===================== 1. HEADER HALAMAN ===================== --}}
        <div class="mb-4 mb-lg-4">
            <h1 class="kg-page-header-title mb-2">
                Tentang <span class="kg-text-accent">Kopi Gerobakan</span>
            </h1>
            <p class="kg-page-header-subtitle mb-0">
                Bukan sekadar kopi, tapi cerita yang kami bawa ke setiap sudut kota.
            </p>
        </div>

        {{-- ===================== 2. HERO ABOUT (CARD UTAMA) ===================== --}}
        <section class="kg-hero-card mb-5">
            <div class="row g-4 g-lg-5 align-items-center">
                <div class="col-lg-6">
                    <div class="kg-hero-img-wrap">
                        <img src="{{ asset('image/about/gerobak.jpg') }}"
                             alt="Gerobak Kopi Gerobakan"
                             class="kg-hero-img">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="pe-lg-2">
                        <h2 class="kg-hero-title mb-3">
                            Berawal dari Gerobak,<br>
                            <span class="kg-text-accent">Tumbuh Bersama Kamu.</span>
                        </h2>
                        <p class="kg-hero-text mb-4">
                            KOPI GEROBAKAN hadir untuk membawa pengalaman menikmati kopi berkualitas dengan cara yang sederhana, dekat, dan bersahabat. Kami percaya secangkir kopi yang enak tidak harus mahal dan tidak harus datang dari tempat yang mewah.
                        </p>
                        <a href="{{ url('/menu') }}" class="btn btn-kg-accent btn-lg rounded-3 px-4 d-inline-flex align-items-center gap-2">
                            Lihat Menu <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===================== 3. SECTION TIM ===================== --}}
        <section class="mb-5">
            <div class="mb-4">
                <h2 class="kg-section-heading mb-2">
                    Tim di Balik <span class="kg-text-accent">Kopi Gerobakan</span>
                </h2>
                <p class="kg-section-subheading mb-0">
                    Lima orang, satu cerita, dan satu tujuan: menghadirkan pengalaman kopi terbaik untuk kamu.
                </p>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3 g-xl-3">
                @foreach ($teamMembers as $member)
                    <div class="col">
                        <div class="kg-team-card h-100 d-flex flex-column">
                            <div>
                                <span class="kg-team-badge-num">{{ $member['number'] }}</span>
                            </div>

                            <div class="kg-team-photo-box">
                                <img src="{{ asset($member['image']) }}"
                                     alt="{{ $member['name'] }}"
                                     class="kg-team-photo">
                            </div>

                            <div class="d-flex flex-column flex-grow-1">
                                <h3 class="kg-member-name">{{ $member['name'] }}</h3>
                                <span class="kg-member-role">{{ $member['role'] }}</span>
                                <p class="kg-member-desc flex-grow-1">
                                    {{ $member['description'] }}
                                </p>

                                <div class="kg-team-socials">
                                    <a href="{{ $member['instagram_url'] }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="kg-social-item">
                                        <i class="bi bi-instagram"></i>
                                        <span>{{ $member['instagram'] }}</span>
                                    </a>
                                    <a href="{{ $member['github_url'] }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="kg-social-item">
                                        <i class="bi bi-github"></i>
                                        <span>{{ $member['github'] }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- ===================== 4. SECTION CTA / PENUTUP ===================== --}}
        <section class="kg-cta-card mb-3">
            <img src="{{ asset('image/about/coffetentang.jpg') }}"
                 alt="Secangkir Kopi Gerobakan"
                 class="kg-cta-bg-img">
            <div class="kg-cta-overlay"></div>

            <div class="kg-cta-content">
                <div class="row g-4 align-items-center justify-content-between">
                    <div class="col-lg-5 col-md-6">
                        <h3 class="kg-cta-heading-left mb-2">Satu Tim, Satu Cerita.</h3>
                        <p class="kg-cta-desc-left mb-0">
                            KOPI GEROBAKAN bukan hanya tentang kopi, tetapi tentang kerja sama, kreativitas, dan perjalanan yang kami bangun bersama.
                        </p>
                    </div>

                    <div class="col-lg-6 col-md-6 text-md-end">
                        <h4 class="kg-cta-heading-right mb-3">
                            Mari Nikmati Cerita Kami<br class="d-none d-lg-inline"> dalam Setiap Tegukan.
                        </h4>
                        <div class="d-flex flex-wrap gap-2 justify-content-start justify-content-md-end">
                            <a href="{{ url('/payment') }}" class="btn btn-kg-accent rounded-3 px-3 py-2 d-inline-flex align-items-center gap-2">
                                Pesan Sekarang <i class="bi bi-arrow-right"></i>
                            </a>
                            <a href="{{ url('/lokasi') }}" class="btn btn-kg-outline-light rounded-3 px-3 py-2">
                                Lihat Lokasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

@endsection
