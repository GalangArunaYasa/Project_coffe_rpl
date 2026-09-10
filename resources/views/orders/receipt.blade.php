<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan - {{ $order->order_code }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Courier New', Courier, monospace;
            color: #111827;
            padding: 20px;
        }

        .receipt-card {
            max-width: 380px;
            margin: 0 auto;
            background: #ffffff;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .dashed-line {
            border-top: 1px dashed #9ca3af;
            margin: 12px 0;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .receipt-card {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="text-center mb-3 no-print">
        <button onclick="window.print()" class="btn btn-warning rounded-pill px-4 shadow fw-bold">
            <i class="bi bi-printer-fill me-1"></i> Cetak Struk (Print)
        </button>
        <button onclick="window.close()" class="btn btn-outline-secondary rounded-pill px-3 ms-2">
            Tutup
        </button>
    </div>

    <div class="receipt-card">
        
        <!-- Store Header -->
        <div class="text-center mb-3">
            <h4 class="fw-bold mb-0">ARUNA COFFEE HOUSE</h4>
            <small class="d-block text-muted">Kafe Kopi Nusantara</small>
            <small class="d-block text-muted">Jl. Pemuda Raya No. 18, Kota Malang</small>
            <small class="d-block text-muted">WA: 0895-3266-30712 | IG: @garunayanza</small>
        </div>

        <div class="dashed-line"></div>

        <!-- Order Meta -->
        <div class="small">
            <div class="d-flex justify-content-between">
                <span>No. Struk:</span>
                <span class="fw-bold">{{ $order->order_code }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Tanggal:</span>
                <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Kasir/Barista:</span>
                <span>{{ $order->penjual ? $order->penjual->name : 'Sistem Online Kafe' }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Pelanggan:</span>
                <span class="fw-bold">{{ $order->nama_pemesan }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Tipe Order:</span>
                <span class="fw-bold text-uppercase">{{ $order->tipe_pesanan_label }}</span>
            </div>
            @if($order->catatan_alamat)
                <div class="d-flex justify-content-between">
                    <span>Meja / Alamat:</span>
                    <span>{{ $order->catatan_alamat }}</span>
                </div>
            @endif
        </div>

        <div class="dashed-line"></div>

        <!-- Items Table -->
        <div class="small">
            @foreach($order->items as $item)
                <div class="mb-2">
                    <div class="d-flex justify-content-between fw-bold">
                        <span>{{ $item->nama_produk }}</span>
                        <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between text-muted" style="font-size: 0.8rem;">
                        <span>{{ $item->jumlah }} x Rp {{ number_format($item->harga_satuan, 0, ',', '.') }} ({{ $item->ukuran }} • {{ $item->suhu }} • {{ $item->manis }})</span>
                    </div>
                    @if($item->catatan_khusus)
                        <div class="text-muted" style="font-size: 0.75rem; font-style: italic;">* {{ $item->catatan_khusus }}</div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="dashed-line"></div>

        <!-- Totals -->
        <div class="small">
            <div class="d-flex justify-content-between">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($order->ongkir > 0)
                <div class="d-flex justify-content-between">
                    <span>Biaya Antar:</span>
                    <span>Rp {{ number_format($order->ongkir, 0, ',', '.') }}</span>
                </div>
            @endif
            <div class="d-flex justify-content-between fw-bold fs-6 mt-1">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
            </div>

            <div class="dashed-line"></div>

            <div class="d-flex justify-content-between">
                <span>Metode Bayar:</span>
                <span class="text-uppercase fw-bold">{{ $order->metode_pembayaran }}</span>
            </div>
            @if($order->uang_diterima)
                <div class="d-flex justify-content-between">
                    <span>Uang Diterima:</span>
                    <span>Rp {{ number_format($order->uang_diterima, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Kembalian:</span>
                    <span>Rp {{ number_format($order->uang_kembalian, 0, ',', '.') }}</span>
                </div>
            @endif
            <div class="d-flex justify-content-between">
                <span>Status Pembayaran:</span>
                <span class="fw-bold {{ $order->status_pembayaran === 'paid' ? 'text-success' : 'text-danger' }}">
                    {{ $order->status_pembayaran === 'paid' ? 'LUNAS' : 'BELUM LUNAS' }}
                </span>
            </div>
        </div>

        <div class="dashed-line"></div>

        <!-- Footer Note -->
        <div class="text-center small text-muted mt-3">
            <div class="fw-bold">TERIMA KASIH TELAH MENGUNJUNGI KAMI!</div>
            <div>Nikmati hari santaimu di Aruna Coffee House</div>
        </div>

    </div>

</body>
</html>
