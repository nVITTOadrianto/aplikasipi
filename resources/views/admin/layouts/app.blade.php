<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - BPSMB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            background: #f8fafc;
            font-family: 'Montserrat', sans-serif;
        }

        .sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            background: #afd8ff;
            border-right: 1px solid #e5e7eb;
            transition: all .3s;
            z-index: 1050;
        }

        .sidebar.collapsed {
            min-width: 70px;
            max-width: 70px;
            margin-left: 0;
        }

        .sidebar.collapsed .sidebar-label,
        .sidebar.collapsed .user-info,
        .sidebar.collapsed .sidebar-actions .dropdown-toggle::after,
        .sidebar.collapsed .bi-chevron-down {
            display: none !important;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
        }

        .sidebar.collapsed .sidebar-actions .dropdown-toggle {
            justify-content: center;
        }

        /* 1. Gaya untuk INDUK menu yang aktif (latar belakang sedikit menonjol) */
        .sidebar>.d-flex>.nav>.nav-item>.nav-link.active {
            background-color: #d0e7ff;
            /* Warna biru muda lembut */
            font-weight: 600;
            color: #0d6efd;
        }

        /* 2. Gaya untuk SUB-MENU yang aktif (latar belakang gelap dan lebih menonjol) */
        .sidebar .sidebar-submenu .nav-link.active {
            background-color: #0d6efd;
            /* Warna biru Bootstrap yang utama */
            color: #ffffff;
            /* Teks putih untuk kontras */
            font-weight: 600;
            border-radius: 0.375rem;
            /* Menambahkan sedikit lengkungan pada sudut */
        }


        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        /* Backdrop for mobile sidebar */
        .sidebar-backdrop {
            display: none;
        }

        /* Mobile Device */
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                z-index: 1050;
                top: 0;
                left: -250px;
                height: 100%;
                min-width: 250px;
                max-width: 250px;
                margin-left: 0;
                transition: left .3s;
            }

            .sidebar.open {
                left: 0;
            }

            .sidebar-backdrop.active {
                display: block;
                position: fixed;
                z-index: 1049;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.3);
            }

            .content {
                margin-left: 0 !important;
            }

            #sidebarToggle {
                display: none !important;
                /* margin-left: 0 */
            }

            #sidebarToggleMobile {
                display: inline-block !important;
            }
        }

        /* Desktop */
        @media (min-width: 992px) {
            .sidebar-backdrop {
                display: none !important;
            }

            #sidebarToggleMobile {
                display: none !important;
            }

            /* --- NEW: Fly-out menu styles for collapsed sidebar --- */
            .sidebar.collapsed .nav-item {
                position: relative;
            }

            .sidebar.collapsed .sidebar-submenu {
                position: absolute;
                left: 35px;
                /* Width of collapsed sidebar */
                top: 0;
                min-width: 220px;
                background: #fff;
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
                border-radius: 0 .25rem .25rem 0;
                padding: .5rem;
                display: none;
                /* Hidden by default */
                z-index: 1051;
            }

            .sidebar.collapsed .nav-item:hover>.sidebar-submenu {
                display: block;
                /* Show on hover */
            }

            /* Hide Bootstrap's active collapse when sidebar is collapsed */
            .sidebar.collapsed .collapse.show,
            .sidebar.collapsed .collapsing {
                display: none;
            }

            .sidebar.collapsed .sidebar-submenu .sidebar-label {
                display: inline-block !important;
            }
        }

        .sidebar-submenu-header {
            padding: .5rem 1rem;
            margin-bottom: .5rem;
            font-size: .875rem;
            color: #212529;
            border-bottom: 1px solid #e5e7eb;
        }

        /* Sembunyikan header ini saat sidebar tidak di-collapse (expanded) */
        .sidebar:not(.collapsed) .sidebar-submenu-header {
            display: none;
        }

        /* Hapus padding dari submenu agar header pas */
        .sidebar.collapsed .sidebar-submenu {
            padding: 0;
        }

        /* Beri padding pada item link di dalam flyout menu */
        .sidebar.collapsed .sidebar-submenu .nav-item {
            padding: 0 .5rem .5rem .5rem;
        }

        .sidebar.collapsed .sidebar-submenu .nav-item:first-of-type {
            padding-top: .5rem;
        }
    </style>
