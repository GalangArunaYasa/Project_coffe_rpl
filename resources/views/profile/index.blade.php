@extends('layouts.app')

@section('title', 'Profil Akun Saya - Aruna Coffee House')

@section('content')

<div class="container-fluid px-3 px-lg-5 py-4">

    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">Profil Pengguna</li>
        </ol>
    </nav>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center gap-3 p-3 mb-4" role="alert" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(6, 78, 59, 0.3) 100%); border: 1px solid rgba(16, 185, 129, 0.4) !important; color: #ffffff;">
            <i class="bi bi-check-circle-fill fs-4 text-success"></i>
            <div>
                <strong class="d-block">Berhasil!</strong>
                <small>{{ session('success') }}</small>
            </div>
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center gap-3 p-3 mb-4" role="alert" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(153, 27, 27, 0.3) 100%); border: 1px solid rgba(239, 68, 68, 0.4) !important; color: #ffffff;">
            <i class="bi bi-exclamation-triangle-fill fs-4 text-danger"></i>
            <div>
                <strong class="d-block">Terjadi Kesalahan:</strong>
                <ul class="mb-0 ps-3 small">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- 1. Hero Profile Banner Card -->
    <div class="kg-card rounded-4 p-4 p-md-5 mb-4 shadow-lg position-relative overflow-hidden" 
         style="background: linear-gradient(145deg, #1c1511 0%, #110d0b 100%); border: 1px solid rgba(196, 139, 92, 0.35);">
        
        <div class="row align-items-center gy-4">
            
            <div class="col-md-8 d-flex align-items-center gap-3 gap-md-4 flex-wrap flex-sm-nowrap">
                <!-- Big Initial Avatar -->
                <div class="avatar-initial rounded-circle shadow-lg flex-shrink-0" 
                     style="width: 84px; height: 84px; font-size: 2.2rem; background: var(--kg-accent-gradient); border: 3px solid rgba(251, 191, 36, 0.4); box-shadow: 0 0 25px rgba(245, 158, 11, 0.35);">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <div>
                    <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                        <h1 class="h3 fw-extrabold text-white mb-0">{{ $user->name }}</h1>
                        @if($user->isAdmin())
                            <span class="role-badge-admin px-3 py-1 rounded-pill fw-bold" style="font-size: 0.75rem;">
                                <i class="bi bi-shield-check me-1"></i> Administrator Kafe
                            </span>
                        @elseif($user->isPenjual())
                            <span class="role-badge-penjual px-3 py-1 rounded-pill fw-bold" style="font-size: 0.75rem;">
                                <i class="bi bi-cup-hot-fill me-1"></i> Barista / Kasir
                            </span>
                        @else
                            <span class="role-badge-customer px-3 py-1 rounded-pill fw-bold" style="font-size: 0.75rem;">
                                <i class="bi bi-person-check-fill me-1"></i> Pelanggan Setia
                            </span>
                        @endif
                    </div>

                    <p class="text-muted mb-2 small d-flex align-items-center gap-2">
                        <i class="bi bi-envelope-fill text-warning"></i> {{ $user->email }}
                    </p>

                    <div class="d-flex align-items-center gap-3 text-muted small" style="font-size: 0.75rem;">
                        <span><i class="bi bi-calendar-check text-info me-1"></i> Terdaftar sejak {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : 'Agustus 2026' }}</span>
                    </div>
                </div>
            </div>

            <!-- Role Action Shortcuts -->
            <div class="col-md-4 text-md-end">
                <div class="d-flex flex-column flex-sm-row justify-content-md-end gap-2">
                    @if($user->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-warning rounded-pill px-4 py-2 fw-bold text-dark shadow">
                            <i class="bi bi-shield-lock-fill me-1"></i> Panel Admin
                        </a>
                        <a href="{{ route('penjual.pos.index') }}" class="btn btn-kg-outline rounded-pill px-3 py-2 fw-bold text-white">
                            <i class="bi bi-calculator me-1 text-warning"></i> Kasir POS
                        </a>
                    @elseif($user->isPenjual())
                        <a href="{{ route('penjual.pos.index') }}" class="btn btn-kg-accent rounded-pill px-4 py-2 fw-bold shadow">
                            <i class="bi bi-calculator me-1"></i> Buka Kasir POS
                        </a>
                        <a href="{{ route('penjual.orders.index') }}" class="btn btn-kg-outline rounded-pill px-3 py-2 fw-bold text-white">
                            <i class="bi bi-receipt me-1 text-warning"></i> Antrean
                        </a>
                    @else
                        <a href="{{ route('menu') }}" class="btn btn-kg-accent rounded-pill px-4 py-2 fw-bold shadow">
                            <i class="bi bi-cup-hot-fill me-1"></i> Pesan Kopi
                        </a>
                        <a href="{{ route('order.history') }}" class="btn btn-kg-outline rounded-pill px-3 py-2 fw-bold text-white">
                            <i class="bi bi-clock-history me-1 text-warning"></i> Riwayat
                        </a>
                    @endif
                </div>
            </div>

        </div>

    </div>

    <!-- 2. Interactive Quick Stats Cards -->
    <div class="row g-3 mb-4">
        
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card h-100 p-4 rounded-4" style="background: #14100e; border: 1px solid rgba(255, 255, 255, 0.08);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Total Pesanan</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center p-2" style="background: rgba(245, 158, 11, 0.15); width: 38px; height: 38px;">
                        <i class="bi bi-receipt text-warning fs-5"></i>
                    </div>
                </div>
                <h2 class="h3 fw-extrabold text-white mb-1">{{ $totalPesanan }}</h2>
                <small class="text-muted">Transaksi di kafe</small>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card h-100 p-4 rounded-4" style="background: #14100e; border: 1px solid rgba(255, 255, 255, 0.08);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Total Pembelian</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center p-2" style="background: rgba(16, 185, 129, 0.15); width: 38px; height: 38px;">
                        <i class="bi bi-wallet2 text-success fs-5"></i>
                    </div>
                </div>
                <h2 class="h3 fw-extrabold text-white mb-1">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h2>
                <small class="text-success"><i class="bi bi-check2 me-1"></i>Transaksi lunas</small>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card h-100 p-4 rounded-4" style="background: #14100e; border: 1px solid rgba(255, 255, 255, 0.08);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Pesanan Aktif</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center p-2" style="background: rgba(59, 130, 246, 0.15); width: 38px; height: 38px;">
                        <i class="bi bi-hourglass-split text-info fs-5"></i>
                    </div>
                </div>
                <h2 class="h3 fw-extrabold text-info mb-1">{{ $pesananAktif }}</h2>
                <small class="text-muted">Sedang diracik / diantar</small>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card h-100 p-4 rounded-4" style="background: #14100e; border: 1px solid rgba(255, 255, 255, 0.08);">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Pesanan Selesai</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center p-2" style="background: rgba(251, 191, 36, 0.15); width: 38px; height: 38px;">
                        <i class="bi bi-cup-hot text-warning fs-5"></i>
                    </div>
                </div>
                <h2 class="h3 fw-extrabold text-success mb-1">{{ $pesananSelesai }}</h2>
                <small class="text-muted">Telah dinikmati</small>
            </div>
        </div>

    </div>

    <!-- 3. Main Profile Tabs / Section Grid -->
    <div class="row g-4">
        
        <!-- Left: Edit Profile & Password Form -->
        <div class="col-lg-7">
            
            <!-- Update Informasi Profil Card -->
            <div class="kg-card rounded-4 p-4 shadow-sm mb-4" style="background: #14100e; border: 1px solid rgba(255, 255, 255, 0.08);">
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                    <h2 class="h5 fw-bold text-white mb-0">
                        <i class="bi bi-person-lines-fill me-2 text-warning"></i> Informasi Akun
                    </h2>
                    <span class="badge bg-secondary rounded-pill px-3 py-1" style="font-size: 0.7rem;">Data Utama</span>
                </div>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label text-white small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text kg-search-input border-end-0 rounded-start-3"><i class="bi bi-person text-muted"></i></span>
                            <input type="text" name="name" id="name" class="form-control kg-search-input border-start-0 rounded-end-3 py-2" value="{{ old('name', $user->name) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label text-white small fw-bold">Alamat Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text kg-search-input border-end-0 rounded-start-3"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" name="email" id="email" class="form-control kg-search-input border-start-0 rounded-end-3 py-2" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-white small fw-bold">Hak Akses / Peran Akun</label>
                        <input type="text" class="form-control kg-search-input rounded-3 py-2 opacity-75" value="{{ strtoupper($user->role ?? 'CUSTOMER') }}" readonly disabled>
                        <small class="text-muted" style="font-size: 0.72rem;">Role akun hanya dapat diubah oleh Administrator kafe.</small>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-kg-accent rounded-pill px-4 py-2 fw-bold shadow">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan Profil
                        </button>
                    </div>
                </form>
            </div>

            <!-- Update Password Card -->
            <div class="kg-card rounded-4 p-4 shadow-sm mb-4" style="background: #14100e; border: 1px solid rgba(255, 255, 255, 0.08);">
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                    <h2 class="h5 fw-bold text-white mb-0">
                        <i class="bi bi-shield-lock-fill me-2 text-warning"></i> Keamanan & Ganti Password
                    </h2>
                    <span class="badge bg-secondary rounded-pill px-3 py-1" style="font-size: 0.7rem;">Privasi</span>
                </div>

                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="current_password" class="form-label text-white small fw-bold">Password Lama <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text kg-search-input border-end-0 rounded-start-3"><i class="bi bi-key text-muted"></i></span>
                            <input type="password" name="current_password" id="current_password" class="form-control kg-search-input border-start-0 rounded-end-3 py-2" placeholder="Masukkan password lama Anda" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="password" class="form-label text-white small fw-bold">Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text kg-search-input border-end-0 rounded-start-3"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password" name="password" id="password" class="form-control kg-search-input border-start-0 rounded-end-3 py-2" placeholder="Minimal 6 karakter" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label text-white small fw-bold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text kg-search-input border-end-0 rounded-start-3"><i class="bi bi-lock-fill text-muted"></i></span>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control kg-search-input border-start-0 rounded-end-3 py-2" placeholder="Ulangi password baru" required>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-kg-outline rounded-pill px-4 py-2 fw-bold text-white shadow-sm">
                            <i class="bi bi-shield-check me-1 text-warning"></i> Perbarui Password
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- Right: Recent Activity / Orders -->
        <div class="col-lg-5">
            <div class="kg-card rounded-4 p-4 shadow-sm mb-4 position-sticky" style="top: 90px; background: #14100e; border: 1px solid rgba(255, 255, 255, 0.08);">
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                    <h2 class="h5 fw-bold text-white mb-0">
                        <i class="bi bi-clock-history me-2 text-warning"></i> Pesanan Terakhir
                    </h2>
                    <a href="{{ route('order.history') }}" class="btn btn-sm btn-kg-outline rounded-pill px-3" style="font-size: 0.75rem;">
                        Lihat Semua
                    </a>
                </div>

                @if($recentOrders->count() > 0)
                    <div class="d-flex flex-column gap-3">
                        @foreach($recentOrders as $rOrd)
                            <div class="p-3 rounded-3" style="background-color: #1a1410; border: 1px solid rgba(255, 255, 255, 0.05);">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold font-monospace text-warning small">{{ $rOrd->order_code }}</span>
                                    <span class="badge {{ $rOrd->status_badge_class }} rounded-pill" style="font-size: 0.65rem;">
                                        {{ $rOrd->status_label }}
                                    </span>
                                </div>

                                <div class="small text-muted mb-2" style="font-size: 0.75rem;">
                                    {{ $rOrd->created_at->translatedFormat('d M Y, H:i') }} WIB • <span class="badge bg-secondary" style="font-size: 0.6rem;">{{ $rOrd->tipe_pesanan_label }}</span>
                                </div>

                                <div class="small text-white mb-2">
                                    @foreach($rOrd->items->take(2) as $it)
                                        <div>• {{ $it->nama_produk }} <span class="text-muted">({{ $it->jumlah }}x)</span></div>
                                    @endforeach
                                    @if($rOrd->items->count() > 2)
                                        <small class="text-muted">+ {{ $rOrd->items->count() - 2 }} item lainnya</small>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: rgba(255, 255, 255, 0.06) !important;">
                                    <span class="fw-bold text-white small">Rp {{ number_format($rOrd->total_harga, 0, ',', '.') }}</span>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('order.track', $rOrd->order_code) }}" class="btn btn-kg-accent btn-sm rounded-pill px-2 py-0" style="font-size: 0.7rem;">
                                            <i class="bi bi-radar"></i> Lacak
                                        </a>
                                        <a href="{{ route('order.receipt', $rOrd->order_code) }}" target="_blank" class="btn btn-kg-outline btn-sm rounded-pill px-2 py-0" style="font-size: 0.7rem;">
                                            <i class="bi bi-printer text-warning"></i> Struk
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-bag-x fs-1 d-block mb-2 text-secondary"></i>
                        <p class="small mb-3">Belum ada aktivitas pesanan kopi.</p>
                        <a href="{{ route('menu') }}" class="btn btn-kg-accent btn-sm rounded-pill px-4 fw-bold">
                            Mulai Pesan Kopi
                        </a>
                    </div>
                @endif

                <!-- Logout CTA Button -->
                <div class="pt-3 border-top mt-4" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 rounded-pill py-2 fw-semibold small">
                            <i class="bi bi-box-arrow-right me-1"></i> Keluar dari Akun (Logout)
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
