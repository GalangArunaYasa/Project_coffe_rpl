@extends('layouts.app')

@section('title', $product->nama ?? 'Detail Produk')

@section('content')

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<div class="container py-4 py-lg-5">

    {{-- BREADCRUMB --}}
    <div class="d-flex align-items-center gap-3 mb-4" data-aos="fade-down" data-aos-duration="600">
        <a href="{{ url('/menu') }}"
           class="btn btn-light border rounded-3 d-flex align-items-center justify-content-center"
           style="width:42px;height:42px;">
            <i class="bi bi-arrow-left"></i>
        </a>

        <div>
            <div class="small text-muted mb-1">Menu</div>
            <div class="fw-semibold">Detail Produk</div>
        </div>
    </div>


    <div class="row g-4 g-lg-5 align-items-start">

        {{-- PRODUCT IMAGE --}}
        <div class="col-lg-6" data-aos="fade-right" data-aos-duration="700">

            <div class="ratio ratio-1x1 rounded-4 overflow-hidden bg-light">

                @if(!empty($product->gambar))
                    <img
                        src="{{ asset('storage/' . $product->gambar) }}"
                        alt="{{ $product->nama }}"
                        class="w-100 h-100 object-fit-cover"
                        style="transition: transform .5s ease;"
                        onmouseover="this.style.transform='scale(1.03)'"
                        onmouseout="this.style.transform='scale(1)'"
                    >
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted gap-2">
                        <i class="bi bi-image fs-1"></i>
                        <span>Gambar belum tersedia</span>
                    </div>
                @endif

            </div>

        </div>


        {{-- PRODUCT INFO --}}
        <div class="col-lg-6" data-aos="fade-left" data-aos-duration="700" data-aos-delay="150">

            <div class="mx-auto" style="max-width: 580px;">

                {{-- KATEGORI --}}
                @if(!empty($product->kategori))
                    <span class="badge rounded-pill mb-3 px-3 py-2 text-capitalize"
                          style="background:#f4eee9; color:var(--brand-primary); font-weight:600; font-size:12px;">
                        {{ str_replace('-', ' ', $product->kategori) }}
                    </span>
                @endif

                {{-- BEST SELLER BADGE --}}
                @if($product->is_bestseller)
                    <span class="badge rounded-pill mb-3 ms-1 px-3 py-2"
                          style="background:#fff3cd; color:#8a6d00; font-weight:600; font-size:12px;">
                        <i class="bi bi-star-fill"></i> Best Seller
                    </span>
                @endif


                {{-- NAMA --}}
                <h1 class="fw-bold mb-3" style="font-size: clamp(28px, 4vw, 42px); letter-spacing: -.7px;">
                    {{ $product->nama }}
                </h1>


                {{-- HARGA --}}
                <div class="fw-bold mb-2" style="font-size: 27px; color: var(--brand-primary);">
                    Rp {{ number_format($product->harga ?? 0, 0, ',', '.') }}
                </div>

                {{-- STOK --}}
                <div class="mb-4">
                    @if($product->stok > 0)
                        <span class="text-success small fw-semibold">
                            <i class="bi bi-check-circle-fill"></i> Stok tersedia ({{ $product->stok }})
                        </span>
                    @else
                        <span class="text-danger small fw-semibold">
                            <i class="bi bi-x-circle-fill"></i> Stok habis
                        </span>
                    @endif
                </div>


                {{-- DESKRIPSI --}}
                <div class="pb-4 mb-4 border-bottom">
                    <h6 class="fw-bold mb-2">Deskripsi</h6>
                    <p class="text-muted mb-0" style="line-height: 1.7;">
                        {{ $product->deskripsi ?? 'Belum ada deskripsi untuk produk ini.' }}
                    </p>
                </div>


                {{-- TAG --}}
                @if(!empty($product->tag))
                    <div class="mb-4 d-flex flex-wrap gap-2">
                        @foreach(explode(',', $product->tag) as $t)
                            <span class="badge bg-light text-dark border">{{ trim($t) }}</span>
                        @endforeach
                    </div>
                @endif


                <form action="{{ url('/cart/add') }}" method="POST">
                    @csrf

                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    {{-- QUANTITY --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold small">Jumlah</label>

                        <div class="input-group" style="width: 140px;">
                            <button type="button" class="btn btn-outline-secondary" onclick="decreaseQty()">
                                <i class="bi bi-dash"></i>
                            </button>

                            <input
                                type="number"
                                name="quantity"
                                id="quantity"
                                value="1"
                                min="1"
                                max="{{ $product->stok }}"
                                class="form-control text-center fw-semibold"
                            >

                            <button type="button" class="btn btn-outline-secondary" onclick="increaseQty()">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>


                    {{-- NOTE --}}
                    <div class="mb-4">
                        <label for="note" class="form-label fw-bold small">
                            Catatan <span class="text-muted fw-normal">(Opsional)</span>
                        </label>

                        <textarea
                            name="note"
                            id="note"
                            rows="3"
                            maxlength="200"
                            class="form-control"
                            placeholder="Contoh: Tolong siapkan dengan baik..."
                        ></textarea>

                        <div class="text-end mt-1">
                            <small class="text-muted">Maksimal 200 karakter</small>
                        </div>
                    </div>


                    {{-- ACTION --}}
                    <div class="d-grid mt-4">
                        <button type="submit"
                                class="btn btn-lg d-flex align-items-center justify-content-center gap-2 btn-cart-hover"
                                style="background: var(--brand-primary); color:#fff; font-weight:700; border-radius:13px; min-height:52px;"
                                {{ $product->stok <= 0 ? 'disabled' : '' }}>
                            <i class="bi bi-cart-plus"></i>
                            <span>Tambah ke Keranjang</span>
                        </button>
                    </div>

                </form>


                {{-- INFORMATION --}}
                <div class="mt-4 pt-4 border-top" data-aos="fade-up" data-aos-delay="200">

                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                             style="width:38px;height:38px;background:#f7f4f1;color:var(--brand-primary);">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <strong class="d-block small">Pembayaran Aman</strong>
                            <small class="text-muted">Pembayaran akan diproses melalui sistem yang tersedia.</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                             style="width:38px;height:38px;background:#f7f4f1;color:var(--brand-primary);">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div>
                            <strong class="d-block small">Produk Terjaga</strong>
                            <small class="text-muted">Produk diperiksa sebelum diserahkan kepada pelanggan.</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                             style="width:38px;height:38px;background:#f7f4f1;color:var(--brand-primary);">
                            <i class="bi bi-headset"></i>
                        </div>
                        <div>
                            <strong class="d-block small">Bantuan</strong>
                            <small class="text-muted">Hubungi admin jika mengalami masalah dengan pesanan.</small>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<style>
    :root {
        --brand-primary: #6f4e37;
        --brand-primary-dark: #553827;
    }

    .btn-cart-hover:hover {
        background: var(--brand-primary-dark) !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(111, 78, 55, .18);
    }
</style>


<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ once: true, offset: 80 });

    function increaseQty() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.getAttribute('max')) || Infinity;
        let value = parseInt(input.value) || 1;
        if (value < max) input.value = value + 1;
    }

    function decreaseQty() {
        const input = document.getElementById('quantity');
        let value = parseInt(input.value) || 1;
        if (value > 1) input.value = value - 1;
    }
</script>

@endsection