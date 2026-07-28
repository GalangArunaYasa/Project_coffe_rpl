<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kopi Gerobakan')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --kg-bg: #0d0b0a;
            --kg-surface: #171310;
            --kg-surface-light: #201a16;
            --kg-border: #2c241f;
            --kg-accent: #c0783f;
            --kg-accent-hover: #a8652f;
            --kg-text-muted: #a89c92;
        }

        body {
            background-color: var(--kg-bg);
            color: #f5f0ec;
        }

        /* Sidebar */
        .kg-sidebar {
            width: 250px;
            background-color: var(--kg-surface);
            border-right: 1px solid var(--kg-border);
            min-height: 100vh;
        }

        .kg-sidebar .nav-link {
            color: var(--kg-text-muted);
        }

        .kg-sidebar .nav-link.active,
        .kg-sidebar .nav-link:hover {
            background-color: var(--kg-accent);
            color: #fff;
        }

        .kg-topbar {
            background-color: var(--kg-bg);
            border-bottom: 1px solid var(--kg-border);
        }

        .kg-search-input {
            background-color: var(--kg-surface-light);
            border: 1px solid var(--kg-border);
            color: #f5f0ec;
        }

        .kg-search-input::placeholder {
            color: var(--kg-text-muted);
        }

        .kg-search-input:focus {
            background-color: var(--kg-surface-light);
            color: #f5f0ec;
            border-color: var(--kg-accent);
            box-shadow: 0 0 0 0.2rem rgba(192, 120, 63, 0.25);
        }

        .btn-kg-accent {
            background-color: var(--kg-accent);
            border-color: var(--kg-accent);
            color: #fff;
        }

        .btn-kg-accent:hover {
            background-color: var(--kg-accent-hover);
            border-color: var(--kg-accent-hover);
            color: #fff;
        }

        .kg-card {
            background-color: var(--kg-surface);
            border: 1px solid var(--kg-border);
        }
    </style>

    @stack('styles')
</head>
<body>

    <div class="d-flex">

        <!-- Sidebar (Desktop) -->
        <aside class="kg-sidebar d-none d-lg-flex flex-column p-3 position-sticky top-0" style="height: 100vh;">
            <a href="{{ url('/') }}" class="d-flex align-items-center gap-2 text-decoration-none mb-4 px-2">
                <i class="bi bi-cup-hot-fill fs-3" style="color: var(--kg-accent);"></i>
                <div>
                    <div class="fw-bold text-white lh-1">KOPI</div>
                    <small class="text-muted">GEROBAKAN</small>
                </div>
            </a>

            <ul class="nav nav-pills flex-column gap-1 mb-auto">
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link d-flex align-items-center gap-2 rounded-3">
                        <i class="bi bi-house-door"></i> Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/menu') }}" class="nav-link d-flex align-items-center gap-2 rounded-3">
                        <i class="bi bi-grid"></i> Menu
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/payment') }}" class="nav-link d-flex align-items-center gap-2 rounded-3">
                        <i class="bi bi-bag"></i> Payment
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/riwayat') }}" class="nav-link d-flex align-items-center gap-2 rounded-3">
                        <i class="bi bi-clock-history"></i> Riwayat
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/lokasi') }}" class="nav-link d-flex align-items-center gap-2 rounded-3">
                        <i class="bi bi-geo-alt"></i> Lokasi Kami
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/tentang') }}" class="nav-link d-flex align-items-center gap-2 rounded-3">
                        <i class="bi bi-info-circle"></i> Tentang Kami
                    </a>
                </li>
            </ul>

            <small class="text-muted px-2">&copy; {{ date('Y') }} Kopi Gerobakan.<br>Semua hak dilindungi.</small>
        </aside>

        <!-- Sidebar (Mobile / Offcanvas) -->
        <div class="offcanvas offcanvas-start kg-sidebar" tabindex="-1" id="kgSidebarOffcanvas">
            <div class="offcanvas-header">
                <a href="{{ url('/') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                    <i class="bi bi-cup-hot-fill fs-4" style="color: var(--kg-accent);"></i>
                    <div>
                        <div class="fw-bold text-white lh-1">KOPI</div>
                        <small class="text-muted">GEROBAKAN</small>
                    </div>
                </a>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column">
                <ul class="nav nav-pills flex-column gap-1 mb-auto">
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link d-flex align-items-center gap-2 rounded-3 active">
                            <i class="bi bi-house-door"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/menu') }}" class="nav-link d-flex align-items-center gap-2 rounded-3">
                            <i class="bi bi-grid"></i> Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/payment') }}" class="nav-link d-flex align-items-center gap-2 rounded-3">
                            <i class="bi bi-bag"></i> Payment
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/riwayat') }}" class="nav-link d-flex align-items-center gap-2 rounded-3">
                            <i class="bi bi-clock-history"></i> Riwayat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/lokasi') }}" class="nav-link d-flex align-items-center gap-2 rounded-3">
                            <i class="bi bi-geo-alt"></i> Lokasi Kami
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/tentang') }}" class="nav-link d-flex align-items-center gap-2 rounded-3">
                            <i class="bi bi-info-circle"></i> Tentang Kami
                        </a>
                    </li>
                </ul>
                <small class="text-muted">&copy; {{ date('Y') }} Kopi Gerobakan.<br>Semua hak dilindungi.</small>
            </div>
        </div>

        <!-- Main Content Wrapper -->
        <div class="flex-grow-1 d-flex flex-column" style="min-width: 0;">

            <!-- Topbar -->
            <header class="kg-topbar sticky-top">
                <div class="container-fluid py-3">
                    <div class="d-flex align-items-center gap-3 flex-wrap justify-content-between">

                        <!-- Mobile toggler + Search -->
                        <div class="d-flex align-items-center gap-2 flex-grow-1" style="max-width: 500px;">
                            <button class="btn btn-outline-secondary d-lg-none rounded-3" type="button"
                                    data-bs-toggle="offcanvas" data-bs-target="#kgSidebarOffcanvas">
                                <i class="bi bi-list fs-5"></i>
                            </button>

                            <div class="input-group">
                                <span class="input-group-text kg-search-input border-end-0 rounded-start-3">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control kg-search-input border-start-0 rounded-end-3"
                                       placeholder="Cari menu kopi favoritmu...">
                            </div>
                        </div>

                        <!-- Cart & Auth -->
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ url('/cart') }}" class="position-relative text-white fs-5 text-decoration-none">
                                <i class="bi bi-cart3"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill btn-kg-accent">
                                    2
                                </span>
                            </a>
                            <a href="{{ url('/login') }}" class="btn btn-kg-accent rounded-3 px-4 fw-semibold">
                                Masuk / Daftar
                            </a>
                        </div>

                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-grow-1">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="border-top py-4 mt-auto" style="border-color: var(--kg-border) !important;">
                <div class="container-fluid text-center">
                    <small class="text-muted">&copy; {{ date('Y') }} Kopi Gerobakan. Semua hak dilindungi.</small>
                </div>
            </footer>

        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
