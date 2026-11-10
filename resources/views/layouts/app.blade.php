<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Manajemen Data Pegawai') - SIMPEG</title>

    <!-- Bootstrap 5 CSS Lokal (Bekerja 100% Offline Tanpa Internet) -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --bg-light: #f8fafc;
            --card-border: #e2e8f0;
            --sidebar-bg: #0f172a;
            --sidebar-active: #2563eb;
        }

        body {
            background-color: var(--bg-light);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #1e293b;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Layout Sidebar & Wrapper */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            color: #f8fafc;
            flex-shrink: 0;
            z-index: 1045;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand h5 {
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 0.2rem;
            color: #ffffff;
        }

        .sidebar-menu {
            padding: 1.25rem 0.85rem;
            flex-grow: 1;
        }

        .menu-header {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            color: #64748b;
            padding: 0.5rem 0.75rem;
            margin-top: 0.5rem;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #94a3b8;
            font-weight: 500;
            font-size: 0.92rem;
            border-radius: 8px;
            margin-bottom: 0.35rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .sidebar .nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.08);
            transform: translateX(3px);
        }

        .sidebar .nav-link.active {
            color: #ffffff;
            background: var(--sidebar-active);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
            font-weight: 600;
        }

        .sidebar .nav-link svg {
            flex-shrink: 0;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.2);
            font-size: 0.8rem;
        }

        /* Area Konten Utama */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            background-color: var(--bg-light);
        }

        /* Topbar Header */
        .topbar {
            background-color: #ffffff;
            border-bottom: 1px solid var(--card-border);
            padding: 0.85rem 1.75rem;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        /* Card and Elements */
        .main-card {
            background: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .stat-card {
            border-left: 4px solid var(--primary-color);
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 1.25rem;
        }

        .stat-card.blue { border-left-color: #3b82f6; }
        .stat-card.green { border-left-color: #10b981; }
        .stat-card.purple { border-left-color: #8b5cf6; }
        .stat-card.amber { border-left-color: #f59e0b; }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.2;
            color: #0f172a;
        }

        .stat-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: #64748b;
        }

        .chart-container {
            position: relative;
            min-height: 280px;
            width: 100%;
        }

        .table thead th {
            background-color: #f8fafc;
            color: #334155;
            font-weight: 600;
            border-bottom: 2px solid #cbd5e1;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            vertical-align: middle;
            color: #334155;
        }

        .badge-gender-laki {
            background-color: #dbeafe;
            color: #1e40af;
            font-weight: 500;
            padding: 0.4em 0.75em;
            border-radius: 6px;
        }

        .badge-gender-perempuan {
            background-color: #fce7f3;
            color: #9d174d;
            font-weight: 500;
            padding: 0.4em 0.75em;
            border-radius: 6px;
        }

        .badge-pendidikan {
            background-color: #f1f5f9;
            color: #334155;
            border: 1px solid #cbd5e1;
            font-weight: 500;
            padding: 0.35em 0.65em;
            border-radius: 6px;
        }

        .footer {
            margin-top: auto;
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 1.25rem 0;
            color: #64748b;
            font-size: 0.85rem;
        }

        .btn-primary {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }

        /* Responsif Sidebar pada layar besar vs kecil */
        @media (min-width: 992px) {
            .sidebar {
                position: sticky;
                top: 0;
                height: 100vh;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="app-wrapper">
        <!-- ============================================== -->
        <!-- SIDEBAR NAVIGASI UTAMA (RESPONSIF BOOTSTRAP 5) -->
        <!-- ============================================== -->
        <aside class="offcanvas-lg offcanvas-start sidebar" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
            <!-- Brand & Logo -->
            <div class="sidebar-brand d-flex align-items-center justify-content-between">
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                    <div class="bg-primary rounded p-2 d-flex align-items-center justify-content-center text-white shadow-sm">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <div>
                        <h5 class="mb-0">SIMPEG</h5>
                        <small class="text-white-50" style="font-size: 0.72rem;">Manajemen Data Pegawai</small>
                    </div>
                </a>
                <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Tutup"></button>
            </div>

            <!-- Menu Sidebar -->
            <div class="sidebar-menu">
                <div class="menu-header">Menu Utama</div>

                <!-- 1. Menu Dashboard -->
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard*') || request()->is('/') ? 'active' : '' }}">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="9"></rect>
                        <rect x="14" y="3" width="7" height="5"></rect>
                        <rect x="14" y="12" width="7" height="9"></rect>
                        <rect x="3" y="16" width="7" height="5"></rect>
                    </svg>
                    <span>Dashboard Statistik</span>
                </a>

                <!-- 2. Menu Daftar Pegawai -->
                <a href="{{ route('pegawai.index') }}" class="nav-link {{ request()->routeIs('pegawai.index') || request()->routeIs('pegawai.show') || request()->routeIs('pegawai.edit') ? 'active' : '' }}">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span>Daftar Pegawai</span>
                </a>

                <!-- 3. Menu Tambah Pegawai -->
                <a href="{{ route('pegawai.create') }}" class="nav-link {{ request()->routeIs('pegawai.create') ? 'active' : '' }}">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Tambah Pegawai</span>
                </a>

                <div class="menu-header mt-3">Sistem & Database</div>
                <div class="px-3 py-2 bg-dark bg-opacity-25 rounded text-white-50" style="font-size: 0.78rem;">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="d-inline-block rounded-circle bg-success" style="width: 8px; height: 8px;"></span>
                        <span class="text-white fw-semibold">SQLite Aktif</span>
                    </div>
                    <div>Modul: Junior Web Programming</div>
                </div>
            </div>

            <!-- Footer Sidebar -->
            <div class="sidebar-footer text-muted">
                <div class="d-flex align-items-center justify-content-between">
                    <span>Versi Aplikasi</span>
                    <span class="badge bg-secondary">v1.0</span>
                </div>
            </div>
        </aside>

        <!-- ============================================== -->
        <!-- KONTEN UTAMA DAN HEADER TOPBAR                 -->
        <!-- ============================================== -->
        <div class="main-content">
            <!-- Topbar Sticky Header -->
            <header class="topbar d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <!-- Tombol Toggle Sidebar untuk Mobile / Layar Kecil -->
                    <button class="btn btn-outline-secondary d-lg-none p-1 px-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>

                    <div class="d-none d-sm-block">
                        <span class="text-muted small">Sistem Informasi Manajemen Pegawai</span>
                        <div class="fw-bold text-dark fs-6">Panel Administrator</div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('pegawai.create') }}" class="btn btn-sm btn-primary d-flex align-items-center gap-1 shadow-sm px-3 py-2">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        <span class="fw-semibold">Tambah Pegawai</span>
                    </a>
                </div>
            </header>

            <!-- Bagian Konten Dinamis -->
            <main class="container-fluid px-3 px-md-4 py-4 flex-grow-1">
                <!-- Flash Alert Notifikasi -->
                @if (session('sukses'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm border-0 mb-4" role="alert">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-success flex-shrink-0">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <div>{{ session('sukses') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm border-0 mb-4" role="alert">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-danger flex-shrink-0">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer Aplikasi -->
            <footer class="footer text-center px-4">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-md-start mb-2 mb-md-0">
                            <strong>Sistem Informasi Manajemen Pegawai (SIMPEG)</strong> &copy; {{ date('Y') }}
                        </div>
                        <div class="col-md-6 text-md-end">
                            <span class="badge bg-secondary-subtle text-secondary border">Junior Web Programming (100 Menit)</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS Lokal (Offline) -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <!-- Chart.js Lokal (Offline) -->
    <script src="{{ asset('js/chart.umd.min.js') }}"></script>

    @stack('scripts')
</body>
</html>
