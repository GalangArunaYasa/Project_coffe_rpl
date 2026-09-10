@extends('layouts.penjual')

@section('title', 'Point of Sale (Kasir) - Aruna Coffee')

@section('content')

<div class="row g-3">

    <!-- Left Side: POS Product Catalog -->
    <div class="col-lg-7 col-xl-8">
        <div class="pos-card p-3 p-md-4 shadow-sm h-100">
            
            <!-- Category Pills & Filter -->
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div class="d-flex gap-2 flex-wrap">
                    @foreach($kategoriList as $kat)
                        <a href="{{ route('penjual.pos.index', ['kategori' => $kat['id']]) }}" 
                           class="btn btn-sm rounded-pill px-3 py-1 fw-bold {{ $kategori === $kat['id'] ? 'btn-kg-accent text-white' : 'btn-kg-outline' }}">
                            {{ $kat['label'] }}
                        </a>
                    @endforeach
                </div>

                <div style="min-width: 200px;">
                    <form action="{{ route('penjual.pos.index') }}" method="GET">
                        @if($kategori !== 'semua')
                            <input type="hidden" name="kategori" value="{{ $kategori }}">
                        @endif
                        <input type="text" name="cari" value="{{ $cari }}" class="form-control form-control-sm kg-search-input rounded-pill" placeholder="Cari menu...">
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3 overflow-auto" style="max-height: calc(100vh - 200px);">
                @forelse($products as $p)
                    <div class="col">
                        <div class="card pos-card h-100 p-2 position-relative text-center {{ $p->stok <= 0 ? 'opacity-50' : '' }}" 
                             style="cursor: {{ $p->stok > 0 ? 'pointer' : 'not-allowed' }}; transition: transform 0.2s;" 
                             onclick="{{ $p->stok > 0 ? "addToPosCart({$p->id}, '" . addslashes($p->nama) . "', {$p->harga}, {$p->stok})" : '' }}">
                            
                            <span class="badge {{ $p->stok > 0 ? ($p->stok <= 5 ? 'bg-warning text-dark' : 'bg-success') : 'bg-danger' }} position-absolute top-0 start-0 m-2 rounded-pill fw-bold" style="font-size: 0.65rem;">
                                Stok: {{ $p->stok }}
                            </span>

                            @if($p->gambar)
                                <img src="{{ asset('storage/' . $p->gambar) }}" class="rounded-3 mx-auto mt-2" style="width: 100%; height: 90px; object-fit: cover;" alt="{{ $p->nama }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1541167760496-1628856ab772?w=200&auto=format&fit=crop&q=80" class="rounded-3 mx-auto mt-2" style="width: 100%; height: 90px; object-fit: cover;" alt="{{ $p->nama }}">
                            @endif

                            <div class="card-body p-2 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="fw-bold text-white small text-truncate" title="{{ $p->nama }}">{{ $p->nama }}</div>
                                    <small class="text-muted text-uppercase" style="font-size: 0.65rem;">{{ $p->kategori }}</small>
                                </div>
                                <div class="fw-extrabold text-warning small mt-1">
                                    Rp {{ number_format($p->harga, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 py-5 text-center text-muted">
                        Menu tidak ditemukan.
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <!-- Right Side: POS Active Bill / Cart -->
    <div class="col-lg-5 col-xl-4">
        <div class="pos-card p-3 p-md-4 shadow-sm d-flex flex-column" style="min-height: calc(100vh - 120px);">
            
            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2" style="border-color: var(--kg-border) !important;">
                <h2 class="h5 fw-bold text-white mb-0">
                    <i class="bi bi-cart3 text-warning me-1"></i> Bill Kasir Langsung
                </h2>
                <button type="button" onclick="clearPosCart()" class="btn btn-outline-danger btn-sm rounded-pill px-2 py-0" style="font-size: 0.75rem;">
                    Reset
                </button>
            </div>

            <!-- Customer Name & Notes -->
            <div class="mb-3">
                <label class="form-label text-white small fw-bold mb-1">Nama Pelanggan / No. Meja</label>
                <input type="text" id="posCustomerName" class="form-control form-control-sm kg-search-input rounded-3 py-2" value="Pelanggan Langsung (Walk-in)">
            </div>

            <!-- Items List -->
            <div class="flex-grow-1 overflow-auto pe-1 mb-3" id="posCartItemsContainer" style="max-height: 240px;">
                <div class="text-center py-4 text-muted small" id="posEmptyState">
                    <i class="bi bi-cart-x fs-1 d-block mb-1 text-secondary"></i>
                    Belum ada menu yang dipilih.<br>Klik produk di sebelah kiri untuk menambah ke bill kasir.
                </div>
                <!-- Dynamic Items will be rendered here via JS -->
            </div>

            <!-- Bill Totals -->
            <div class="border-top pt-2 mb-3" style="border-color: var(--kg-border) !important;">
                <div class="d-flex justify-content-between small text-muted mb-1">
                    <span>Total Item:</span>
                    <span id="posTotalQty" class="text-white fw-bold">0 pcs</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-white fs-6">TOTAL TAGIHAN:</span>
                    <span class="fw-extrabold text-warning fs-4" id="posGrandTotal">Rp 0</span>
                </div>
            </div>

            <!-- Payment Methods & Cash Tendered -->
            <div class="mb-3">
                <label class="form-label text-white small fw-bold mb-1">Metode Pembayaran</label>
                <div class="d-flex gap-1 mb-2">
                    <input type="radio" class="btn-check" name="posPaymentMethod" id="posPayCash" value="cash" checked onchange="toggleCashInput(true)">
                    <label class="btn btn-kg-outline btn-sm flex-grow-1 rounded-3" for="posPayCash">
                        <i class="bi bi-cash me-1 text-warning"></i> Tunai
                    </label>

                    <input type="radio" class="btn-check" name="posPaymentMethod" id="posPayQris" value="qris" onchange="toggleCashInput(false)">
                    <label class="btn btn-kg-outline btn-sm flex-grow-1 rounded-3" for="posPayQris">
                        <i class="bi bi-qr-code me-1 text-info"></i> QRIS
                    </label>

                    <input type="radio" class="btn-check" name="posPaymentMethod" id="posPayTf" value="transfer" onchange="toggleCashInput(false)">
                    <label class="btn btn-kg-outline btn-sm flex-grow-1 rounded-3" for="posPayTf">
                        <i class="bi bi-bank me-1 text-success"></i> Transfer
                    </label>
                </div>

                <!-- Cash input & Kembalian -->
                <div id="posCashSection">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label text-muted small mb-0" style="font-size: 0.7rem;">Uang Diterima (Rp)</label>
                            <input type="number" id="posUangDiterima" oninput="calculateChange()" class="form-control form-control-sm kg-search-input rounded-3 py-1" placeholder="0">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small mb-0" style="font-size: 0.7rem;">Uang Kembalian</label>
                            <div class="fw-bold text-success fs-6 pt-1" id="posUangKembalian">Rp 0</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="button" onclick="submitPosOrder()" id="btnSubmitPos" class="btn btn-kg-accent w-100 rounded-pill py-3 fw-bold fs-6 shadow d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-check2-circle fs-5"></i> Selesaikan Transaksi (Bayar)
            </button>

        </div>
    </div>

</div>

<!-- Modal Struk Transaksi Selesai -->
<div class="modal fade" id="posReceiptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-white text-center">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-success">
                    <i class="bi bi-check-circle-fill me-2"></i> Transaksi Berhasil!
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="avatar-initial mx-auto mb-3 bg-success" style="width: 60px; height: 60px; font-size: 1.8rem;">
                    <i class="bi bi-receipt"></i>
                </div>
                <h4 class="fw-bold text-white mb-1" id="receiptOrderCode">ARU-XXXX</h4>
                <p class="text-muted small mb-3">Pesanan telah dicatat dan stok produk otomatis terpotong.</p>

                <div class="p-3 rounded-3 mb-3 text-start" style="background-color: var(--kg-surface-light);">
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-muted">Total Bayar:</span>
                        <span class="fw-bold text-white" id="receiptTotalBayar">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-muted">Uang Diterima:</span>
                        <span class="text-white" id="receiptUangDiterima">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between small fw-bold">
                        <span class="text-success">Kembalian:</span>
                        <span class="text-success" id="receiptKembalian">Rp 0</span>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="#" id="receiptPrintLink" target="_blank" class="btn btn-kg-accent flex-grow-1 rounded-pill py-2 fw-bold">
                        <i class="bi bi-printer me-1"></i> Cetak Struk
                    </a>
                    <button type="button" class="btn btn-kg-outline rounded-pill px-4" data-bs-dismiss="modal">
                        Transaksi Baru
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let posCart = [];

    function addToPosCart(productId, name, price, maxStock) {
        let existing = posCart.find(item => item.product_id === productId);
        if (existing) {
            if (existing.jumlah >= maxStock) {
                alert('Stok produk ' + name + ' tersisa ' + maxStock + ' pcs.');
                return;
            }
            existing.jumlah++;
        } else {
            posCart.push({
                product_id: productId,
                nama: name,
                harga: price,
                jumlah: 1,
                max_stock: maxStock,
                ukuran: 'Reguler',
                suhu: 'Es',
                manis: 'Normal',
                catatan: ''
            });
        }
        renderPosCart();
    }

    function updatePosItemQty(index, delta) {
        if (posCart[index]) {
            let newQty = posCart[index].jumlah + delta;
            if (newQty > posCart[index].max_stock) {
                alert('Stok maksimal hanya ' + posCart[index].max_stock + ' pcs.');
                return;
            }
            if (newQty <= 0) {
                posCart.splice(index, 1);
            } else {
                posCart[index].jumlah = newQty;
            }
            renderPosCart();
        }
    }

    function removePosItem(index) {
        posCart.splice(index, 1);
        renderPosCart();
    }

    function clearPosCart() {
        if (posCart.length === 0) return;
        if (confirm('Kosongkan bill kasir saat ini?')) {
            posCart = [];
            renderPosCart();
        }
    }

    function renderPosCart() {
        const container = document.getElementById('posCartItemsContainer');
        const emptyState = document.getElementById('posEmptyState');
        const totalQtyEl = document.getElementById('posTotalQty');
        const grandTotalEl = document.getElementById('posGrandTotal');

        if (posCart.length === 0) {
            container.innerHTML = `
                <div class="text-center py-4 text-muted small" id="posEmptyState">
                    <i class="bi bi-cart-x fs-1 d-block mb-1 text-secondary"></i>
                    Belum ada menu yang dipilih.<br>Klik produk di sebelah kiri untuk menambah ke bill kasir.
                </div>
            `;
            totalQtyEl.innerText = '0 pcs';
            grandTotalEl.innerText = 'Rp 0';
            calculateChange();
            return;
        }

        let totalQty = 0;
        let grandTotal = 0;
        let html = '';

        posCart.forEach((item, index) => {
            const subtotal = item.harga * item.jumlah;
            totalQty += item.jumlah;
            grandTotal += subtotal;

            html += `
                <div class="p-2 rounded-3 mb-2 border" style="background-color: var(--kg-surface-light); border-color: var(--kg-border) !important;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div class="fw-bold text-white small">${item.nama}</div>
                        <button type="button" onclick="removePosItem(${index})" class="btn-close btn-close-white" style="font-size: 0.6rem;"></button>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">Rp ${new Intl.NumberFormat('id-ID').format(item.harga)}</div>
                        <div class="d-flex align-items-center gap-1">
                            <button type="button" onclick="updatePosItemQty(${index}, -1)" class="btn btn-outline-secondary btn-sm py-0 px-2 rounded-circle text-light">-</button>
                            <span class="fw-bold text-white px-2 small">${item.jumlah}</span>
                            <button type="button" onclick="updatePosItemQty(${index}, 1)" class="btn btn-outline-secondary btn-sm py-0 px-2 rounded-circle text-light">+</button>
                        </div>
                        <div class="fw-bold text-warning small">
                            Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}
                        </div>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
        totalQtyEl.innerText = totalQty + ' pcs';
        grandTotalEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(grandTotal);
        calculateChange();
    }

    function toggleCashInput(isCash) {
        document.getElementById('posCashSection').style.display = isCash ? 'block' : 'none';
        calculateChange();
    }

    function calculateChange() {
        const payMethod = document.querySelector('input[name="posPaymentMethod"]:checked').value;
        const grandTotal = posCart.reduce((sum, item) => sum + (item.harga * item.jumlah), 0);
        const cashInput = parseFloat(document.getElementById('posUangDiterima').value) || 0;
        const kembalianEl = document.getElementById('posUangKembalian');

        if (payMethod !== 'cash') {
            kembalianEl.innerText = 'Rp 0 (Pas)';
            kembalianEl.className = 'fw-bold text-success fs-6 pt-1';
            return;
        }

        if (cashInput >= grandTotal && grandTotal > 0) {
            const change = cashInput - grandTotal;
            kembalianEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(change);
            kembalianEl.className = 'fw-bold text-success fs-6 pt-1';
        } else if (cashInput > 0 && cashInput < grandTotal) {
            const minus = grandTotal - cashInput;
            kembalianEl.innerText = 'Kurang Rp ' + new Intl.NumberFormat('id-ID').format(minus);
            kembalianEl.className = 'fw-bold text-danger fs-6 pt-1';
        } else {
            kembalianEl.innerText = 'Rp 0';
            kembalianEl.className = 'fw-bold text-muted fs-6 pt-1';
        }
    }

    async function submitPosOrder() {
        if (posCart.length === 0) {
            alert('Silakan pilih minimal 1 produk menu ke dalam bill kasir.');
            return;
        }

        const grandTotal = posCart.reduce((sum, item) => sum + (item.harga * item.jumlah), 0);
        const payMethod = document.querySelector('input[name="posPaymentMethod"]:checked').value;
        const cashTendered = parseFloat(document.getElementById('posUangDiterima').value) || 0;
        const customerName = document.getElementById('posCustomerName').value || 'Pelanggan Langsung (Walk-in)';

        if (payMethod === 'cash' && cashTendered < grandTotal) {
            alert('Uang tunai yang diterima (Rp ' + new Intl.NumberFormat('id-ID').format(cashTendered) + ') kurang dari total tagihan (Rp ' + new Intl.NumberFormat('id-ID').format(grandTotal) + ').');
            return;
        }

        const submitBtn = document.getElementById('btnSubmitPos');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses Pembayaran...';

        try {
            const response = await fetch("{{ route('penjual.pos.checkout') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    nama_pemesan: customerName,
                    metode_pembayaran: payMethod,
                    uang_diterima: payMethod === 'cash' ? cashTendered : grandTotal,
                    items: posCart
                })
            });

            const result = await response.json();

            if (result.success) {
                document.getElementById('receiptOrderCode').innerText = result.order_code;
                document.getElementById('receiptTotalBayar').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(result.total_bayar);
                document.getElementById('receiptUangDiterima').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(result.uang_diterima);
                document.getElementById('receiptKembalian').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(result.kembalian);
                document.getElementById('receiptPrintLink').href = result.receipt_url;

                const receiptModal = new bootstrap.Modal(document.getElementById('posReceiptModal'));
                receiptModal.show();

                posCart = [];
                document.getElementById('posUangDiterima').value = '';
                renderPosCart();
            } else {
                alert('Gagal memproses transaksi: ' + (result.message || 'Terjadi kesalahan sistem.'));
            }
        } catch (error) {
            console.error(error);
            alert('Terjadi kesalahan koneksi server.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-check2-circle fs-5"></i> Selesaikan Transaksi (Bayar)';
        }
    }
</script>
@endpush

@endsection