</head>

<body>
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
    <div class="d-flex">
        <nav id="sidebar" class="sidebar shadow-sm">
            <div class="d-flex flex-column h-100">
                <div class="d-flex align-items-center justify-content-between px-3   py-3 border-bottom">
                    <a class="navbar-brand sidebar-label" href="{{ route('home') }}">
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ asset('logo_horizontal.png') }}" alt="Logo" width="auto" height="40"
                                class="d-inline-block align-text-top">
                        </div>
                    </a>
                    <button class="btn" id="sidebarToggle" title="Toggle Sidebar">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                </div>

                <ul class="nav flex-column px-2 py-3 gap-1 flex-grow-1">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                            class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Dashboard">
                            <i class="bi bi-house-door fs-5"></i>
                            <span class="sidebar-label">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        @php
                            $isKoordinasiActive =
                                request()->routeIs('subkeg-1.surat-masuk.index') || request()->routeIs('subkeg-1.surat-keluar.index');
                        @endphp
                        <a href="#submenu-koordinasi" data-bs-toggle="collapse"
                            class="nav-link {{ $isKoordinasiActive ? 'active' : '' }}"
                            title="Koordinasi, Sinkronisasi, dan Pelaksanaan Pemberdayaan Industri dan Peran Serta Masyarakat">
                            <i class="bi bi-folder fs-5"></i>
                            <span class="sidebar-label">Koordinasi, Sinkronisasi...</span>
                            <i class="bi bi-chevron-down ms-auto sidebar-label"></i>
                        </a>
                        <ul id="submenu-koordinasi"
                            class="nav flex-column ms-3 collapse sidebar-submenu {{ $isKoordinasiActive ? 'show' : '' }}">
                            <li class="sidebar-submenu-header">
                                <span class="fw-semibold">Koordinasi & Sinkronisasi</span>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('subkeg-1.surat-masuk.index') }}"
                                    class="nav-link {{ request()->routeIs('subkeg-1.surat-masuk.index') ? 'active' : '' }}"
                                    title="Surat Masuk">
                                    <i class="bi bi-envelope-arrow-down"></i>
                                    <span class="sidebar-label">Surat Masuk</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('subkeg-1.surat-keluar.index') }}"
                                    class="nav-link {{ request()->routeIs('subkeg-1.surat-keluar.index') ? 'active' : '' }}"
                                    title="Surat Keluar">
                                    <i class="bi bi-envelope-arrow-up"></i>
                                    <span class="sidebar-label">Surat Keluar</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" title="Surat Lain-Lain">
                                    <i class="bi bi-envelope"></i>
                                    <span class="sidebar-label">Surat Lain-Lain</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        @php
                            $isLainLainActive = 
                                request()->routeIs('subkeg-lain.surat-masuk.index') || request()->routeIs('subkeg-lain.surat-keluar.index') || request()->routeIs('subkeg-lain.surat-lain.index');
                        @endphp
                        <a href="#submenu-lain" data-bs-toggle="collapse"
                            class="nav-link {{ $isLainLainActive ? 'active' : '' }}" title="Lain-Lain">
                            <i class="bi bi-collection fs-5"></i>
                            <span class="sidebar-label">Lain-Lain</span>
                            <i class="bi bi-chevron-down ms-auto sidebar-label"></i>
                        </a>
                        <ul id="submenu-lain"
                            class="nav flex-column ms-3 collapse sidebar-submenu {{ $isLainLainActive ? 'show' : '' }}">
                            <li class="sidebar-submenu-header">
                                <span class="fw-semibold">Lain-Lain</span>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('subkeg-lain.surat-masuk.index') }}"
                                    class="nav-link {{ request()->routeIs('subkeg-lain.surat-masuk.index') ? 'active' : '' }}"
                                    title="Surat Masuk">
                                    <i class="bi bi-envelope-arrow-down"></i>
                                    <span class="sidebar-label">Surat Masuk</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('subkeg-lain.surat-keluar.index') }}"
                                    class="nav-link {{ request()->routeIs('subkeg-lain.surat-keluar.index') ? 'active' : '' }}"
                                    title="Surat Keluar">
                                    <i class="bi bi-envelope-arrow-up"></i>
                                    <span class="sidebar-label">Surat Keluar</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('subkeg-lain.surat-lain.index')}}"
                                    class="nav-link {{ request()->routeIs('subkeg-lain.surat-lain.index') ? 'active' : '' }}"
                                    title="Surat Lain-Lain">
                                    <i class="bi bi-envelope"></i>
                                    <span class="sidebar-label">Surat Lain-Lain</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div class="border-top px-3 py-3 sidebar-actions">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                            id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="User"
                                class="rounded-circle" width="40" height="40">
                            <div class="user-info ms-2" style="min-width: 0; overflow: hidden;">
                                <div class="fw-semibold text-truncate" style="max-width: 120px;">
                                    {{ Auth::user()->name }}</div>
                                <div class="text-muted small text-truncate" style="max-width: 120px;">
                                    {{ Auth::user()->email }}</div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="content flex-grow-1" style="transition: margin-left .3s; margin-left: 250px;">
            <nav class="navbar navbar-light bg-white shadow-sm d-lg-none">
                <div class="container-fluid">
                    <button class="btn" id="sidebarToggleMobile">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <span class="fw-bold fs-5">Dashboard</span>
                    <span></span>
                </div>
            </nav>
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarToggleMobile = document.getElementById('sidebarToggleMobile');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');
        const content = document.querySelector('.content');

        // --- DESKTOP TOGGLE ---
        const toggleSidebar = () => {
            const isCollapsed = sidebar.classList.toggle('collapsed');
            // Close any open submenus when collapsing sidebar
            if (isCollapsed) {
                document.querySelectorAll('.sidebar-submenu.show').forEach(submenu => {
                    submenu.classList.remove('show');
                });
            }
            // Adjust content margin based on new sidebar width
            if (window.innerWidth >= 992) {
                content.style.marginLeft = sidebar.classList.contains('collapsed') ? '70px' : '250px';
            }
        };
        sidebarToggle?.addEventListener('click', toggleSidebar);

        // --- MOBILE TOGGLE ---
        const openSidebarMobile = () => {
            sidebar.classList.add('open');
            sidebarBackdrop.classList.add('active');
            document.body.style.overflow = 'hidden';
        };

        const closeSidebarMobile = () => {
            sidebar.classList.remove('open');
            sidebarBackdrop.classList.remove('active');
            document.body.style.overflow = '';
        };

        sidebarToggleMobile?.addEventListener('click', openSidebarMobile);
        sidebarBackdrop?.addEventListener('click', closeSidebarMobile);

        // --- Improved auto-close logic for mobile ---
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', (e) => {
                // Only close sidebar if the link is NOT a dropdown toggle
                if (!link.hasAttribute('data-bs-toggle')) {
                    if (window.innerWidth < 992) {
                        closeSidebarMobile();
                    }
                }
            });
        });

        // --- RESPONSIVE HANDLER (UPDATED) ---
        const handleResize = () => {
            const isDesktop = window.innerWidth >= 992;

            // NEW LOGIC: Remove collapsed state on mobile, handle desktop margin
            if (isDesktop) {
                // Set margin for desktop view
                content.style.marginLeft = sidebar.classList.contains('collapsed') ? '70px' : '250px';
                // Clean up mobile classes
                sidebar.classList.remove('open');
                sidebarBackdrop.classList.remove('active');
                document.body.style.overflow = '';
            } else {
                // Ensure sidebar is NEVER collapsed on mobile
                sidebar.classList.remove('collapsed');
                // Set margin for mobile view
                content.style.marginLeft = '0';
            }
        };

        window.addEventListener('resize', handleResize);

        // --- Initial check on load (UPDATED) ---
        document.addEventListener('DOMContentLoaded', () => {
            // Just call handleResize to set the correct initial state
            handleResize();
        });
    </script>
</body>

</html>
