<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - Aruna Coffee House')</title>

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --kg-bg: #0d0b0a;
            --kg-surface: #171310;
            --kg-surface-light: #241c17;
            --kg-surface-hover: #32261f;
            --kg-border: #3d2f26;
            --kg-accent: #f59e0b;
            --kg-accent-dark: #d97706;
            --kg-accent-gradient: linear-gradient(135deg, #f59e0b 0%, #b45309 100%);
            --kg-text: #ffffff;
            --kg-text-muted: #d1c7bd;
            --kg-text-subtle: #9ca3af;
            --kg-gold: #fbbf24;

            /* Compatibility aliases */
            --adm-border: #3d2f26;
            --adm-surface: #171310;
            --adm-surface-light: #241c17;
            --adm-accent: #f59e0b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: var(--kg-bg);
            color: var(--kg-text);
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Navigation Bar */
        .adm-navbar {
            background-color: rgba(23, 19, 16, 0.95);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--kg-border);
            z-index: 1030;
            transition: all 0.3s ease;
        }

        .adm-nav-link {
            color: var(--kg-text-muted);
            padding: 8px 16px;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 999px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .adm-nav-link:hover {
            color: #ffffff;
            background-color: var(--kg-surface-light);
        }

        .adm-nav-link.active {
            background: var(--kg-accent-gradient);
            color: #ffffff;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.35);
        }

        /* Cards */
        .adm-card, .kg-card {
            background-color: var(--kg-surface) !important;
            border: 1px solid var(--kg-border) !important;
            border-radius: 20px;
            color: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.35);
        }

        .stat-card {
            background: linear-gradient(145deg, #1f1814 0%, #171310 100%) !important;
            border: 1px solid var(--kg-border) !important;
            border-radius: 20px;
            padding: 24px;
            transition: transform 0.25s, box-shadow 0.25s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: var(--kg-accent) !important;
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.2);
        }

        /* Forms & Inputs */
        .form-control, .form-select, .kg-search-input {
            background-color: var(--kg-surface-light) !important;
            border: 1px solid var(--kg-border) !important;
            color: #ffffff !important;
            border-radius: 12px;
        }

        .form-control:focus, .form-select:focus, .kg-search-input:focus {
            background-color: var(--kg-surface-hover) !important;
            border-color: var(--kg-accent) !important;
            color: #ffffff !important;
            box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.25) !important;
        }

        .form-control::placeholder, .kg-search-input::placeholder {
            color: var(--kg-text-subtle) !important;
        }

        /* Tables */
        .table {
            color: #ffffff !important;
            border-color: var(--kg-border) !important;
            margin-bottom: 0;
        }

        .table > :not(caption) > * > * {
            background-color: transparent !important;
            color: #ffffff !important;
            border-bottom: 1px solid var(--kg-border) !important;
            padding: 14px 16px;
            vertical-align: middle;
        }

        .table thead th {
            background-color: var(--kg-surface-light) !important;
            color: var(--kg-gold) !important;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid var(--kg-border) !important;
            white-space: nowrap;
        }

        .table-hover > tbody > tr:hover > * {
            background-color: var(--kg-surface-light) !important;
        }

        /* Buttons */
        .btn-kg-accent, .btn-warning {
            background: var(--kg-accent-gradient) !important;
            border: none !important;
            color: #ffffff !important;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-kg-accent:hover, .btn-warning:hover {
            background: linear-gradient(135deg, #d97706 0%, #92400e 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
            transform: translateY(-1px);
        }

        .btn-kg-outline, .btn-outline-secondary, .btn-outline-light {
            background: transparent !important;
            border: 1px solid var(--kg-border) !important;
            color: #ffffff !important;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-kg-outline:hover, .btn-outline-secondary:hover, .btn-outline-light:hover {
            background-color: var(--kg-surface-light) !important;
            border-color: var(--kg-accent) !important;
            color: #ffffff !important;
        }

        /* Modals */
        .modal-content {
            background-color: var(--kg-surface) !important;
            border: 1px solid var(--kg-border) !important;
            border-radius: 20px;
            color: #ffffff !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
        }

        .modal-header, .modal-footer {
            border-color: var(--kg-border) !important;
        }

        /* Text readability */
        .text-muted {
            color: var(--kg-text-muted) !important;
        }

        .text-subtle {
            color: var(--kg-text-subtle) !important;
        }

        /* Dark Themed Pagination */
        .pagination {
            margin-bottom: 0;
            gap: 4px;
            display: flex;
            align-items: center;
        }

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
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.35);
        }

        .pagination .page-item.disabled .page-link {
            background-color: var(--kg-surface) !important;
            border-color: var(--kg-border) !important;
            color: var(--kg-text-subtle) !important;
            opacity: 0.4;
        }

        .pagination .page-item:not(.active):not(.disabled) .page-link:hover {
            background-color: var(--kg-surface-hover) !important;
            border-color: var(--kg-accent) !important;
            color: var(--kg-gold) !important;
        }

        /* Guard against any unbounded SVGs */
        svg.w-5.h-5, svg.w-6.h-6, nav[role="navigation"] svg {
            width: 16px !important;
            height: 16px !important;
            max-width: 20px !important;
            max-height: 20px !important;
            display: inline-block !important;
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- Unified Admin Top Navigation Bar -->
    <header class="adm-navbar sticky-top py-2 px-3 px-lg-4">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap gap-2">
            
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                    <div class="rounded-3 p-2 d-flex align-items-center justify-content-center" style="background: var(--kg-accent-gradient);">
                        <i class="bi bi-shield-lock-fill text-white fs-4"></i>
                    </div>
                    <div>
                        <div class="fw-extrabold text-white fs-5 lh-1" style="letter-spacing: 0.5px;">ADMIN PANEL</div>
                        <small style="color: var(--kg-accent); font-weight: 700; letter-spacing: 1.5px; font-size: 0.72rem;">ARUNA COFFEE HOUSE</small>
                    </div>
                </a>

                <div class="vr mx-2 text-secondary d-none d-lg-block" style="height: 28px; opacity: 0.3;"></div>

                <!-- Nav links -->
                <nav class="d-none d-lg-flex align-items-center gap-1">
                    <a href="{{ route('admin.dashboard') }}" class="adm-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="adm-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="bi bi-cup-hot"></i> Kelola Menu
                    </a>
                    <a href="{{ route('admin.restocks.index') }}" class="adm-nav-link {{ request()->routeIs('admin.restocks.index') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i> Restok Kafe
                    </a>
                    <a href="{{ route('admin.restocks.requests') }}" class="adm-nav-link position-relative {{ request()->routeIs('admin.restocks.requests*') ? 'active' : '' }}">
                        <i class="bi bi-check2-circle"></i> Permintaan Restok
                        @php $pendingRequestsCount = \App\Models\RestockRequest::where('status', 'pending')->count(); @endphp
                        @if($pendingRequestsCount > 0)
                            <span class="badge bg-danger rounded-pill">{{ $pendingRequestsCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="adm-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="bi bi-receipt-cutoff"></i> Monitoring Penjualan
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="adm-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Staf & Akun
                    </a>
                </nav>
            </div>

            <!-- Right Actions -->
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('penjual.pos.index') }}" class="btn btn-kg-outline btn-sm rounded-pill px-3">
                    <i class="bi bi-calculator text-warning me-1"></i> Buka Kasir POS
                </a>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-kg-outline btn-sm rounded-pill px-3">
                    <i class="bi bi-globe me-1"></i> Lihat Web Kafe
                </a>

                <div class="dropdown">
                    <button class="btn btn-kg-accent btn-sm rounded-pill px-3 fw-bold dropdown-toggle d-flex align-items-center gap-2 shadow" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        <span>{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow border-0" style="background-color: var(--kg-surface); border: 1px solid var(--kg-border) !important;">
                        <li class="px-3 py-2 border-bottom text-muted small" style="border-color: var(--kg-border) !important;">
                            Role: <strong class="text-white">Administrator</strong>
                        </li>
                        <li><a class="dropdown-item py-2" href="{{ route('profile') }}"><i class="bi bi-person-badge me-2 text-warning"></i> Profil Saya</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger py-2 d-flex align-items-center gap-2">
                                    <i class="bi bi-box-arrow-right"></i> Keluar (Logout)
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

                <small class="text-muted">
                    Monitoring operasional Kopi Gerobakan
                </small>
            </div>

        </div>

        <!-- Mobile subnav -->
        <div class="d-flex d-lg-none overflow-auto py-2 gap-1 border-top mt-2" style="border-color: var(--kg-border) !important;">
            <a href="{{ route('admin.dashboard') }}" class="adm-nav-link py-1 px-3 small {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="adm-nav-link py-1 px-3 small {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">Menu</a>
            <a href="{{ route('admin.restocks.index') }}" class="adm-nav-link py-1 px-3 small {{ request()->routeIs('admin.restocks.index') ? 'active' : '' }}">Restok</a>
            <a href="{{ route('admin.restocks.requests') }}" class="adm-nav-link py-1 px-3 small {{ request()->routeIs('admin.restocks.requests*') ? 'active' : '' }}">Persetujuan</a>
            <a href="{{ route('admin.orders.index') }}" class="adm-nav-link py-1 px-3 small {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">Monitoring</a>
            <a href="{{ route('admin.users.index') }}" class="adm-nav-link py-1 px-3 small {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Pengguna</a>
        </div>
    </header>

    <!-- Content Area -->
    <div class="container-fluid px-3 px-lg-5 py-4">
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

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>