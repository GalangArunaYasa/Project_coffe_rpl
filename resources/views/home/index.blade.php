@extends('layouts.app')

@section('title', 'Beranda - Kopi Gerobakan')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,700;0,9..144,900;1,9..144,600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .kg-home {
        --kg-espresso: #2B1B12;
        --kg-espresso-soft: #43301F;
        --kg-paper: #F6ECD9;
        --kg-paper-card: #FFFBF3;
        --kg-gold: #E7A33E;
        --kg-gold-deep: #C9812A;
        --kg-brick: #A63D2F;
        --kg-olive: #6B7A4F;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--kg-espresso);
        background: var(--kg-paper);
    }

    .kg-home h1, .kg-home h2, .kg-home h3, .kg-home .kg-display {
        font-family: 'Fraunces', serif;
    }

    /* ---------- HERO ---------- */
    .kg-hero {
        position: relative;
        overflow: hidden;
        background: var(--kg-espresso);
        border-radius: 0 0 2.5rem 2.5rem;
        padding: 3.5rem 1.5rem 5.5rem;
    }
    .kg-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 15% 20%, rgba(231,163,62,0.16), transparent 45%),
                           radial-gradient(circle at 85% 75%, rgba(166,61,47,0.22), transparent 50%);
        pointer-events: none;
    }
    .kg-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        color: var(--kg-gold);
        font-weight: 700;
        font-size: .8rem;
        letter-spacing: .12em;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }
    .kg-eyebrow::before {
        content: "";
        width: 22px;
        height: 2px;
        background: var(--kg-gold);
        display: inline-block;
    }
    .kg-hero h1 {
        color: var(--kg-paper-card);
        font-weight: 900;
        font-size: clamp(2.2rem, 5vw, 3.4rem);
        line-height: 1.08;
    }
    .kg-hero h1 em {
        font-style: italic;
        color: var(--kg-gold);
    }
    .kg-hero p.lead {
        color: #E9DCC7;
        max-width: 34rem;
        font-size: 1.05rem;
    }
    .btn-kg-primary {
        background: var(--kg-gold);
        color: var(--kg-espresso);
        border: none;
        font-weight: 700;
        transition: transform .15s ease, background .15s ease;
    }
    .btn-kg-primary:hover {
        background: #f0b458;
        transform: translateY(-2px);
        color: var(--kg-espresso);
    }
    .btn-kg-ghost {
        background: transparent;
        border: 1.5px solid rgba(246,236,217,.4);
        color: var(--kg-paper-card);
        font-weight: 700;
        transition: border-color .15s ease, background .15s ease;
    }
    .btn-kg-ghost:hover {
        border-color: var(--kg-gold);
        background: rgba(231,163,62,.1);
        color: var(--kg-paper-card);
    }
    .kg-chip {
        background: rgba(246,236,217,.08);
        border: 1px solid rgba(246,236,217,.18);
        color: #E9DCC7;
        border-radius: 999px;
        padding: .4rem .85rem;
        font-size: .82rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
    }
    .kg-chip i { color: var(--kg-gold); }

    .kg-hero-art {
        position: relative;
    }
    .kg-hero-art img {
        border-radius: 1.75rem;
        box-shadow: 0 30px 60px -20px rgba(0,0,0,.55);
        border: 6px solid rgba(246,236,217,.08);
    }
    .kg-hero-badge {
        position: absolute;
        bottom: -1.25rem;
        left: -1.25rem;
        background: var(--kg-paper-card);
        color: var(--kg-espresso);
        border-radius: 1.25rem;
        padding: .9rem 1.15rem;
        box-shadow: 0 18px 30px -12px rgba(0,0,0,.4);
        display: flex;
        align-items: center;
        gap: .7rem;
        max-width: 220px;
    }
    .kg-hero-badge .num {
        font-family: 'Fraunces', serif;
        font-weight: 800;
        font-size: 1.6rem;
        color: var(--kg-brick);
        line-height: 1;
    }
    .kg-hero-badge small {
        font-size: .72rem;
        color: var(--kg-espresso-soft);
        font-weight: 600;
        display: block;
    }

    /* ---------- AWNING DIVIDER (signature element) ---------- */
    .kg-awning {
        display: block;
        width: 100%;
        height: 34px;
        margin-top: -1px;
    }

    /* ---------- MENU SECTION ---------- */
    .kg-menu-section { padding: 3.5rem 1.5rem 4.5rem; }
    .kg-section-heading h2 {
        font-weight: 800;
        font-size: clamp(1.5rem, 3vw, 2.1rem);
        color: var(--kg-espresso);
        margin-bottom: .15rem;
    }
    .kg-section-heading p {
        color: var(--kg-espresso-soft);
        font-size: .95rem;
        margin-bottom: 0;
    }
    .btn-kg-outline {
        border: 1.5px solid var(--kg-espresso);
        color: var(--kg-espresso);
        font-weight: 700;
        background: transparent;
    }
    .btn-kg-outline:hover {
        background: var(--kg-espresso);
        color: var(--kg-paper-card);
    }

    .kg-card {
        background: var(--kg-paper-card);
        border: 1px solid rgba(43,27,18,.08);
        border-radius: 1.25rem;
        overflow: hidden;
        transition: transform .18s ease, box-shadow .18s ease;
        height: 100%;
    }
    .kg-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 34px -18px rgba(43,27,18,.35);
    }
    .kg-card img {
        aspect-ratio: 4/3;
        object-fit: cover;
        width: 100%;
    }
    .kg-badge {
        position: absolute;
        top: .65rem;
        left: .65rem;
        z-index: 2;
        background: var(--kg-brick);
        color: #fff;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .02em;
        padding: .3rem .6rem;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        box-shadow: 0 6px 14px -6px rgba(166,61,47,.6);
    }
    .kg-card-body {
        padding: .9rem 1rem 1.1rem;
    }
    .kg-card-body h3 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: .95rem;
        color: var(--kg-espresso);
        margin-bottom: .55rem;
        min-height: 2.4em;
    }
    .kg-price {
        font-weight: 800;
        font-size: .92rem;
        color: var(--kg-espresso);
    }
    .kg-add-btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: var(--kg-gold);
        color: var(--kg-espresso);
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: background .15s ease, transform .15s ease;
    }
    .kg-add-btn:hover {
        background: var(--kg-brick);
        color: #fff;
        transform: scale(1.08);
    }
    .kg-empty {
        background: var(--kg-paper-card);
        border: 1px dashed rgba(43,27,18,.25);
        border-radius: 1.25rem;
        padding: 2.5rem 1.5rem;
        text-align: center;
        color: var(--kg-espresso-soft);
    }
