<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - BPSMB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            background: #f8fafc;
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>

<body>
    <!-- Backdrop for mobile -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
    <div class="d-flex">
        @include('admin.layouts.sidebar')
        <div class="content flex-grow-1" style="margin-left:250px;">
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
    <!-- Bootstrap JS & Icons -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarToggleMobile = document.getElementById('sidebarToggleMobile');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');
        const content = document.querySelector('.content');
        let isCollapsed = false;

        // Desktop toggle
        function toggleSidebar() {
            sidebar.classList.toggle('collapsed');
            isCollapsed = sidebar.classList.contains('collapsed');
            if (window.innerWidth >= 992) {
                content.style.marginLeft = isCollapsed ? '70px' : '250px';
            }
        }
        sidebarToggle && sidebarToggle.addEventListener('click', toggleSidebar);

        // Mobile toggle
        function openSidebarMobile() {
            sidebar.classList.add('open');
            sidebarBackdrop.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebarMobile() {
            sidebar.classList.remove('open');
            sidebarBackdrop.classList.remove('active');
            document.body.style.overflow = '';
        }
        sidebarToggleMobile && sidebarToggleMobile.addEventListener('click', openSidebarMobile);
        sidebarBackdrop && sidebarBackdrop.addEventListener('click', closeSidebarMobile);

        // Close sidebar on nav link click (mobile)
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992) closeSidebarMobile();
            });
        });

        // Responsive sidebar
        function handleResize() {
            if (window.innerWidth >= 992) {
                sidebar.classList.remove('open');
                sidebar.classList.remove('collapsed');
                sidebarBackdrop.classList.remove('active');
                content.style.marginLeft = '250px';
                document.body.style.overflow = '';
            } else {
                sidebar.classList.remove('collapsed');
                content.style.marginLeft = '0';
            }
        }
        window.addEventListener('resize', handleResize);
        window.addEventListener('DOMContentLoaded', handleResize);
    </script>
</body>

</html>
