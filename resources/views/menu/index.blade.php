@extends('layouts.app')

@section('title', 'Menu Pesan - Kopi Gerobakan')

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
            min-height: 100vh;
        }

        .kg-home h1,
        .kg-home h2,
        .kg-home h3,
        .kg-home .kg-display {
            font-family: 'Fraunces', serif;
        }

        /* ---------- PAGE HEADER ---------- */
        .kg-menu-header {
            background: var(--kg-espresso);
            border-radius: 0 0 2rem 2rem;
            padding: 2.75rem 1.5rem 4.25rem;
            position: relative;
            overflow: hidden;
            margin-bottom: -2.5rem;
        }

        .kg-menu-header::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 10% 10%, rgba(231, 163, 62, .16), transparent 45%),
                radial-gradient(circle at 90% 80%, rgba(166, 61, 47, .2), transparent 50%);
            pointer-events: none;
        }

        .kg-menu-header h1 {
            color: var(--kg-paper-card);
            font-weight: 800;
            font-size: clamp(1.6rem, 3.4vw, 2.3rem);
            margin-bottom: .35rem;
            position: relative;
        }

        .kg-menu-header p {
            color: #E9DCC7;
            margin-bottom: 0;
            position: relative;
        }

        /* ---------- SEARCH ---------- */
        .kg-search-wrap {
            position: relative;
        }

        .kg-search-wrap .form-control,
        .kg-search-wrap .input-group-text {
            background: var(--kg-paper-card);
            border: none;
            color: var(--kg-espresso);
        }

        .kg-search-wrap .form-control::placeholder {
            color: #9C8A75;
        }

        .kg-search-wrap .form-control:focus {
            box-shadow: none;
            background: #fff;
        }

        .kg-search-wrap .input-group {
            border-radius: 999px;
            overflow: hidden;
            box-shadow: 0 14px 28px -14px rgba(0, 0, 0, .5);
        }

        .kg-search-btn {
            background: var(--kg-gold);
            color: var(--kg-espresso);
            border: none;
            font-weight: 700;
            padding: 0 1.25rem;
        }

        .kg-search-btn:hover {
            background: #f0b458;
        }

        /* ---------- CONTENT CARD (raised over header) ---------- */
        .kg-content-card {
            position: relative;
            background: var(--kg-paper-card);
            border-radius: 1.75rem;
            padding: 1.75rem 1.5rem 2.5rem;
            box-shadow: 0 24px 48px -30px rgba(43, 27, 18, .4);
            z-index: 1;
        }

        /* ---------- CATEGORY PILLS ---------- */
        .kg-cat-pill {
            border-radius: 999px;
            padding: .5rem 1.1rem;
            font-weight: 700;
            font-size: .85rem;
            border: 1.5px solid rgba(43, 27, 18, .15);
            color: var(--kg-espresso-soft);
            background: transparent;
            transition: all .15s ease;
            text-decoration: none;
            display: inline-block;
        }

        .kg-cat-pill:hover {
            border-color: var(--kg-gold);
            color: var(--kg-espresso);
        }

        .kg-cat-pill.active {
            background: var(--kg-espresso);
            border-color: var(--kg-espresso);
            color: var(--kg-paper-card);
        }

        /* ---------- PRODUCT CARDS ---------- */
        .kg-card {
            background: #fff;
            border: 1px solid rgba(43, 27, 18, .08);
            border-radius: 1.25rem;
            overflow: hidden;
            transition: transform .18s ease, box-shadow .18s ease;
            height: 100%;
        }

        .kg-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 34px -18px rgba(43, 27, 18, .3);
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
            padding: .3rem .6rem;
            border-radius: 999px;
            box-shadow: 0 6px 14px -6px rgba(166, 61, 47, .6);
        }

        .kg-card-body {
            padding: .9rem 1rem 1.1rem;
        }

        .kg-card-body h3 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: .95rem;
            color: var(--kg-espresso);
            margin-bottom: .3rem;
        }

        .kg-desc {
            font-size: .78rem;
            color: var(--kg-espresso-soft);
            min-height: 2.2em;
            margin-bottom: .5rem;
        }

        .kg-stock {
            font-size: .74rem;
            color: var(--kg-olive);
            font-weight: 600;
            margin-bottom: .6rem;
            display: flex;
            align-items: center;
            gap: .3rem;
        }

        .kg-stock.low {
            color: var(--kg-brick);
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

        .kg-sold-out {
            background: rgba(166, 61, 47, .1);
            color: var(--kg-brick);
            font-size: .72rem;
            font-weight: 700;
            padding: .35rem .65rem;
            border-radius: 999px;
        }

        .kg-card.is-sold-out img {
            filter: grayscale(.5);
            opacity: .7;
        }

        .kg-empty {
            background: #fff;
            border: 1px dashed rgba(43, 27, 18, .25);
            border-radius: 1.25rem;
            padding: 3rem 1.5rem;
            text-align: center;
            color: var(--kg-espresso-soft);
        }
    </style>

    <div class="kg-home">

        {{-- ===================== HEADER ===================== --}}
        <div class="kg-menu-header">
            <div class="container-fluid position-relative">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-6">
                        <h1><i class="bi bi-cup-hot-fill" style="color: var(--kg-gold);"></i> Menu Pesan</h1>
                        <p>Pilih kopi favoritmu dan nikmati pengalaman ngopi terbaik dari gerobakan kami.</p>
                    </div>
                    <div class="col-lg-6">
                        <form action="{{ url('/menu') }}" method="GET" class="kg-search-wrap">
                            @if ($kategoriAktif !== 'semua')
                                <input type="hidden" name="kategori" value="{{ $kategoriAktif }}">
                            @endif
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" name="cari" value="{{ request('cari') }}" class="form-control"
                                    placeholder="Cari menu kopi favoritmu...">
                                <button type="submit" class="kg-search-btn">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== CONTENT ===================== --}}
        <div class="container-fluid">
            <div class="kg-content-card">

                <div class="d-flex gap-2 flex-wrap mb-4">
                    @foreach ($kategoriList as $kat)
                        <a href="{{ url('/menu') }}?kategori={{ $kat['id'] }}"
                            class="kg-cat-pill {{ $kategoriAktif === $kat['id'] ? 'active' : '' }}">
                            {{ $kat['label'] }}
                        </a>
                    @endforeach
                </div>

                <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3 g-md-4">
                    @php
                        $kgFallbackImages = [
                            'https://images.unsplash.com/photo-1447933601403-0c6688de566e?auto=format&fit=crop&w=500&q=80',
                            'https://images.unsplash.com/photo-1497935586351-b67a49e012bf?auto=format&fit=crop&w=500&q=80',
                            'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=500&q=80',
                            'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?auto=format&fit=crop&w=500&q=80',
                            'https://images.unsplash.com/photo-1442512595331-e89e73853f31?auto=format&fit=crop&w=500&q=80',
                        ];
                    @endphp

                    @forelse ($menusFiltered as $i => $item)
                        <div class="col">
                            <div class="kg-card position-relative {{ $item->stok <= 0 ? 'is-sold-out' : '' }}">

                                @if ($item->is_bestseller || $item->tag)
                                    <span class="kg-badge">
                                        {{ $item->is_bestseller ? '★ Best Seller' : $item->tag }}
                                    </span>
                                @endif

                                @if ($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}">
                                @else
                                    <img src="{{ $kgFallbackImages[$i % count($kgFallbackImages)] }}"
                                        alt="{{ $item->nama }}">
                                @endif

                                <div class="kg-card-body d-flex flex-column">
                                    <h3>{{ $item->nama }}</h3>
                                    <p class="kg-desc">{{ $item->deskripsi }}</p>

                                    <div class="kg-stock {{ $item->stok <= 5 && $item->stok > 0 ? 'low' : '' }}">
                                        <i class="bi bi-box-seam"></i>
                                        @if ($item->stok > 0)
                                            Stok {{ $item->stok }}
                                        @else
                                            Stok habis
                                        @endif
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="kg-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>

                                        @if ($item->stok > 0)
                                            <form action="{{ url('/keranjang/tambah') }}" method="POST" class="m-0">
                                                @csrf
                                                <input type="hidden" name="menu_id" value="{{ $item->id }}">
                                                <button type="submit" class="kg-add-btn">
                                                    <i class="bi bi-plus fs-5"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="kg-sold-out">Habis</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="kg-empty">
                                <i class="bi bi-cup-straw fs-1 d-block mb-2" style="color:var(--kg-gold);"></i>
                                Menu untuk kategori ini belum tersedia.
                            </div>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

    </div>

@endsection
