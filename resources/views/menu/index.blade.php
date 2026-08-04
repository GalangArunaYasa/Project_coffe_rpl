@extends('layouts.app')

@section('title', 'Menu Pesan - Kopi Gerobakan')

@section('content')

@php
    // Data dipindah ke sini biar markup di bawah tidak berulang-ulang.
    // Nantinya idealnya dari controller/database (MenuController@index).

    $kategoriAktif = request('kategori', 'semua');

    $kategoriList = [
        ['id' => 'semua',    'label' => 'Semua'],
        ['id' => 'kopi',     'label' => 'Kopi'],
        ['id' => 'non-kopi', 'label' => 'Non Kopi'],
        ['id' => 'signature','label' => 'Signature'],
        ['id' => 'snack',    'label' => 'Snack'],
    ];

    $menus = [
        ['id' => 1, 'nama' => 'Kopi Susu Gula Aren', 'deskripsi' => 'Perpaduan kopi, susu segar dan gula aren asli.', 'harga' => 12000, 'kategori' => 'signature', 'tag' => 'Signature', 'gambar' => 'Kopi+Susu+Gula+Aren'],
        ['id' => 2, 'nama' => 'Es Kopi Hitam',        'deskripsi' => 'Kopi hitam segar pilihan biji terbaik.',        'harga' => 9000,  'kategori' => 'kopi',      'tag' => null, 'gambar' => 'Es+Kopi+Hitam'],
        ['id' => 3, 'nama' => 'Cappuccino',           'deskripsi' => 'Kopi dengan busa susu lembut dan nikmat.',      'harga' => 13000, 'kategori' => 'kopi',      'tag' => null, 'gambar' => 'Cappuccino'],
        ['id' => 4, 'nama' => 'Kopi Latte',           'deskripsi' => 'Kopi latte dengan rasa yang creamy.',           'harga' => 13000, 'kategori' => 'kopi',      'tag' => null, 'gambar' => 'Kopi+Latte'],
        ['id' => 5, 'nama' => 'Chocolate',            'deskripsi' => 'Cokelat premium manis dan lembut.',             'harga' => 12000, 'kategori' => 'non-kopi',  'tag' => null, 'gambar' => 'Chocolate'],
        ['id' => 6, 'nama' => 'Matcha Latte',         'deskripsi' => 'Matcha premium dengan susu segar.',             'harga' => 14000, 'kategori' => 'non-kopi',  'tag' => null, 'gambar' => 'Matcha+Latte'],
        ['id' => 7, 'nama' => 'Lemon Tea',            'deskripsi' => 'Teh segar dengan perasan lemon asli.',          'harga' => 8000,  'kategori' => 'non-kopi',  'tag' => null, 'gambar' => 'Lemon+Tea'],
        ['id' => 8, 'nama' => 'Roti Bakar Cokelat',   'deskripsi' => 'Roti bakar renyah dengan cokelat premium.',     'harga' => 10000, 'kategori' => 'snack',     'tag' => null, 'gambar' => 'Roti+Bakar+Cokelat'],
    ];

    $menusFiltered = $kategoriAktif === 'semua'
        ? $menus
        : array_values(array_filter($menus, fn ($m) => $m['kategori'] === $kategoriAktif));

    $cartItems = [
        ['nama' => 'Kopi Susu Gula Aren', 'catatan' => null, 'harga' => 12000, 'qty' => 1, 'gambar' => 'KS'],
        ['nama' => 'Cappuccino',          'catatan' => null, 'harga' => 13000, 'qty' => 1, 'gambar' => 'CP'],
        ['nama' => 'Roti Bakar Cokelat',  'catatan' => null, 'harga' => 10000, 'qty' => 1, 'gambar' => 'RB'],
    ];

    $subtotal = array_sum(array_map(fn ($i) => $i['harga'] * $i['qty'], $cartItems));
    $ongkir   = count($cartItems) > 0 ? 4000 : 0;
    $total    = $subtotal + $ongkir;

    // Palet placeholder: krem terang dengan aksen cokelat, konsisten dgn halaman produk.
    $imgBg     = 'f5efe6';
    $imgAccent = 'a8632f';
@endphp

