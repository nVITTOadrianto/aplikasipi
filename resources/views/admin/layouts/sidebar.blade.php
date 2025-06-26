<style>
    .sidebar {
        min-width: 250px;
        max-width: 250px;
        min-height: 100vh;
        background: #afd8ff;
        border-right: 1px solid #e5e7eb;
        transition: all .2s;
        z-index: 1050;
    }

    .sidebar.collapsed {
        min-width: 70px;
        max-width: 70px;
        margin-left: 0;
    }

    .sidebar.collapsed .sidebar-label,
    .sidebar.collapsed .user-info,
    .sidebar.collapsed .sidebar-actions {
        display: none !important;
    }

    .sidebar.collapsed .nav-link {
        justify-content: center;
    }

    .sidebar .nav-link.active {
        background: #e9ecef;
        font-weight: 600;
    }

    .sidebar .nav-link {
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    /* Backdrop for mobile sidebar */
    .sidebar-backdrop {
        display: none;
    }

    .sidebar-mobile {
        position: fixed;
        left: -250px;
        top: 0;
        height: 100%;
        transition: left .2s;
        box-shadow: 2px 0 8px rgba(0, 0, 0, 0.08);
    }

    .sidebar-mobile.open {
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

    @media (max-width: 991.98px) {
        .sidebar {
            position: fixed;
            z-index: 1050;
            top: 0;
            left: 0;
            height: 100%;
            min-width: 250px;
            max-width: 250px;
            margin-left: 0;
            transition: left .2s;
        }

        .sidebar {
            left: -250px;
        }

        .sidebar.open {
            left: 0;
        }

        .content {
            margin-left: 0 !important;
        }

        #sidebarToggle {
            display: none !important;
        }

        #sidebarToggleMobile {
            display: inline-block !important;
        }
    }

    @media (min-width: 992px) {
        .sidebar-backdrop {
            display: none !important;
        }

        #sidebarToggleMobile {
            display: none !important;
        }
    }
</style>
<!-- Sidebar -->
<nav id="sidebar" class="sidebar shadow-sm">
    <div class="d-flex flex-column h-100">
        <div class="d-flex align-items-center justify-content-between px-3 py-3 border-bottom">
            <span class="fw-bold fs-5 sidebar-label">
                <a class="navbar-brand" href="{{ route('home')}}">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('logo_horizontal.png') }}" alt="Logo" width="auto" height="50"
                            class="d-inline-block align-text-top">
                    </div>
                </a>
            </span>
            <button class="btn d-none d-lg-inline" id="sidebarToggle" title="Toggle Sidebar">
                <i class="bi bi-list"></i>
            </button>
        </div>
        <ul class="nav flex-column px-2 py-3 gap-1 flex-grow-1">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Dashboard">
                    <i class="bi bi-house-door"></i>
                    <span class="sidebar-label">Dashboard</span>
                </a>
            </li>
        </ul>
        <div class="border-top px-3 py-3 sidebar-actions">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle user-info"
                    id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="User" class="rounded-circle me-2"
                        width="40" height="40">
                    <div>
                        <div class="fw-semibold">{{ Auth::user()->name }}</div>
                        <div class="text-muted small">{{ Auth::user()->email }}</div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-gear me-2"></i> Settings
                        </a>
                    </li>
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
