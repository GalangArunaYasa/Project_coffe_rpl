@extends('layouts.app')

@section('title', 'Beranda - Kopi Gerobakan')

@section('content')

    <section class="container-fluid py-5">
        <div class="row align-items-center gy-4">
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold mb-3">
                    Kopi Nikmat,<br>
                    <span style="color: var(--kg-accent);">Harga Bersahabat.</span>
                </h1>
                <p class="lead mb-4 text-light">
                    Aruna Coffee — rasa premium, harga tetap ramah di kantong. Pesan sekarang, nikmati dimana saja!
                </p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="{{ url('/payment') }}" class="btn btn-kg-accent btn-lg rounded-3 px-4 fw-semibold">
                        Pesan Sekarang <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ url('/menu') }}" class="btn btn-outline-light btn-lg rounded-3 px-4 fw-semibold">
                        Lihat Menu
                    </a>
                </div>

                <div class="d-flex flex-wrap gap-4 text-muted small">
                    <span class="text-light"><i class="bi bi-cup-hot me-1" style="color: var(--kg-accent);"></i> Rasa Premium</span>
                    <span class="text-light"><i class="bi bi-scooter me-1" style="color: var(--kg-accent);"></i> Pesan & Antar</span>
                    <span class="text-light"><i class="bi bi-wallet2 me-1" style="color: var(--kg-accent);"></i> Pembayaran Mudah</span>
                </div>
            </div>

            <div class="col-lg-6 d-none d-lg-block text-center">
                <img src="https://placehold.co/600x400/171310/c0783f?text=Kopi+Gerobakan" alt="Gerobak Kopi" class="img-fluid rounded-4 shadow">
            </div>
        </div>
    </section>

    <section class="container-fluid pb-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="h4 fw-bold mb-0">
                <i class="bi bi-star-fill me-1" style="color: var(--kg-accent);"></i> Menu Best Seller Kami
            </h2>
            <a href="{{ url('/menu') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Lihat Semua</a>
        </div>

        <div class="row row-cols-2 row-cols-md-5 g-3">
            @forelse ($rekomendasi as $item)
                <div class="col">
                    <div class="card kg-card rounded-4 h-100 position-relative">
                        @if($item->tag || $item->is_bestseller)
                            <span class="badge kg-card border position-absolute top-0 start-0 m-2 fw-semibold" style="color: var(--kg-accent); z-index: 2;">
                                {{ $item->is_bestseller ? '★ Best Seller' : $item->tag }}
                            </span>
                        @endif

                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top rounded-top-4" style="aspect-ratio: 4/3; object-fit: cover;" alt="{{ $item->nama }}">
                        @else
                            <img src="https://placehold.co/300x300/f5efe6/a8632f?text={{ urlencode($item->nama) }}" class="card-img-top rounded-top-4" alt="{{ $item->nama }}">
                        @endif

                        <div class="card-body d-flex flex-column justify-content-between">
                            <h3 class="h6 fw-semibold mb-2 text-light">{{ $item->nama }}</h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fw-semibold small text-light">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                <a href="{{ url('/menu') }}" class="btn btn-kg-accent btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                    <i class="bi bi-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted text-center py-4">Belum ada menu Best Seller yang ditentukan oleh Admin.</p>
                </div>
            @endforelse
        </div>
    </section>

@endsection