<div class="container-fluid py-4">

    <!-- Header halaman + pencarian -->
    <div class="row align-items-center mb-4 gy-3">
        <div class="col-lg-6">
            <h1 class="h3 fw-bold mb-1">
                Menu Pesan <i class="bi bi-cup-hot-fill" style="color: var(--kg-accent);"></i>
            </h1>
            <p class="text-muted mb-0">Pilih kopi favoritmu dan nikmati pengalaman ngopi terbaik dari gerobakan kami.</p>
        </div>
        <div class="col-lg-6">
            <form action="{{ url('/menu') }}" method="GET" class="d-flex gap-2">
                @if ($kategoriAktif !== 'semua')
                    <input type="hidden" name="kategori" value="{{ $kategoriAktif }}">
                @endif
                <div class="input-group">
                    <span class="input-group-text kg-card border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="cari" value="{{ request('cari') }}"
                           class="form-control kg-search-input border-start-0 ps-0"
                           placeholder="Cari menu kopi favoritmu...">
                </div>
            </form>
        </div>
    </div>

    <div class="row gy-4">

        <!-- Kolom Menu -->
        <div class="col-lg-9">

            <!-- Filter Kategori -->
            <div class="d-flex gap-2 flex-wrap mb-4">
                @foreach ($kategoriList as $kat)
                    <a href="{{ url('/menu') }}?kategori={{ $kat['id'] }}"
                       class="btn btn-sm rounded-pill px-3 py-2 fw-semibold {{ $kategoriAktif === $kat['id'] ? 'btn-kg-accent' : 'btn-outline-secondary' }}">
                        {{ $kat['label'] }}
                    </a>
                @endforeach
            </div>

            <!-- Grid Menu -->
            <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3">
                @forelse ($menusFiltered as $item)
                    <div class="col">
                        <div class="card kg-card rounded-4 h-100 position-relative">

                            @if ($item['tag'])
                                <span class="badge kg-card border position-absolute top-0 start-0 m-3 fw-semibold"
                                      style="color: var(--kg-accent); z-index: 2;">
                                    {{ $item['tag'] }}
                                </span>
                            @endif

                            <button type="button"
                                    class="btn btn-sm kg-card border rounded-circle position-absolute top-0 end-0 m-3 d-flex align-items-center justify-content-center"
                                    style="width: 32px; height: 32px; z-index: 2;"
                                    aria-label="Tambahkan ke favorit">
                                <i class="bi bi-heart"></i>
                            </button>

                            <img src="https://placehold.co/300x220/{{ $imgBg }}/{{ $imgAccent }}?text={{ $item['gambar'] }}"
                                 class="card-img-top rounded-top-4" style="aspect-ratio: 4/3; object-fit: cover;"
                                 alt="{{ $item['nama'] }}">

                            <div class="card-body d-flex flex-column">
                                <h3 class="h6 fw-bold mb-1">{{ $item['nama'] }}</h3>
                                <p class="small text-muted mb-3 flex-grow-1">{{ $item['deskripsi'] }}</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="fw-bold">Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
                                    <form action="{{ url('/keranjang/tambah') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $item['id'] }}">
                                        <button type="submit" class="btn btn-kg-accent btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-cup-straw fs-1 d-block mb-2"></i>
                            Menu untuk kategori ini belum tersedia.
                        </div>
                    </div>
                @endforelse
            </div>

            @if (count($menusFiltered) > 0)
                <div class="text-center mt-4">
                    <button type="button" class="btn btn-outline-secondary rounded-3 px-4 py-2">
                        Muat Lebih Banyak <i class="bi bi-chevron-down"></i>
                    </button>
                </div>
            @endif
        </div>

        <!-- Pesanan Kamu -->
        <div class="col-lg-3">
            <div class="card kg-card rounded-4 position-sticky" style="top: 90px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="h5 fw-bold mb-0">Pesanan Kamu</h2>
                        <span class="badge btn-kg-accent rounded-pill">{{ count($cartItems) }}</span>
                    </div>

                    @forelse ($cartItems as $item)
                        <div class="d-flex gap-2 mb-3">
                            <img src="https://placehold.co/60x60/{{ $imgBg }}/{{ $imgAccent }}?text={{ $item['gambar'] }}"
                                 class="rounded-3" style="width: 52px; height: 52px; object-fit: cover;" alt="{{ $item['nama'] }}">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="small fw-semibold">{{ $item['nama'] }}</div>
                                    <button class="btn btn-sm btn-link text-danger p-0"><i class="bi bi-trash"></i></button>
                                </div>
                                @if ($item['catatan'])
                                    <small class="text-muted d-block mb-1">{{ $item['catatan'] }}</small>
                                @endif
                                <div class="d-flex align-items-center justify-content-between {{ $item['catatan'] ? '' : 'mt-1' }}">
                                    <span class="small fw-semibold">Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
                                    <div class="input-group input-group-sm" style="width: 90px;">
                                        <button class="btn btn-outline-secondary btn-sm" type="button"><i class="bi bi-dash"></i></button>
                                        <input type="text" class="form-control text-center kg-search-input p-0" value="{{ $item['qty'] }}" readonly>
                                        <button class="btn btn-outline-secondary btn-sm" type="button"><i class="bi bi-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="small text-muted text-center py-4 mb-0">
                            Keranjang kamu masih kosong.<br>Yuk pilih menu favoritmu ☕
                        </p>
                    @endforelse

                    @if (count($cartItems) > 0)
                        <hr style="border-color: var(--kg-border);">

                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="small text-muted">Subtotal</span>
                            <span class="small">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="small text-muted">Ongkir</span>
                            <span class="small">Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                        </div>

                        <hr style="border-color: var(--kg-border);">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold fs-5" style="color: var(--kg-accent);">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <a href="{{ url('/checkout') }}" class="btn btn-kg-accent w-100 rounded-3 py-2 fw-semibold mb-3">
                            Lanjut ke Pembayaran <i class="bi bi-arrow-right"></i>
                        </a>
                    @endif

                    <div class="alert alert-light border kg-card rounded-3 d-flex gap-2 mb-0 py-2 px-3">
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
</div>

@endsection