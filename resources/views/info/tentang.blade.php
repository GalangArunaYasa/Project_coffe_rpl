@extends('layouts.app')

@section('title', 'Tentang Kami & Tim Pengembang - Aruna Coffee House')

@section('content')

<div class="container-fluid px-3 px-lg-5 py-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">Tentang Kami & Tim</li>
        </ol>
    </nav>

    <!-- Brand Story Section -->
    <div class="row align-items-center gy-5 mb-5">
        <div class="col-lg-6">
            <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill mb-3">Profil & Kisah Rintisan</span>
            <h1 class="display-5 fw-extrabold text-white mb-3">Membangun Kafe Kopi Modern dari Nol</h1>
            <p class="lead text-white mb-4" style="opacity: 0.95; line-height: 1.6;">
                <strong>Aruna Coffee House</strong> adalah sebuah kafe kopi rintisan yang memadukan keaslian cita rasa biji kopi nusantara dengan teknologi sistem informasi modern berbasis web.
            </p>
            <p class="text-muted fs-6" style="line-height: 1.6;">
                Proyek ini dikembangkan sebagai karya Rekayasa Perangkat Lunak (RPL) yang menghadirkan alur operasional terpadu antara <strong>Manajemen Restok oleh Admin</strong>, <strong>Pelayanan Cepat Kasir POS oleh Penjual</strong>, dan <strong>Kemudahan Pemesanan Online oleh Pelanggan</strong>.
            </p>
        </div>

        <div class="col-lg-6">
            <div class="kg-card rounded-4 p-4 shadow-lg text-center">
                <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=600&auto=format&fit=crop&q=80" alt="Tentang Aruna Coffee" class="img-fluid rounded-4 shadow w-100" style="max-height: 380px; object-fit: cover;">
            </div>
        </div>
    </div>

    <!-- Team Section Header -->
    <div class="text-center mx-auto mb-5 pt-4 border-top" style="border-color: var(--kg-border) !important; max-width: 700px;">
        <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill mb-2">Tim Pengembang RPL</span>
        <h2 class="h2 fw-bold text-white mb-2">Anggota Kelompok Pengembang Sistem</h2>
        <p class="text-muted">Kolaborasi tim siswa Rekayasa Perangkat Lunak di balik terciptanya website Aruna Coffee.</p>
    </div>

    <!-- 5 Team Member Profile Cards (High Contrast & Clean Styling) -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-5 g-4 mb-5">
        
        <!-- Anggota 1: Project Lead & Fullstack -->
        <div class="col">
            <div class="card kg-card kg-card-hover rounded-4 h-100 text-center p-4">
                <div class="avatar-initial mx-auto mb-3 shadow" style="width: 72px; height: 72px; font-size: 1.75rem;">
                    G
                </div>
                <h3 class="h5 fw-bold text-white mb-1">Galang Aruna Yasa</h3>
                <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill mb-2">Project Leader</span>
                <p class="text-white small mb-2 fw-semibold">Fullstack Web Developer</p>
                <small class="text-warning font-monospace d-block mb-3">NIS: 7369</small>

                <div class="pt-2 border-top mt-auto" style="border-color: var(--kg-border) !important;">
                    <span class="text-muted small">Koordinator Arsitektur Sistem & Backend</span>
                </div>
            </div>
        </div>

        <!-- Anggota 2: Backend Specialist -->
        <div class="col">
            <div class="card kg-card kg-card-hover rounded-4 h-100 text-center p-4">
                <div class="avatar-initial mx-auto mb-3 shadow" style="width: 72px; height: 72px; font-size: 1.75rem; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                    B
                </div>
                <h3 class="h5 fw-bold text-white mb-1">Kelvin Alvino Azza</h3>
                <span class="badge bg-primary text-white fw-bold px-3 py-1 rounded-pill mb-2">Backend</span>
                <p class="text-white small mb-2 fw-semibold">Database & API Specialist</p>
                <small class="text-warning font-monospace d-block mb-3">NIS: 7373</small>
                
                <div class="pt-2 border-top mt-auto" style="border-color: var(--kg-border) !important;">
                    <span class="text-muted small">Perancang Skema Database & POS Engine</span>
                </div>
            </div>
        </div>

        <!-- Anggota 3: UI/UX & Frontend Designer -->
        <div class="col">
            <div class="card kg-card kg-card-hover rounded-4 h-100 text-center p-4">
                <div class="avatar-initial mx-auto mb-3 shadow" style="width: 72px; height: 72px; font-size: 1.75rem; background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);">
                    C
                </div>
                <h3 class="h5 fw-bold text-white mb-1">Yoga Arya Pratama</h3>
                <span class="badge bg-danger text-white fw-bold px-3 py-1 rounded-pill mb-2">UI/UX Designer</span>
                <p class="text-white small mb-2 fw-semibold">Frontend Specialist</p>
                <small class="text-warning font-monospace d-block mb-3">NIS: 7391</small>
                
                <div class="pt-2 border-top mt-auto" style="border-color: var(--kg-border) !important;">
                    <span class="text-muted small">Desain Antarmuka & Tata Letak Responsif</span>
                </div>
            </div>
        </div>

        <!-- Anggota 4: Quality Assurance & Tester -->
        <div class="col">
            <div class="card kg-card kg-card-hover rounded-4 h-100 text-center p-4">
                <div class="avatar-initial mx-auto mb-3 shadow" style="width: 72px; height: 72px; font-size: 1.75rem; background: linear-gradient(135deg, #10b981 0%, #047857 100%);">
                    D
                </div>
                <h3 class="h5 fw-bold text-white mb-1">Asih Agustina</h3>
                <span class="badge bg-success text-white fw-bold px-3 py-1 rounded-pill mb-2">Quality Content</span>
                <p class="text-white small mb-2 fw-semibold">Visual Content Developer</p>
                <small class="text-warning font-monospace d-block mb-3">NIS: 7362</small>
                
                <div class="pt-2 border-top mt-auto" style="border-color: var(--kg-border) !important;">
                    <span class="text-muted small">Pengujian Alur Bisnis & Validasi Stok</span>
                </div>
            </div>
        </div>

        <!-- Anggota 5: Business Analyst & Documentation -->
        <div class="col">
            <div class="card kg-card kg-card-hover rounded-4 h-100 text-center p-4">
                <div class="avatar-initial mx-auto mb-3 shadow" style="width: 72px; height: 72px; font-size: 1.75rem; background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);">
                    E
                </div>
                <h3 class="h5 fw-bold text-white mb-1">Nabila Herviati</h3>
                <span class="badge bg-info text-dark fw-bold px-3 py-1 rounded-pill mb-2">Documentation</span>
                <p class="text-white small mb-2 fw-semibold">Business Analyst</p>
                <small class="text-warning font-monospace d-block mb-3">NIS: 7379</small>
                
                <div class="pt-2 border-top mt-auto" style="border-color: var(--kg-border) !important;">
                    <span class="text-muted small">Analisis Kebutuhan Sistem 3 Role</span>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