</style>

<div class="kg-home">

    {{-- ===================== HERO ===================== --}}
    <section class="kg-hero">
        <div class="container-fluid position-relative" style="z-index:1;">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6">
                    <span class="kg-eyebrow"><i class="bi bi-cup-hot-fill"></i> Aruna Coffee &mdash; Gerobak Keliling</span>
                    <h1 class="mb-3">
                        Kopi Racikan Sendiri,<br>
                        <em>Rasa Kampung Halaman.</em>
                    </h1>
                    <p class="lead mb-4">
                        Diseduh langsung dari gerobak, disajikan hangat ke tanganmu. Harga bersahabat, rasa yang bikin nagih tiap hari.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <a href="{{ url('/payment') }}" class="btn btn-kg-primary btn-lg rounded-3 px-4">
                            Pesan Sekarang <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="{{ url('/menu') }}" class="btn btn-kg-ghost btn-lg rounded-3 px-4">
                            Lihat Menu
                        </a>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <span class="kg-chip"><i class="bi bi-cup-hot"></i> Rasa Premium</span>
                        <span class="kg-chip"><i class="bi bi-scooter"></i> Pesan &amp; Antar</span>
                        <span class="kg-chip"><i class="bi bi-wallet2"></i> Pembayaran Mudah</span>
                    </div>
                </div>

                <div class="col-lg-6 d-none d-lg-block">
                    <div class="kg-hero-art">
                        <img src="{{ asset('image/home.jpeg') }}"
                             alt="Racikan kopi gerobak" class="img-fluid w-100">
                        <div class="kg-hero-badge">
                            <span class="num">4.9</span>
                            <span>
                                <small>Rating Pelanggan</small>
                                <i class="bi bi-star-fill" style="color:var(--kg-gold);"></i>
                                <i class="bi bi-star-fill" style="color:var(--kg-gold);"></i>
                                <i class="bi bi-star-fill" style="color:var(--kg-gold);"></i>
                                <i class="bi bi-star-fill" style="color:var(--kg-gold);"></i>
                                <i class="bi bi-star-fill" style="color:var(--kg-gold);"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== AWNING DIVIDER ===================== --}}
    <svg class="kg-awning" viewBox="0 0 400 20" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <polygon points="0,0 20,20 40,0" fill="#E7A33E"></polygon>
        <polygon points="40,0 60,20 80,0" fill="#A63D2F"></polygon>
        <polygon points="80,0 100,20 120,0" fill="#F6ECD9"></polygon>
        <polygon points="120,0 140,20 160,0" fill="#E7A33E"></polygon>
        <polygon points="160,0 180,20 200,0" fill="#A63D2F"></polygon>
        <polygon points="200,0 220,20 240,0" fill="#F6ECD9"></polygon>
        <polygon points="240,0 260,20 280,0" fill="#E7A33E"></polygon>
        <polygon points="280,0 300,20 320,0" fill="#A63D2F"></polygon>
        <polygon points="320,0 340,20 360,0" fill="#F6ECD9"></polygon>
        <polygon points="360,0 380,20 400,0" fill="#E7A33E"></polygon>
    </svg>

    {{-- ===================== BEST SELLER MENU ===================== --}}
    <section class="kg-menu-section">
        <div class="container-fluid">
            <div class="d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4 kg-section-heading">
                <div>
                    <h2><i class="bi bi-star-fill me-1" style="color:var(--kg-gold);"></i> Favorit Pelanggan</h2>
                    <p>Menu yang paling sering dipesan minggu ini.</p>
                </div>
                <a href="{{ url('/menu') }}" class="btn btn-kg-outline rounded-pill px-4">Lihat Semua Menu</a>
            </div>

            <div class="row row-cols-2 row-cols-md-5 g-3 g-md-4">
                @php
                    // Foto cadangan bertema kopi (dipakai bila menu belum punya gambar sendiri)
                    $kgFallbackImages = [
                        'https://images.unsplash.com/photo-1447933601403-0c6688de566e?auto=format&fit=crop&w=500&q=80',
                        'https://images.unsplash.com/photo-1497935586351-b67a49e012bf?auto=format&fit=crop&w=500&q=80',
                        'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=500&q=80',
                        'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?auto=format&fit=crop&w=500&q=80',
                        'https://images.unsplash.com/photo-1442512595331-e89e73853f31?auto=format&fit=crop&w=500&q=80',
                    ];
                @endphp

                @forelse ($rekomendasi as $i => $item)
                    <div class="col">
                        <div class="kg-card position-relative">
                            @if($item->tag || $item->is_bestseller)
                                <span class="kg-badge">
                                    @if($item->is_bestseller)
                                        <i class="bi bi-star-fill"></i> Best Seller
                                    @else
                                        {{ $item->tag }}
                                    @endif
                                </span>
                            @endif

                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}">
                            @else
                                <img src="{{ $kgFallbackImages[$i % count($kgFallbackImages)] }}" alt="{{ $item->nama }}">
                            @endif

                            <div class="kg-card-body">
                                <h3>{{ $item->nama }}</h3>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="kg-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                    <a href="{{ url('/menu') }}" class="kg-add-btn">
                                        <i class="bi bi-plus fs-5"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="kg-empty">
                            <i class="bi bi-cup fs-2 mb-2 d-block" style="color:var(--kg-gold);"></i>
                            Belum ada menu Best Seller yang ditentukan oleh Admin.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

</div>

@endsection