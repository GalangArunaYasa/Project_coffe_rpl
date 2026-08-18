@extends('layouts.admin')

@section('title', 'Dashboard Admin - Kopi Gerobakan')

@section('content')

<div class="mb-4">
    <span class="text-uppercase fw-bold"
          style="
            color: var(--kg-gold-deep);
            font-size: .72rem;
            letter-spacing: .12em;
          ">
        Monitoring
    </span>

    <h1 class="fw-bold mb-1">
        Dashboard Admin
    </h1>

    <p class="text-muted mb-0">
        Pantau aktivitas karyawan dan operasional Kopi Gerobakan hari ini.
    </p>
</div>

{{-- STATISTIC --}}
<div class="row g-4 mb-4">

    {{-- TOTAL KARYAWAN --}}
    <div class="col-sm-6 col-xl-3">

        <div class="stat-card">

            <div class="d-flex justify-content-between align-items-start">

                <div>
                    <small class="text-muted">
                        Total Karyawan
                    </small>

                    <div class="stat-number mt-1">
                        {{ $totalKaryawan ?? 0 }}
                    </div>

                    <small class="text-muted">
                        seluruh karyawan
                    </small>
                </div>

                <div class="stat-icon"
                     style="
                        background: rgba(43,27,18,.08);
                        color: var(--kg-espresso);
                     ">
                    <i class="bi bi-people-fill"></i>
                </div>

            </div>

        </div>

    </div>

    {{-- AKTIF --}}
    <div class="col-sm-6 col-xl-3">

        <div class="stat-card">

            <div class="d-flex justify-content-between align-items-start">

                <div>
                    <small class="text-muted">
                        Karyawan Aktif Hari Ini
                    </small>

                    <div class="stat-number mt-1">
                        {{ $karyawanAktif ?? 0 }}
                    </div>

                    <small style="color: var(--kg-olive);">
                        ● Sedang aktif
                    </small>
                </div>

                <div class="stat-icon"
                     style="
                        background: rgba(107,122,79,.14);
                        color: var(--kg-olive);
                     ">
                    <i class="bi bi-person-check-fill"></i>
                </div>

            </div>

        </div>

    </div>

    {{-- SUDAH ABSEN --}}
    <div class="col-sm-6 col-xl-3">

        <div class="stat-card">

            <div class="d-flex justify-content-between align-items-start">

                <div>
                    <small class="text-muted">
                        Sudah Absen
                    </small>

                    <div class="stat-number mt-1">
                        {{ $sudahAbsen ?? 0 }}
                    </div>

                    <small style="color: var(--kg-gold-deep);">
                        Hari ini
                    </small>
                </div>

                <div class="stat-icon"
                     style="
                        background: rgba(231,163,62,.14);
                        color: var(--kg-gold-deep);
                     ">
                    <i class="bi bi-calendar-check-fill"></i>
                </div>

            </div>

        </div>

    </div>

    {{-- BELUM ABSEN --}}
    <div class="col-sm-6 col-xl-3">

        <div class="stat-card">

            <div class="d-flex justify-content-between align-items-start">

                <div>
                    <small class="text-muted">
                        Belum Absen
                    </small>

                    <div class="stat-number mt-1">
                        {{ $belumAbsen ?? 0 }}
                    </div>

                    <small style="color: var(--kg-brick);">
                        Perlu diperiksa
                    </small>
                </div>

                <div class="stat-icon"
                     style="
                        background: rgba(166,61,47,.12);
                        color: var(--kg-brick);
                     ">
                    <i class="bi bi-person-x-fill"></i>
                </div>

            </div>

        </div>

    </div>

</div>

{{-- AKTIVITAS PRODUK --}}
<div class="row g-4 mb-4">

    <div class="col-lg-8">

        <div class="content-card">

            <div class="content-card-header">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h4 class="mb-1 fw-bold">
                            Aktivitas Produk
                        </h4>

                        <small class="text-muted">
                            Perubahan dan aktivitas produk terbaru
                        </small>
                    </div>

                    <i class="bi bi-box-seam fs-4"
                       style="color: var(--kg-gold-deep);"></i>

                </div>

            </div>

            <div>

                @forelse($aktivitasProduk ?? [] as $aktivitas)

                    <div class="activity-item">

                        <div class="d-flex align-items-center">

                            <div class="activity-icon me-3">
                                <i class="bi bi-cup-hot-fill"></i>
                            </div>

                            <div class="flex-grow-1">

                                <div class="fw-bold">
                                    {{ $aktivitas->produk->nama ?? 'Produk' }}
                                </div>

                                <small class="text-muted">
                                    {{ $aktivitas->deskripsi ?? 'Aktivitas produk' }}
                                </small>

                            </div>

                            <div class="text-end">

                                <div class="fw-semibold small">
                                    {{ $aktivitas->jumlah ?? 0 }}
                                </div>

                                <small class="text-muted">
                                    {{ $aktivitas->created_at?->diffForHumans() }}
                                </small>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="text-center py-5">

                        <i class="bi bi-box-seam fs-1 text-muted"></i>

                        <p class="text-muted mt-2 mb-0">
                            Belum ada aktivitas produk.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

    {{-- RINGKASAN PRODUK --}}
    <div class="col-lg-4">

        <div class="content-card h-100">

            <div class="content-card-header">

                <h4 class="mb-1 fw-bold">
                    Ringkasan Produk
                </h4>

                <small class="text-muted">
                    Kondisi produk saat ini
                </small>

            </div>

            <div class="p-3">

                <div class="d-flex justify-content-between py-3 border-bottom">
                    <span class="text-muted">
                        Total Produk
                    </span>

                    <strong>
                        {{ $totalProduk ?? 0 }}
                    </strong>
                </div>

                <div class="d-flex justify-content-between py-3 border-bottom">
                    <span class="text-muted">
                        Produk Terjual
                    </span>

                    <strong>
                        {{ $produkTerjual ?? 0 }}
                    </strong>
                </div>

                <div class="d-flex justify-content-between py-3 border-bottom">
                    <span class="text-muted">
                        Stok Tersedia
                    </span>

                    <strong style="color: var(--kg-olive);">
                        {{ $stokTersedia ?? 0 }}
                    </strong>
                </div>

                <div class="d-flex justify-content-between py-3">
                    <span class="text-muted">
                        Stok Menipis
                    </span>

                    <strong style="color: var(--kg-brick);">
                        {{ $stokMenipis ?? 0 }}
                    </strong>
                </div>

            </div>

        </div>

    </div>

</div>


@endsection