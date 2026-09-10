@extends('layouts.app')

@section('title', 'Katalog Menu Kopi & Minuman - Aruna Coffee House')

@section('content')

<div class="container-fluid px-3 px-lg-4 py-3">

    <!-- Header & Category Filter Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <span class="badge rounded-pill px-3 py-1 mb-2 fw-bold" style="background: #382419; color: var(--kg-accent); border: 1px solid rgba(180, 123, 77, 0.3);">
                Pilihan Menu Kafe
            </span>
            <h1 class="h3 fw-extrabold text-white mb-1">
                Katalog Minuman & Camilan <i class="bi bi-cup-hot" style="color: var(--kg-accent);"></i>
            </h1>
            <p class="mb-0" style="color: #948b85;">Klik kartu menu untuk melihat halaman detail lengkap atau tekan tombol (+) untuk memesan cepat!</p>
        </div>

        <!-- Filter Reset or Search indicator -->
        @if(request('cari'))
            <div>
                <span class="text-muted small">Hasil pencarian: "<strong>{{ request('cari') }}</strong>"</span>
                <a href="{{ route('menu', ['kategori' => $kategoriAktif]) }}" class="btn btn-sm btn-kg-outline rounded-pill px-3 ms-2">Reset</a>
            </div>
        @endif
    </div>

    <!-- Category Filter Pills -->
    <div class="d-flex gap-2 flex-wrap mb-4 pb-1">
        @foreach ($kategoriList as $kat)
            <a href="{{ route('menu', ['kategori' => $kat['id'], 'cari' => request('cari')]) }}" 
               class="btn rounded-pill px-4 py-2 fw-semibold d-flex align-items-center gap-2 {{ $kategoriAktif === $kat['id'] ? 'btn-kg-accent shadow' : 'btn-kg-outline' }}">
                <i class="bi {{ $kat['icon'] }}"></i> {{ $kat['label'] }}
            </a>
        @endforeach
    </div>

    <!-- Products Grid -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">
        @forelse ($menusFiltered as $item)
            @php
                $imgPath = $item->gambar;
                if ($imgPath && (Str::startsWith($imgPath, 'http://') || Str::startsWith($imgPath, 'https://'))) {
                    $imgUrl = $imgPath;
                } elseif ($imgPath && Str::startsWith($imgPath, 'images/')) {
                    $imgUrl = asset($imgPath);
                } elseif ($imgPath) {
                    $imgUrl = asset('storage/' . $imgPath);
                } else {
                    $imgUrl = asset('images/products/kopi-susu-gula-aren.jpg');
                }
            @endphp

            <div class="col">
                <div class="card kg-card kg-card-hover rounded-4 h-100 position-relative overflow-hidden d-flex flex-column" 
                     style="background: #14100e; border: 1px solid rgba(255, 255, 255, 0.06);">

                    @if ($item->is_bestseller || $item->tag)
                        <span class="badge position-absolute top-0 start-0 m-3 fw-semibold rounded-pill shadow px-2 py-1" style="background: var(--kg-accent-gradient); color: #fff; font-size: 0.65rem; z-index: 2;">
                            <i class="bi bi-star-fill me-1"></i> {{ $item->is_bestseller ? 'Populer' : $item->tag }}
                        </span>
                    @endif

                    <!-- Klik kartu membuka halaman detail seperti Shopee -->
                    <a href="{{ route('menu.show', $item->id) }}" class="text-decoration-none d-block">
                        <div class="overflow-hidden" style="background: #0d0a08;">
                            <img src="{{ $imgUrl }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $item->nama }}">
                        </div>
                    </a>

                    <div class="card-body d-flex flex-column justify-content-between p-3 flex-grow-1">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="badge rounded-pill text-uppercase fw-semibold" style="background: #241913; color: var(--kg-accent); font-size: 0.65rem; border: 1px solid rgba(180, 123, 77, 0.2);">{{ $item->kategori }}</span>
                                <small class="{{ $item->stok > 0 ? ($item->stok <= 5 ? 'text-warning' : 'text-success') : 'text-danger' }} fw-semibold" style="font-size: 0.72rem;">
                                    @if($item->stok > 0)
                                        <i class="bi bi-check2-circle"></i> Stok: {{ $item->stok }}
                                    @else
                                        <i class="bi bi-x-circle"></i> Stok Habis
                                    @endif
                                </small>
                            </div>

                            <a href="{{ route('menu.show', $item->id) }}" class="text-decoration-none d-block">
                                <h3 class="h6 fw-bold text-white mb-1 text-truncate">{{ $item->nama }}</h3>
                                <p class="small mb-3" style="color: #948b85; line-height: 1.35; min-height: 36px;">{{ Str::limit($item->deskripsi, 55) }}</p>
                            </a>
                        </div>

                        <!-- Bagian Bawah: Harga & Tombol Pesan Langsung Membuka Pilihan Varian -->
                        <div class="d-flex align-items-center justify-content-between pt-2 mt-1" style="border-top: 1px solid rgba(255, 255, 255, 0.06);">
                            <div>
                                <small class="d-block" style="color: #756c66; font-size: 0.68rem;">Harga</small>
                                <span class="fw-bold text-white" style="font-size: 0.95rem;">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                            </div>

                            @if($item->stok > 0)
                                <button type="button" class="rounded-circle d-flex align-items-center justify-content-center border-0 text-white" 
                                        style="width: 32px; height: 32px; background: #2a1d17; transition: all 0.2s;" 
                                        data-bs-toggle="modal" data-bs-target="#menuQuickOrderModal{{ $item->id }}" 
                                        title="Pesan & Kustomisasi Varian">
                                    <i class="bi bi-plus fs-5"></i>
                                </button>
                            @else
                                <span class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 0.65rem;">Habis</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <!-- Quick Order Modal (Muncul saat user menekan tombol plus di menu) -->
            <div class="modal fade" id="menuQuickOrderModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content kg-card text-white rounded-4 border overflow-hidden" style="border-color: rgba(255, 255, 255, 0.1);">
                        <form action="{{ route('cart.add') }}" method="POST" id="menuQuickForm{{ $item->id }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->id }}">
                            
                            <div class="modal-header border-bottom p-3 px-4" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge rounded-pill text-uppercase px-2 py-1" style="background: #382419; color: var(--kg-accent); font-size: 0.68rem; border: 1px solid rgba(180, 123, 77, 0.3);">{{ $item->kategori }}</span>
                                    <h5 class="modal-title fw-bold text-white mb-0">{{ $item->nama }}</h5>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body p-4">
                                <div class="row g-4">
                                    
                                    <!-- Image & Real-time Price Box -->
                                    <div class="col-md-5 text-center">
                                         <div class="rounded-4 overflow-hidden mb-3 border shadow" style="border-color: rgba(255, 255, 255, 0.08); background: #0d0a08;">
                                             <img src="{{ $imgUrl }}" class="w-100" style="height: 200px; object-fit: cover;" alt="{{ $item->nama }}">
                                         </div>

                                         <div class="p-3 rounded-3 text-start mb-2" style="background-color: #1a1410; border: 1px solid rgba(255, 255, 255, 0.06);">
                                             <div class="d-flex justify-content-between align-items-center mb-1">
                                                 <span style="color: #948b85;" class="small">Harga Satuan:</span>
                                                 <span class="fw-bold" style="color: var(--kg-accent);" id="m_unitPrice{{ $item->id }}">
                                                     Rp {{ number_format($item->harga, 0, ',', '.') }}
                                                 </span>
                                             </div>
                                             <div class="d-flex justify-content-between align-items-center pt-1 border-top" style="border-color: rgba(255, 255, 255, 0.06) !important;">
                                                 <span class="text-white small fw-bold">Total Harga:</span>
                                                 <span class="fs-5 fw-extrabold text-white" id="m_totalPrice{{ $item->id }}">
                                                     Rp {{ number_format($item->harga, 0, ',', '.') }}
                                                 </span>
                                             </div>
                                         </div>

                                         <small class="d-block {{ $item->stok > 0 ? 'text-success' : 'text-danger' }} fw-semibold">
                                             <i class="bi bi-box-seam me-1"></i> Sisa Stok: {{ $item->stok }} pcs
                                         </small>
                                     </div>

                                    <!-- Category-Specific Customizations -->
                                    <div class="col-md-7">
                                        <p class="small mb-3" style="color: #b5aba4; line-height: 1.5;">
                                            {{ $item->deskripsi }}
                                        </p>

                                        @php
                                            $isCoffee = in_array(strtolower($item->kategori), ['kopi', 'signature', 'espresso']);
                                            $isSnack = in_array(strtolower($item->kategori), ['snack', 'makanan', 'pastry']);
                                            $isNonCoffee = in_array(strtolower($item->kategori), ['non-kopi', 'tea', 'matcha', 'chocolate']);
                                        @endphp

                                        @if($isCoffee)
                                            <!-- Pilihan Khusus Minuman Kopi -->
                                            <div class="mb-3">
                                                <label class="form-label text-white small fw-bold"><i class="bi bi-thermometer-half text-warning me-1"></i> 1. Suhu Penyajian</label>
                                                <div class="d-flex gap-2">
                                                    <input type="radio" class="btn-check" name="suhu" id="m_suhuIce{{ $item->id }}" value="Es" checked onchange="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="m_suhuIce{{ $item->id }}">
                                                        <i class="bi bi-snow me-1 text-info"></i> Dingin
                                                    </label>
                                                    <input type="radio" class="btn-check" name="suhu" id="m_suhuHot{{ $item->id }}" value="Panas" onchange="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="m_suhuHot{{ $item->id }}">
                                                        <i class="bi bi-fire me-1 text-danger"></i> Hangat
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label text-white small fw-bold"><i class="bi bi-droplet-half text-warning me-1"></i> 2. Takaran Gula</label>
                                                <div class="row g-2">
                                                    <div class="col-4">
                                                        <input type="radio" class="btn-check" name="manis" id="m_manisNorm{{ $item->id }}" value="Gula Normal" checked onchange="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                        <label class="btn btn-kg-outline w-100 rounded-3 py-1 small text-nowrap" for="m_manisNorm{{ $item->id }}">Normal</label>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="radio" class="btn-check" name="manis" id="m_manisLess{{ $item->id }}" value="Sedikit Gula" onchange="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                        <label class="btn btn-kg-outline w-100 rounded-3 py-1 small text-nowrap" for="m_manisLess{{ $item->id }}">Sedikit Gula</label>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="radio" class="btn-check" name="manis" id="m_manisNo{{ $item->id }}" value="Non Gula" onchange="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                        <label class="btn btn-kg-outline w-100 rounded-3 py-1 small text-nowrap" for="m_manisNo{{ $item->id }}">Non Gula</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Ukuran Cup dengan Tambahan Harga Otomatis -->
                                            <div class="mb-3">
                                                <label class="form-label text-white small fw-bold"><i class="bi bi-cup text-warning me-1"></i> 3. Ukuran Cup</label>
                                                <div class="d-flex gap-2">
                                                    <input type="radio" class="btn-check" name="ukuran" id="m_sizeReg{{ $item->id }}" value="Reguler" data-price-extra="0" checked onchange="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="m_sizeReg{{ $item->id }}">Reguler</label>
                                                    <input type="radio" class="btn-check" name="ukuran" id="m_sizeLrg{{ $item->id }}" value="Large" data-price-extra="3000" onchange="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="m_sizeLrg{{ $item->id }}">Large (+3rb)</label>
                                                </div>
                                            </div>

                                        @elseif($isSnack)
                                            <!-- Pilihan Khusus Makanan / Camilan -->
                                            <div class="mb-3">
                                                <label class="form-label text-white small fw-bold"><i class="bi bi-fire text-warning me-1"></i> 1. Cara Penyajian</label>
                                                <div class="d-flex gap-2">
                                                    <input type="radio" class="btn-check" name="suhu" id="m_snackWarm{{ $item->id }}" value="Dipanaskan (Toasted)" checked onchange="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="m_snackWarm{{ $item->id }}">
                                                        <i class="bi bi-fire me-1 text-warning"></i> Dipanaskan
                                                    </label>
                                                    <input type="radio" class="btn-check" name="suhu" id="m_snackNorm{{ $item->id }}" value="Suhu Ruang" onchange="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="m_snackNorm{{ $item->id }}">
                                                        Suhu Ruang
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label text-white small fw-bold"><i class="bi bi-plus-circle text-warning me-1"></i> 2. Pilihan Topping</label>
                                                <div class="d-flex gap-2">
                                                    <input type="radio" class="btn-check" name="tambahan" id="m_topOrig{{ $item->id }}" value="Original" data-price-extra="0" checked onchange="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="m_topOrig{{ $item->id }}">Original</label>
                                                    <input type="radio" class="btn-check" name="tambahan" id="m_topExtra{{ $item->id }}" value="Ekstra Keju/Topping" data-price-extra="4000" onchange="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="m_topExtra{{ $item->id }}">Ekstra Keju (+4rb)</label>
                                                </div>
                                            </div>

                                        @else
                                            <!-- Pilihan Khusus Non-Kopi -->
                                            <div class="mb-3">
                                                <label class="form-label text-white small fw-bold"><i class="bi bi-thermometer-half text-warning me-1"></i> 1. Suhu Minuman</label>
                                                <div class="d-flex gap-2">
                                                    <input type="radio" class="btn-check" name="suhu" id="m_nkIce{{ $item->id }}" value="Es" checked onchange="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="m_nkIce{{ $item->id }}">
                                                        <i class="bi bi-snow me-1 text-info"></i> Dingin
                                                    </label>
                                                    <input type="radio" class="btn-check" name="suhu" id="m_nkHot{{ $item->id }}" value="Panas" onchange="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                    <label class="btn btn-kg-outline rounded-3 flex-grow-1 py-1 small" for="m_nkHot{{ $item->id }}">
                                                        <i class="bi bi-fire me-1 text-danger"></i> Hangat
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label text-white small fw-bold"><i class="bi bi-droplet-half text-warning me-1"></i> 2. Tingkat Manis</label>
                                                <div class="row g-2">
                                                    <div class="col-4">
                                                        <input type="radio" class="btn-check" name="manis" id="m_nkNorm{{ $item->id }}" value="Normal Sweet" checked onchange="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                        <label class="btn btn-kg-outline w-100 rounded-3 py-1 small text-nowrap" for="m_nkNorm{{ $item->id }}">Normal</label>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="radio" class="btn-check" name="manis" id="m_nkLess{{ $item->id }}" value="Less Sweet" onchange="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                        <label class="btn btn-kg-outline w-100 rounded-3 py-1 small text-nowrap" for="m_nkLess{{ $item->id }}">Sedikit Gula</label>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="radio" class="btn-check" name="manis" id="m_nkNo{{ $item->id }}" value="Non Gula" onchange="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                        <label class="btn btn-kg-outline w-100 rounded-3 py-1 small text-nowrap" for="m_nkNo{{ $item->id }}">Non Gula</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label text-white small fw-bold"><i class="bi bi-cup text-warning me-1"></i> 3. Pilihan Susu</label>
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <input type="radio" class="btn-check" name="tambahan" id="m_milkFresh{{ $item->id }}" value="Fresh Milk" data-price-extra="0" checked onchange="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                        <label class="btn btn-kg-outline w-100 rounded-3 py-1 small" for="m_milkFresh{{ $item->id }}">Fresh Milk</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="radio" class="btn-check" name="tambahan" id="m_milkOat{{ $item->id }}" value="Oat Milk" data-price-extra="4000" onchange="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})">
                                                        <label class="btn btn-kg-outline w-100 rounded-3 py-1 small" for="m_milkOat{{ $item->id }}">Oat Milk (+4rb)</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Catatan Khusus untuk Barista -->
                                        <div class="mb-3">
                                            <label class="form-label text-white small fw-bold"><i class="bi bi-chat-left-text text-warning me-1"></i> Catatan untuk Barista (Opsional)</label>
                                            <input type="text" name="catatan" class="form-control form-control-sm kg-search-input rounded-3 py-2" placeholder="Contoh: sedikit es batu, seduh kental">
                                        </div>

                                        <!-- Jumlah Pcs dengan Real-time Recalculation -->
                                        <div class="d-flex align-items-center justify-content-between pt-2 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                                            <span class="fw-bold text-white small">Jumlah Pesanan:</span>
                                            <div class="d-flex align-items-center gap-2">
                                                <button type="button" class="btn btn-kg-outline btn-sm rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 28px; height: 28px;" onclick="let input = document.getElementById('m_qty{{ $item->id }}'); if(input.value > 1) { input.value--; calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }}); }">-</button>
                                                <input type="number" id="m_qty{{ $item->id }}" name="jumlah" class="form-control form-control-sm kg-search-input text-center rounded-3 fw-bold" style="width: 60px;" value="1" min="1" max="{{ $item->stok }}" oninput="calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }})" required>
                                                <button type="button" class="btn btn-kg-outline btn-sm rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 28px; height: 28px;" onclick="let input = document.getElementById('m_qty{{ $item->id }}'); if(input.value < {{ $item->stok }}) { input.value++; calcMenuQuickPrice({{ $item->id }}, {{ (int)$item->harga }}); }">+</button>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer border-top p-3 px-4 d-flex justify-content-between" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                                <a href="{{ route('menu.show', $item->id) }}" class="btn btn-kg-outline rounded-pill px-3 py-2 small">
                                    <i class="bi bi-eye me-1"></i> Buka Halaman Detail
                                </a>
                                
                                <div class="d-flex gap-2">
                                    <button type="submit" name="action_type" value="add_cart" class="btn btn-kg-outline rounded-pill px-3 py-2 fw-semibold">
                                        <i class="bi bi-bag-plus me-1" style="color: var(--kg-accent);"></i> + Masukkan Keranjang
                                    </button>
                                    <button type="submit" name="action_type" value="buy_now" class="btn btn-kg-accent rounded-pill px-4 py-2 fw-semibold shadow">
                                        <i class="bi bi-lightning-charge-fill me-1"></i> Pesan Langsung
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="bi bi-search display-5 d-block mb-3 opacity-50"></i>
                <h3 class="h5 fw-bold text-white mb-1">Menu Tidak Ditemukan</h3>
                <p class="small">Coba ubah kata kunci pencarian atau pilih kategori menu lainnya.</p>
                <a href="{{ route('menu') }}" class="btn btn-kg-accent rounded-pill px-4 py-2 mt-2">Lihat Semua Menu</a>
            </div>
        @endforelse
    </div>

</div>

@push('scripts')
<script>
    function calcMenuQuickPrice(productId, basePrice) {
        const form = document.getElementById('menuQuickForm' + productId);
        if (!form) return;

        let currentUnitPrice = basePrice;

        // Cek radio ukuran cup atau tambahan yang memiliki data-price-extra
        const checkedRadios = form.querySelectorAll('input[type="radio"]:checked');
        checkedRadios.forEach(radio => {
            const extra = parseInt(radio.getAttribute('data-price-extra') || 0);
            currentUnitPrice += extra;
        });

        // Ambil Qty
        const qtyInput = document.getElementById('m_qty' + productId);
        let qty = parseInt(qtyInput ? qtyInput.value : 1) || 1;
        if (qty < 1) qty = 1;

        const grandTotal = currentUnitPrice * qty;

        // Update UI Real-Time
        const unitEl = document.getElementById('m_unitPrice' + productId);
        const totalEl = document.getElementById('m_totalPrice' + productId);

        if (unitEl) unitEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(currentUnitPrice);
        if (totalEl) totalEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(grandTotal);
    }
</script>
@endpush

@endsection