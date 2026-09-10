<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aruna Coffee House - Kafe Kopi Nikmat & Cozy')</title>

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --kg-bg: #090706;
            --kg-surface: #120e0c;
            --kg-surface-card: #181310;
            --kg-surface-light: #221b16;
            --kg-surface-hover: #2e241e;
            --kg-border: rgba(255, 255, 255, 0.08);
            --kg-border-hover: rgba(217, 119, 6, 0.5);
            --kg-border-focus: #c48b5c;
            
            --kg-accent: #b47b4d;
            --kg-accent-dark: #8c4e28;
            --kg-accent-gradient: linear-gradient(135deg, #a05a2c 0%, #6e3519 100%);
            --kg-gold: #c48b5c;
            --kg-caramel: #d97706;

            --kg-text: #ffffff;
            --kg-text-muted: #a39992;
            --kg-text-subtle: #756c66;

            --kg-radius-sm: 8px;
            --kg-radius-md: 14px;
            --kg-radius-lg: 20px;
            --kg-radius-pill: 9999px;

            --kg-shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.35);
            --kg-shadow-md: 0 10px 30px rgba(0, 0, 0, 0.5);
            --kg-shadow-lg: 0 20px 45px rgba(0, 0, 0, 0.65);
            --kg-shadow-accent: 0 6px 24px rgba(160, 90, 44, 0.45);
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: var(--kg-bg);
            color: var(--kg-text);
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            letter-spacing: -0.01em;
        }

        /* Layout Structure */
        .kg-layout-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Left Desktop Sidebar */
        .kg-sidebar {
            width: 240px;
            min-width: 240px;
            background-color: var(--kg-surface);
            border-right: 1px solid var(--kg-border);
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            padding: 24px 16px;
            z-index: 1030;
        }

        .kg-sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .kg-sidebar::-webkit-scrollbar-thumb {
            background: var(--kg-surface-light);
            border-radius: 4px;
        }

        .kg-sidebar-link {
            color: var(--kg-text-muted);
            font-weight: 500;
            font-size: 0.92rem;
            padding: 10px 16px;
            border-radius: var(--kg-radius-pill);
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            margin-bottom: 4px;
        }

        .kg-sidebar-link:hover {
            color: #ffffff;
            background-color: var(--kg-surface-light);
        }

        .kg-sidebar-link.active {
            color: #ffffff;
            background: #382419;
            border: 1px solid rgba(196, 139, 92, 0.35);
            font-weight: 600;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .kg-sidebar-link i {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Promo Banner in Sidebar */
        .kg-sidebar-promo {
            background: linear-gradient(160deg, #1f1814 0%, #110d0b 100%);
            border: 1px solid var(--kg-border);
            border-radius: var(--kg-radius-lg);
            padding: 16px 14px;
            margin-top: auto;
            position: relative;
            overflow: hidden;
            text-align: left;
        }

        /* Main Content Wrapper */
        .kg-main-wrapper {
            flex-grow: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            background-color: var(--kg-bg);
        }

        /* Top Header Bar */
        .kg-topbar {
            background-color: rgba(14, 11, 9, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--kg-border);
            padding: 14px 28px;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        /* Search Input */
        .kg-search-input {
            background-color: #17120f !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #ffffff !important;
            font-size: 0.9rem;
            border-radius: var(--kg-radius-pill);
        }

        .kg-search-input::placeholder {
            color: var(--kg-text-subtle) !important;
        }

        .kg-search-input:focus {
            background-color: #1f1814 !important;
            border-color: var(--kg-accent) !important;
            color: #ffffff !important;
            box-shadow: 0 0 0 0.25rem rgba(180, 123, 77, 0.2) !important;
        }

        /* Buttons & Accents */
        .btn-kg-accent {
            background: linear-gradient(135deg, #a05a2c 0%, #6e3519 100%);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #ffffff;
            font-weight: 600;
            border-radius: var(--kg-radius-pill);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 16px rgba(110, 53, 25, 0.35);
        }

        .btn-kg-accent:hover, .btn-kg-accent:focus {
            background: linear-gradient(135deg, #b66834 0%, #7d3c1d 100%);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: var(--kg-shadow-accent);
        }

        .btn-kg-outline {
            background: #16110e !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #a39992 !important;
            font-weight: 500;
            border-radius: var(--kg-radius-pill);
            transition: all 0.2s ease;
        }

        .btn-kg-outline:hover {
            background: #241c17 !important;
            border-color: rgba(196, 139, 92, 0.4) !important;
            color: #ffffff !important;
            transform: translateY(-1px);
        }

        /* Radio & Checkbox Button Active Theme (Dark Espresso & Amber Glow) */
        .btn-check:checked + .btn-kg-outline,
        .btn-check:checked + .btn,
        .btn-check:checked + label,
        .btn-check:active + .btn-kg-outline,
        .btn-check:checked + label.btn-kg-outline,
        .btn-check:checked + label.btn-outline-secondary {
            background-color: #382419 !important;
            background: linear-gradient(135deg, #3d2518 0%, #29180f 100%) !important;
            border-color: #c48b5c !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            box-shadow: 0 0 16px rgba(196, 139, 92, 0.4) !important;
        }

        .btn-check:checked + .btn-kg-outline *,
        .btn-check:checked + .btn *,
        .btn-check:checked + label * {
            color: #ffffff !important;
        }

        .btn-check:focus + .btn-kg-outline,
        .btn-check:focus + .btn,
        .btn-check:focus + label {
            box-shadow: 0 0 0 0.25rem rgba(196, 139, 92, 0.25) !important;
            border-color: #c48b5c !important;
        }

        /* Cards & Surfaces */
        .kg-card {
            background-color: var(--kg-surface-card);
            border: 1px solid var(--kg-border);
            border-radius: var(--kg-radius-lg);
            color: #ffffff;
            box-shadow: var(--kg-shadow-md);
            transition: all 0.25s ease;
        }

        .kg-card-hover {
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.25s ease, box-shadow 0.25s ease;
        }

        .kg-card-hover:hover {
            border-color: rgba(196, 139, 92, 0.4) !important;
            transform: translateY(-4px);
            box-shadow: var(--kg-shadow-lg);
        }

        /* Badges & Avatars */
        .avatar-initial {
            width: 40px;
            height: 40px;
            background: var(--kg-accent-gradient);
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            text-transform: uppercase;
            box-shadow: var(--kg-shadow-sm);
        }

        .role-badge-admin {
            background: #ef4444;
            color: #fff;
            font-size: 0.72rem;
            padding: 3px 9px;
            border-radius: 6px;
            font-weight: 700;
        }

        .role-badge-penjual {
            background: #3b82f6;
            color: #fff;
            font-size: 0.72rem;
            padding: 3px 9px;
            border-radius: 6px;
            font-weight: 700;
        }

        .role-badge-customer {
            background: #10b981;
            color: #fff;
            font-size: 0.72rem;
            padding: 3px 9px;
            border-radius: 6px;
            font-weight: 700;
        }

        /* Mobile Bottom Navigation Bar */
        .kg-bottom-nav {
            background: rgba(14, 11, 9, 0.96);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-top: 1px solid var(--kg-border);
            padding: 8px 12px 12px;
            z-index: 1040;
        }

        .kg-bottom-nav-item {
            color: var(--kg-text-subtle);
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 4px;
            border-radius: 8px;
            transition: all 0.2s ease;
            position: relative;
        }

        .kg-bottom-nav-item i {
            font-size: 1.35rem;
            margin-bottom: 2px;
        }

        .kg-bottom-nav-item:hover, .kg-bottom-nav-item.active {
            color: var(--kg-gold);
        }

        .kg-bottom-nav-item.active i {
            color: var(--kg-accent);
        }

        /* Tables & Forms Dark Theme */
        .table {
            color: #ffffff !important;
            border-color: var(--kg-border) !important;
            margin-bottom: 0;
        }

        .table > :not(caption) > * > * {
            background-color: transparent !important;
            color: #ffffff !important;
            border-bottom: 1px solid var(--kg-border) !important;
            padding: 12px 14px;
            vertical-align: middle;
        }

        .table thead th {
            color: var(--kg-gold) !important;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            font-weight: 700;
            border-bottom: 1px solid var(--kg-border) !important;
        }

        .modal-content {
            background-color: var(--kg-surface-card) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: var(--kg-radius-lg);
            color: #ffffff;
        }

        .modal-header, .modal-footer {
            border-color: var(--kg-border) !important;
        }

        /* Clean Dark Pagination */
        .pagination .page-item .page-link {
            background-color: var(--kg-surface-light) !important;
            border: 1px solid var(--kg-border) !important;
            color: #ffffff !important;
            border-radius: 8px !important;
            padding: 6px 14px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .pagination .page-item.active .page-link {
            background: var(--kg-accent-gradient) !important;
            border-color: var(--kg-accent) !important;
            color: #ffffff !important;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(160, 90, 44, 0.35);
        }

        /* Guard against unbounded SVGs */
        svg.w-5.h-5, svg.w-6.h-6, nav[role="navigation"] svg {
            width: 16px !important;
            height: 16px !important;
            max-width: 20px !important;
            max-height: 20px !important;
            display: inline-block !important;
        }

        /* Helpers */
        .text-muted {
            color: var(--kg-text-muted) !important;
        }

        .text-subtle {
            color: var(--kg-text-subtle) !important;
        }

        .accent-color {
            color: var(--kg-accent) !important;
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="kg-layout-container">

        <!-- 1. Left Desktop Sidebar (Hidden on Mobile) -->
        <aside class="kg-sidebar d-none d-lg-flex">
            
            <!-- Brand Logo Header -->
            <div class="mb-4 ps-1">
                <a href="{{ route('home') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                    <div class="rounded-3 p-1 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #382419; border: 1px solid rgba(196, 139, 92, 0.4);">
                        <i class="bi bi-cup-hot text-white fs-5" style="color: var(--kg-gold) !important;"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-white fs-6 lh-1" style="letter-spacing: 0.8px;">KOPI ARUNA</div>
                        <small style="color: var(--kg-text-subtle); font-size: 0.65rem; letter-spacing: 0.5px;">HOUSE OF COFFEE</small>
                    </div>
                </a>
            </div>

            <!-- Vertical Navigation Pills -->
            <nav class="d-flex flex-column gap-1 mb-3">
                <a href="{{ route('home') }}" class="kg-sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="bi bi-house-door{{ request()->routeIs('home') ? '-fill' : '' }}"></i>
                    <span>Beranda</span>
                </a>
                <a href="{{ route('menu') }}" class="kg-sidebar-link {{ request()->routeIs('menu') ? 'active' : '' }}">
                    <i class="bi bi-grid{{ request()->routeIs('menu') ? '-fill' : '' }}"></i>
                    <span>Menu</span>
                </a>
                <a href="{{ route('cart.index') }}" class="kg-sidebar-link {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                    <i class="bi bi-bag{{ request()->routeIs('cart.*') ? '-fill' : '' }}"></i>
                    <span class="flex-grow-1">Pesan</span>
                    @php $cartCount = count(session()->get('cart', [])); @endphp
                    @if($cartCount > 0)
                        <span class="badge rounded-pill fw-bold" style="background: var(--kg-accent); color: #fff; font-size: 0.68rem;">{{ $cartCount }}</span>
                    @endif
                </a>
                <a href="{{ route('order.history') }}" class="kg-sidebar-link {{ request()->routeIs('order.history') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i>
                    <span>Riwayat</span>
                </a>
                <a href="{{ route('info.lokasi') }}" class="kg-sidebar-link {{ request()->routeIs('info.lokasi') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt{{ request()->routeIs('info.lokasi') ? '-fill' : '' }}"></i>
                    <span>Lokasi Kami</span>
                </a>
                <a href="{{ route('info.tentang') }}" class="kg-sidebar-link {{ request()->routeIs('info.tentang') ? 'active' : '' }}">
                    <i class="bi bi-info-circle{{ request()->routeIs('info.tentang') ? '-fill' : '' }}"></i>
                    <span>Tentang Kami</span>
                </a>
                @auth
                    <a href="{{ route('profile') }}" class="kg-sidebar-link {{ request()->routeIs('profile*') ? 'active' : '' }}">
                        <i class="bi bi-person-circle"></i>
                        <span>Profil Saya</span>
                    </a>
                @endauth
            </nav>

            <!-- Promo Card at Sidebar Bottom (Matching Reference Photo) -->
            <div class="kg-sidebar-promo shadow-sm">
                <div class="fw-bold text-white small mb-1">Ngopi Hemat<br>Setiap Hari</div>
                <div class="text-subtle mb-0" style="font-size: 0.75rem;">Diskon hingga</div>
                <div class="fw-extrabold mb-1" style="color: var(--kg-gold); font-size: 1.7rem; line-height: 1;">20%</div>
                <div class="text-muted mb-3" style="font-size: 0.7rem; line-height: 1.3;">
                    setiap pemesanan di jam 10.00 - 14.00
                </div>
                <a href="{{ route('menu') }}" class="btn btn-kg-accent btn-sm rounded-pill w-100 fw-semibold py-1 mb-3" style="font-size: 0.78rem;">
                    Pesan Sekarang
                </a>
                <!-- Iced Coffee Splash Artwork -->
                <div class="text-center rounded-3 overflow-hidden" style="background: radial-gradient(circle, rgba(160, 90, 44, 0.2) 0%, transparent 70%);">
                    <img src="{{ asset('images/promo_coffee_splash.jpg') }}" alt="Promo Iced Coffee" class="img-fluid rounded-3" style="max-height: 110px; object-fit: contain;">
                </div>
            </div>

            <!-- Mini Copyright -->
            <div class="text-center text-subtle mt-3" style="font-size: 0.68rem;">
                © 2026 Kopi Aruna House.<br>Semua hak dilindungi.
            </div>

        </aside>

        <!-- 2. Main Content Wrapper -->
        <div class="kg-main-wrapper">

            <!-- Top Header Bar -->
            <header class="kg-topbar">
                <div class="container-fluid px-0 d-flex align-items-center justify-content-between gap-3">
                    
                    <!-- Mobile Brand Logo (Left on Mobile) -->
                    <div class="d-flex align-items-center gap-2 d-lg-none">
                        <a href="{{ route('home') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                            <div class="rounded-3 p-1 d-flex align-items-center justify-content-center" style="background: var(--kg-accent-gradient); width: 34px; height: 34px;">
                                <i class="bi bi-cup-hot-fill text-white fs-5"></i>
                            </div>
                            <span class="fw-extrabold text-white fs-6">ARUNA COFFEE</span>
                        </a>
                    </div>

                    <!-- Search Input (Desktop & Tablet) -->
                    <div class="d-none d-lg-block flex-grow-1" style="max-width: 440px;">
                        <form action="{{ route('menu') }}" method="GET">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text kg-search-input border-end-0 rounded-start-pill ps-3">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" name="cari" value="{{ request('cari') }}" class="form-control kg-search-input border-start-0 rounded-end-pill ps-1 py-2" placeholder="Cari menu kopi favoritmu...">
                            </div>
                        </form>
                    </div>

                    <!-- Right Header Actions (Cart & User) -->
                    <div class="d-flex align-items-center gap-2 gap-md-3 ms-auto">
                        
                        <!-- Cart Icon Link -->
                        <a href="{{ route('cart.index') }}" class="position-relative text-white p-2 rounded-circle kg-card d-flex align-items-center justify-content-center text-decoration-none shadow-sm" style="width: 42px; height: 42px;" title="Keranjang Belanja">
                            <i class="bi bi-bag-heart text-warning fs-5"></i>
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark fw-bold" style="font-size: 0.7rem;">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        @auth
                            <!-- Logged In User Dropdown -->
                            <div class="dropdown">
                                <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle text-white p-1 rounded-pill" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="avatar-initial" style="width: 38px; height: 38px; font-size: 0.95rem;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <div class="d-none d-md-block text-start pe-2">
                                        <div class="fw-bold fs-6 lh-1">{{ Str::limit(Auth::user()->name, 14) }}</div>
                                        <div class="mt-1">
                                            @if(Auth::user()->isAdmin())
                                                <span class="role-badge-admin">Admin</span>
                                            @elseif(Auth::user()->isPenjual())
                                                <span class="role-badge-penjual">Kasir</span>
                                            @else
                                                <span class="role-badge-customer">Customer</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow-lg border-0" style="background-color: var(--kg-surface); border: 1px solid var(--kg-border) !important; border-radius: 14px;">
                                    <li class="px-3 py-2 border-bottom text-muted small" style="border-color: var(--kg-border) !important;">
                                        Masuk sebagai: <strong class="text-white">{{ Auth::user()->name }}</strong>
                                    </li>
                                    @if(Auth::user()->isAdmin())
                                        <li><a class="dropdown-item py-2 text-warning fw-bold" href="{{ route('admin.dashboard') }}"><i class="bi bi-shield-lock-fill me-2"></i> Dashboard Admin</a></li>
                                        <li><a class="dropdown-item py-2 text-info fw-bold" href="{{ route('penjual.pos.index') }}"><i class="bi bi-calculator me-2"></i> Kasir POS</a></li>
                                    @elseif(Auth::user()->isPenjual())
                                        <li><a class="dropdown-item py-2 text-info fw-bold" href="{{ route('penjual.pos.index') }}"><i class="bi bi-calculator me-2"></i> Kasir POS</a></li>
                                        <li><a class="dropdown-item py-2" href="{{ route('penjual.orders.index') }}"><i class="bi bi-receipt me-2"></i> Antrean Pesanan</a></li>
                                    @endif
                                    <li><a class="dropdown-item py-2 fw-semibold {{ request()->routeIs('profile*') ? 'text-warning' : '' }}" href="{{ route('profile') }}"><i class="bi bi-person-badge text-warning me-2"></i> Profil Saya</a></li>
                                    <li><a class="dropdown-item py-2" href="{{ route('order.history') }}"><i class="bi bi-clock-history me-2"></i> Riwayat Pesanan</a></li>
                                    <li><hr class="dropdown-divider" style="border-color: var(--kg-border) !important;"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger py-2 fw-semibold">
                                                <i class="bi bi-box-arrow-right me-2"></i> Keluar (Logout)
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <!-- Guest Login Button -->
                            <a href="{{ route('login') }}" class="btn btn-kg-accent rounded-pill px-4 py-2 fw-bold text-nowrap shadow-sm" style="font-size: 0.9rem;">
                                <i class="bi bi-person-fill me-1"></i> Masuk / Daftar
                            </a>
                        @endauth

                    </div>

                </div>

                <!-- Mobile Search Input (Visible only on mobile below header) -->
                <div class="d-lg-none mt-3">
                    <form action="{{ route('menu') }}" method="GET">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text kg-search-input border-end-0 rounded-start-pill ps-3">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="cari" value="{{ request('cari') }}" class="form-control kg-search-input border-start-0 rounded-end-pill ps-1 py-2" placeholder="Cari menu kopi favoritmu...">
                        </div>
                    </form>
                </div>
            </header>

            <!-- Global Alert Notifications -->
            <div class="container-fluid px-3 px-lg-4 pt-3">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow d-flex align-items-center gap-2" role="alert" style="background-color: rgba(16, 185, 129, 0.2); border: 1px solid #10b981 !important; color: #a7f3d0;">
                        <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                        <div class="fw-semibold">{{ session('success') }}</div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow d-flex align-items-center gap-2" role="alert" style="background-color: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444 !important; color: #fecaca;">
                        <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
                        <div class="fw-semibold">{{ session('error') }}</div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>

            <!-- Main Dynamic Page Content Injection -->
            <main class="flex-grow-1 pb-5 pb-lg-4">
                @yield('content')
            </main>

            <!-- Clean Compact Footer -->
            <footer class="border-top py-4 px-3 px-lg-4 mt-auto" style="background-color: var(--kg-surface); border-color: var(--kg-border) !important;">
                <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 text-center text-md-start">
                    <div>
                        <span class="fw-bold text-white">ARUNA COFFEE HOUSE</span>
                        <span class="text-muted small ms-2">© 2026 — Kafe Kopi Rintisan & Karya RPL.</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <a href="https://www.instagram.com/garunayanza" target="_blank" rel="noopener noreferrer" class="btn btn-kg-outline rounded-pill px-3 py-1 text-white small">
                            <i class="bi bi-instagram text-danger me-1"></i> @garunayanza
                        </a>
                        <a href="https://wa.me/62895326630712" target="_blank" rel="noopener noreferrer" class="btn btn-kg-outline rounded-pill px-3 py-1 text-white small">
                            <i class="bi bi-whatsapp text-success me-1"></i> 0895-3266-30712
                        </a>
                        <a href="https://maps.app.goo.gl/arKRVNFRJaMSyZPU8" target="_blank" rel="noopener noreferrer" class="btn btn-kg-outline rounded-pill px-3 py-1 text-white small">
                            <i class="bi bi-geo-alt-fill text-warning me-1"></i> Lokasi Maps
                        </a>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    <!-- 3. Mobile Fixed Bottom Navigation Bar (Visible only on mobile < 992px) -->
    <nav class="kg-bottom-nav fixed-bottom d-lg-none">
        <div class="d-flex align-items-center justify-content-around">
            <a href="{{ route('home') }}" class="kg-bottom-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="bi bi-house-door-fill"></i>
                <span>Beranda</span>
            </a>
            <a href="{{ route('menu') }}" class="kg-bottom-nav-item {{ request()->routeIs('menu') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i>
                <span>Menu</span>
            </a>
            <a href="{{ route('cart.index') }}" class="kg-bottom-nav-item {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                <div class="position-relative">
                    <i class="bi bi-bag-fill"></i>
                    @if($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark fw-bold" style="font-size: 0.6rem; padding: 2px 4px;">
                            {{ $cartCount }}
                        </span>
                    @endif
                </div>
                <span>Pesan</span>
            </a>
            <a href="{{ route('order.history') }}" class="kg-bottom-nav-item {{ request()->routeIs('order.history') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Riwayat</span>
            </a>
            <a href="{{ route('info.lokasi') }}" class="kg-bottom-nav-item {{ request()->routeIs('info.lokasi') ? 'active' : '' }}">
                <i class="bi bi-geo-alt-fill"></i>
                <span>Lokasi</span>
            </a>
            @auth
                <a href="{{ route('profile') }}" class="kg-bottom-nav-item {{ request()->routeIs('profile*') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i>
                    <span>Akun</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="kg-bottom-nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Masuk</span>
                </a>
            @endauth
        </div>
    </nav>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
