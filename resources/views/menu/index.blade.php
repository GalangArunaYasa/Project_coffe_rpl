@extends('layouts.app')

@section('title', 'Menu Pesan - Kopi Gerobakan')

@section('content')

<div class="container-fluid py-4">

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
                    <input type="text" name="cari" value="{{ request('cari') }}" class="form-control kg-search-input border-start-0 ps-0" placeholder="Cari menu kopi favoritmu...">
                </div>
            </form>
        </div>
    </div>

    <div class="row gy-4">
        <div class="col-lg-12">

            <div class="d-flex gap-2 flex-wrap mb-4">
                @foreach ($kategoriList as $kat)
                    <a href="{{ url('/menu') }}?kategori={{ $kat['id'] }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold {{ $kategoriAktif === $kat['id'] ? 'btn-kg-accent' : 'btn-outline-secondary' }}">
                        {{ $kat['label'] }}
                    </a>
                @endforeach
            </div>

            <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3">
                @forelse ($menusFiltered as $item)
                    <div class="col">
                        <div class="card kg-card rounded-4 h-100 position-relative">

                            @if ($item->is_bestseller || $item->tag)
                                <span class="badge kg-card border position-absolute top-0 start-0 m-3 fw-semibold" style="color: var(--kg-accent); z-index: 2;">
                                    {{ $item->is_bestseller ? '★ Best Seller' : $item->tag }}
                                </span>
                            @endif

                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top rounded-top-4" style="aspect-ratio: 4/3; object-fit: cover;" alt="{{ $item->nama }}">
                            @else
                                <img src="https://placehold.co/300x220/f5efe6/a8632f?text={{ urlencode($item->nama) }}" class="card-img-top rounded-top-4" style="aspect-ratio: 4/3; object-fit: cover;" alt="{{ $item->nama }}">
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h3 class="h6 fw-bold mb-1">{{ $item->nama }}</h3>
                                <p class="small text-muted mb-2 flex-grow-1">{{ $item->deskripsi }}</p>
                                <div class="mb-2"><small class="text-secondary">Stok: <strong>{{ $item->stok }}</strong></small></div>
                                
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="fw-bold">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                    
                                    @if($item->stok > 0)
                                        <form action="{{ url('/keranjang/tambah') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="menu_id" value="{{ $item->id }}">
                                            <button type="submit" class="btn btn-kg-accent btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge bg-danger">Habis</span>
                                    @endif
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

        </div>
    </div>
</div>

@endsection