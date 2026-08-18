<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Dashboard - Kopi Gerobakan')</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700;9..144,900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">

    <style>
        :root {
            --kg-espresso: #2B1B12;
            --kg-espresso-soft: #43301F;
            --kg-paper: #F6ECD9;
            --kg-paper-card: #FFFBF3;
            --kg-gold: #E7A33E;
            --kg-gold-deep: #C9812A;
            --kg-brick: #A63D2F;
            --kg-olive: #6B7A4F;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--kg-paper);
            color: var(--kg-espresso);
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Fraunces', serif;
        }

        .admin-wrapper {
            min-height: 100vh;
            display: flex;
        }

        /* SIDEBAR */
        .admin-sidebar {
            width: 250px;
            min-height: 100vh;
            background: var(--kg-espresso);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            padding: 24px 16px;
            z-index: 1000;
        }

        .brand {
            font-family: 'Fraunces', serif;
            font-size: 1.45rem;
            font-weight: 900;
            color: var(--kg-paper-card);
            padding: 8px 12px 25px;
        }

        .brand span {
            color: var(--kg-gold);
        }

        .menu-label {
            color: rgba(255,255,255,.45);
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .12em;
            margin: 12px 12px 8px;
        }

        .admin-menu {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .admin-menu a {
            text-decoration: none;
            color: rgba(255,255,255,.78);
            padding: 11px 13px;
            border-radius: 10px;
            font-size: .87rem;
            font-weight: 600;
            transition: .2s;
        }

        .admin-menu a i {
            margin-right: 10px;
        }

        .admin-menu a:hover,
        .admin-menu a.active {
            background: rgba(231,163,62,.14);
            color: var(--kg-gold);
        }

        .admin-promo {
            position: absolute;
            bottom: 20px;
            left: 16px;
            right: 16px;
            background: var(--kg-espresso-soft);
            border: 1px solid rgba(246,236,217,.12);
            border-radius: 16px;
            padding: 15px;
        }

        .admin-promo small {
            color: rgba(255,255,255,.6);
        }

        /* MAIN */
        .admin-main {
            margin-left: 250px;
            width: calc(100% - 250px);
            min-height: 100vh;
        }

        .admin-navbar {
            height: 76px;
            background: var(--kg-paper-card);
            border-bottom: 1px solid rgba(43,27,18,.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--kg-gold);
            color: var(--kg-espresso);
            font-weight: 800;
        }

        .admin-content {
            padding: 30px;
        }

        /* STAT CARD */
        .stat-card {
            background: var(--kg-paper-card);
            border: 1px solid rgba(43,27,18,.08);
            border-radius: 18px;
            padding: 20px;
            height: 100%;
            box-shadow: 0 12px 28px -20px rgba(43,27,18,.3);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .stat-number {
            font-family: 'Fraunces', serif;
            font-size: 2rem;
            font-weight: 900;
        }

        /* CONTENT CARD */
        .content-card {
            background: var(--kg-paper-card);
            border: 1px solid rgba(43,27,18,.08);
            border-radius: 18px;
            overflow: hidden;
        }

        .content-card-header {
            padding: 20px;
            border-bottom: 1px solid rgba(43,27,18,.08);
        }

        /* TABLE */
        .table > :not(caption) > * > * {
            background: transparent;
            border-color: rgba(43,27,18,.08);
            padding: 15px 20px;
        }

        .employee-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--kg-espresso);
            color: var(--kg-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            display: inline-block;
            border-radius: 50%;
            margin-right: 6px;
        }

        .status-active {
            background: #6B7A4F;
        }

        .status-offline {
            background: #9A9A9A;
        }

        .status-permission {
            background: var(--kg-gold);
        }

        .activity-item {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(43,27,18,.07);
        }

        .activity-item:last-child {
            border-bottom: 0;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(231,163,62,.14);
            color: var(--kg-gold-deep);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-kg-primary {
            background: var(--kg-gold);
            border: none;
            color: var(--kg-espresso);
            font-weight: 700;
        }

        .btn-kg-primary:hover {
            background: #f0b458;
            color: var(--kg-espresso);
        }

        @media (max-width: 991px) {
            .admin-sidebar {
                width: 220px;
            }

            .admin-main {
                margin-left: 220px;
                width: calc(100% - 220px);
            }

            .admin-content {
                padding: 20px;
            }
        }

        @media (max-width: 767px) {
            .admin-sidebar {
                display: none;
            }

            .admin-main {
                margin-left: 0;
                width: 100%;
            }

            .admin-navbar {
                padding: 0 15px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<div class="admin-wrapper">

    {{-- SIDEBAR --}}
    <aside class="admin-sidebar">

        <div class="brand">
            ☕ KOPI <span>GEROBAKAN</span>
        </div>

        <div class="menu-label">
            Monitoring
        </div>

        <div class="admin-menu">

            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                Dashboard
            </a>
            <a href="{{ route('admin.karyawan.index') }}"
            class="{{ request()->routeIs('admin.karyawan.*') ? 'active' : '' }}">

                <i class="bi bi-people-fill"></i>
                Karyawan

            </a>

            <a href="#">
                <i class="bi bi-calendar-check-fill"></i>
                Absensi
            </a>

            <a href="#">
                <i class="bi bi-activity"></i>
                Aktivitas
            </a>

        </div>

        <div class="menu-label mt-4">
            Operasional
        </div>

        <div class="admin-menu">

            <a href="#">
                <i class="bi bi-cup-hot-fill"></i>
                Produk
            </a>

            <a href="#">
                <i class="bi bi-box-seam-fill"></i>
                Stok
            </a>

            <a href="#">
                <i class="bi bi-bag-check-fill"></i>
                Pesanan
            </a>

        </div>

        <div class="menu-label mt-4">
            Lainnya
        </div>

        <div class="admin-menu">

            <a href="{{ url('/') }}" target="_blank">
                <i class="bi bi-globe2"></i>
                Lihat Website
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit"
                        class="w-100 text-start border-0"
                        style="
                            background: transparent;
                            color: rgba(255,255,255,.78);
                            padding: 11px 13px;
                            border-radius: 10px;
                            font-size: .87rem;
                            font-weight: 600;
                        ">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Logout
                </button>
            </form>

        </div>

        <div class="admin-promo">
            <small>Panel Admin</small>

            <div class="fw-bold mt-1">
                Aruna Coffee
            </div>

            <div class="small mt-2"
                 style="color: rgba(255,255,255,.55);">
                Kelola operasional gerobak dengan lebih mudah.
            </div>
        </div>

    </aside>

    {{-- MAIN --}}
    <main class="admin-main">

        <nav class="admin-navbar">

            <div>
                <div class="fw-bold">
                    Admin Dashboard
                </div>

                <small class="text-muted">
                    Monitoring operasional Kopi Gerobakan
                </small>
            </div>

            <div class="admin-user">

                <div class="text-end d-none d-sm-block">
                    <div class="fw-semibold small">
                        {{ Auth::user()->name ?? 'Admin' }}
                    </div>

                    <small class="text-muted">
                        Administrator
                    </small>
                </div>

                <div class="admin-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>

            </div>

        </nav>

        <section class="admin-content">
            @yield('content')
        </section>

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>