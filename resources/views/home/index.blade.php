@extends('layouts.app')

@section('title', 'Beranda - Kopi Gerobakan')

@section('content')

    @php
        // Data menu & pesanan dipindah ke sini supaya markup di bawah tidak berulang.
        // Idealnya nanti diambil dari database (controller), bukan hardcode.
        $menuPopuler = [
            [
                'nama' => 'Kopi Susu Gula Aren',
                'deskripsi' => 'Kopi, susu segar, gula aren asli.',
                'harga' => 12000,
                'gambar' => 'Kopi+Susu',
            ],
            [
                'nama' => 'Es Kopi Hitam',
                'deskripsi' => 'Kopi hitam segar biji pilihan.',
                'harga' => 9000,
                'gambar' => 'Es+Kopi',
            ],
            [
                'nama' => 'Cappuccino',
                'deskripsi' => 'Kopi dengan busa susu lembut.',
                'harga' => 13000,
                'gambar' => 'Cappuccino',
            ],
            [
                'nama' => 'Kopi Latte',
                'deskripsi' => 'Kopi latte dengan rasa creamy.',
                'harga' => 13000,
                'gambar' => 'Kopi+Latte',
            ],
        ];

        $pesanan = [
            ['nama' => 'Kopi Susu Gula Aren', 'qty' => 1, 'harga' => 12000, 'gambar' => 'KS'],
            ['nama' => 'Cappuccino', 'qty' => 1, 'harga' => 13000, 'gambar' => 'CP'],
        ];

        $subtotal = array_sum(array_map(fn($i) => $i['harga'] * $i['qty'], $pesanan));
        $ongkir = 4000;
        $total = $subtotal + $ongkir;

        $rekomendasi = [
            ['nama' => 'Es Kopi Hitam', 'harga' => 9000, 'gambar' => 'Es+Kopi'],
            ['nama' => 'Cappuccino', 'harga' => 13000, 'gambar' => 'Cappuccino'],
            ['nama' => 'Kopi Latte', 'harga' => 13000, 'gambar' => 'Kopi+Latte'],
            ['nama' => 'Chocolate', 'harga' => 12000, 'gambar' => 'Chocolate'],
            ['nama' => 'Matcha Latte', 'harga' => 14000, 'gambar' => 'Matcha+Latte'],
        ];

        // Palet placeholder dibuat lebih cerah: krem terang dengan aksen cokelat.
        $imgBg = 'f5efe6';
        $imgAccent = 'a8632f';
    @endphp

    <!-- Hero -->
    <section class="container-fluid py-5">
        <div class="row align-items-center gy-4">
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold mb-3">
                    Kopi Nikmat,<br>
                    <span style="color: var(--kg-accent);">Harga Bersahabat.</span>
                </h1>
                <p class="lead  mb-4 text-light">
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
                <img src="https://placehold.co/600x400/171310/c0783f?text=Kopi+Gerobakan" alt="Gerobak Kopi"
                    class="img-fluid rounded-4 shadow">
            </div>
        </div>
    </section>

    <!-- Menu & Pesanan -->
    <section class="container-fluid pb-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="h4 fw-bold mb-0">
                <i class="bi bi-cup-straw me-1" style="color: var(--kg-accent);"></i> Kamu Mungkin Juga Suka
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
            @foreach ($rekomendasi as $item)
                <div class="col">
                    <div class="card kg-card rounded-4 h-100">
                        <img src="https://placehold.co/300x300/{{ $imgBg }}/{{ $imgAccent }}?text={{ $item['gambar'] }}"
                            class="card-img-top rounded-top-4" alt="{{ $item['nama'] }}">
                        <div class="card-body">
                            <h3 class="h6 fw-semibold mb-2 text-light">{{ $item['nama'] }}</h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fw-semibold small text-light">Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
                                <button class="btn btn-kg-accent btn-sm rounded-circle" style="width: 30px; height: 30px;">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <section class="mt-5">

    </section>

@endsection
