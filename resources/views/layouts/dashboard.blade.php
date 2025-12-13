<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
    <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
    <meta name="author" content="CodedThemes">

    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">
    
    <!-- Modern Sidebar Styling -->
    <style>
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        @keyframes float-icon {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-3px); }
        }

        @keyframes slide-in-left {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .modern-sidebar {
            background: linear-gradient(135deg, #0f1419 0%, #1a1f2e 50%, #0f1419 100%);
            background-size: 200% 200%;
            animation: gradient-shift 15s ease infinite;
            width: 280px !important;
            border-right: 2px solid rgba(255, 107, 53, 0.2);
            box-shadow: 8px 0 32px rgba(255, 107, 53, 0.15);
            padding: 0;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1026;
            overflow: hidden;
        }

        .modern-sidebar .navbar-wrapper {
            display: none;
        }

        .sidebar-header {
            padding: 28px 20px;
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.15) 0%, rgba(255, 20, 147, 0.08) 100%);
            border-bottom: 2px solid rgba(255, 107, 53, 0.2);
            position: relative;
            overflow: hidden;
        }

        .sidebar-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
            animation: slide-in-left 3s ease-in-out infinite;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 2;
        }

        .logo-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #FF6B35 0%, #FF1493 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(255, 107, 53, 0.6), 0 0 20px rgba(255, 20, 147, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .logo-icon i {
            color: white;
            font-size: 1.8rem;
            animation: float-icon 3s ease-in-out infinite;
        }

        .logo-text h3 {
            color: white;
            font-weight: 900;
            font-size: 1.1rem;
            margin: 0;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 8px rgba(255, 107, 53, 0.3);
        }

        .logo-text p {
            color: #FF6B35;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .sidebar-body {
            flex: 1;
            overflow-y: auto;
            padding: 24px 0;
        }

        .navbar-content-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu-item {
            margin-bottom: 6px;
            animation: slide-in-left 0.5s ease-out forwards;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 20px;
            margin: 0 12px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 12px;
            border-left: 3px solid transparent;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
            position: relative;
            overflow: hidden;
        }

        .menu-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 107, 53, 0.15), transparent);
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }

        .menu-link:hover::before {
            transform: translateX(100%);
        }

        .menu-link:hover {
            background: rgba(255, 107, 53, 0.15);
            color: #FF6B35;
            transform: translateX(4px);
            box-shadow: -3px 0 12px rgba(255, 107, 53, 0.2);
        }

        .menu-item.active .menu-link {
            background: linear-gradient(90deg, rgba(255, 107, 53, 0.25) 0%, rgba(255, 107, 53, 0.1) 100%);
            color: #FF6B35;
            border-left-color: #FF6B35;
            box-shadow: -3px 0 16px rgba(255, 107, 53, 0.3), inset 2px 0 8px rgba(255, 107, 53, 0.15);
        }

        .menu-icon {
            width: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .menu-icon i {
            font-size: 1.2rem;
            color: #FF6B35;
            transition: all 0.4s ease;
        }

        .menu-link:hover .menu-icon i {
            transform: scale(1.2) rotate(5deg);
            color: #FF1493;
            filter: drop-shadow(0 0 8px rgba(255, 107, 53, 0.6));
        }

        .menu-text {
            font-weight: 500;
            font-size: 0.95rem;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 2px solid rgba(255, 107, 53, 0.15);
            background: rgba(0, 0, 0, 0.2);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slide-in-left 0.6s ease-out;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #FF6B35;
            object-fit: cover;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            color: rgba(255, 107, 53, 0.8);
            font-size: 0.75rem;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sidebar-body::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar-body::-webkit-scrollbar-track {
            background: rgba(255, 107, 53, 0.05);
            border-radius: 10px;
        }

        .sidebar-body::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #FF6B35, #FF1493);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 107, 53, 0.4);
        }

        .sidebar-body::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #FF1493, #FF69B4);
            box-shadow: 0 0 16px rgba(255, 107, 53, 0.6);
        }
    </style>
</head>
<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <!-- Pre-loader -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="pc-sidebar modern-sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <div class="logo-icon">
                    <i class="ti ti-school"></i>
                </div>
                <div class="logo-text">
                    <h3>PPDB</h3>
                    <p>SMK ANTARTIKA</p>
                </div>
            </div>
        </div>

        <div class="sidebar-body">
            <ul class="navbar-content-menu">
                <!-- Dashboard -->
                <li class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="/dashboard" class="menu-link">
                        <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>

                <!-- Formulir -->
                <li class="menu-item {{ request()->is('formulir*') ? 'active' : '' }}">
                    <a href="{{ route('formulir.index') }}" class="menu-link">
                        <span class="menu-icon"><i class="ti ti-file-text"></i></span>
                        <span class="menu-text">Isi Formulir</span>
                    </a>
                </li>

                <!-- Status -->
                <li class="menu-item {{ request()->is('status*') ? 'active' : '' }}">
                    <a href="{{ route('status.index') }}" class="menu-link">
                        <span class="menu-icon"><i class="ti ti-check-circle"></i></span>
                        <span class="menu-text">Status Pendaftaran</span>
                    </a>
                </li>

                <!-- Cetak -->
                <li class="menu-item {{ request()->is('cetak*') ? 'active' : '' }}">
                    <a href="{{ route('cetak.index') }}" class="menu-link">
                        <span class="menu-icon"><i class="ti ti-printer"></i></span>
                        <span class="menu-text">Cetak Kartu Ujian</span>
                    </a>
                </li>

                <!-- Pembayaran -->
                <li class="menu-item {{ request()->is('pembayaran*') ? 'active' : '' }}">
                    <a href="{{ route('user.pembayaran.index') }}" class="menu-link">
                        <span class="menu-icon"><i class="ti ti-credit-card"></i></span>
                        <span class="menu-text">Pembayaran</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <div class="user-profile">
                <img src="{{ $avatar }}" alt="User" class="user-avatar">
                <div class="user-info">
                    <p class="user-name">{{ $name }}</p>
                    <p class="user-role">{{ $role }}</p>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header Topbar -->
    <header class="pc-header">
        <div class="header-wrapper">
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="pc-h-item pc-sidebar-popup">
                        <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="dropdown pc-h-item d-inline-flex d-md-none">
                        <a class="pc-head-link dropdown-toggle arrow-none m-0" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ti ti-search"></i>
                        </a>
                        <div class="dropdown-menu pc-h-dropdown drp-search">
                            <form class="px-3">
                                <div class="form-group mb-0 d-flex align-items-center">
                                    <i data-feather="search"></i>
                                    <input type="search" class="form-control border-0 shadow-none"
                                        placeholder="Search here. . .">
                                </div>
                            </form>
                        </div>
                    </li>
                    <li class="pc-h-item d-none d-md-inline-flex">
                        <form class="header-search">
                            <i data-feather="search" class="icon-search"></i>
                            <input type="search" class="form-control" placeholder="Search here. . .">
                        </form>
                    </li>
                </ul>
            </div>

            <div class="ms-auto">
                <ul class="list-unstyled">
                    <li class="dropdown pc-h-item">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ti ti-mail"></i>
                        </a>
                        <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-header d-flex align-items-center justify-content-between">
                                <h5 class="m-0">Message</h5>
                                <a href="#!" class="pc-head-link bg-transparent"><i class="ti ti-x text-danger"></i></a>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-header px-0 text-wrap header-notification-scroll position-relative"
                                style="max-height: calc(100vh - 215px)">
                                <div class="list-group list-group-flush w-100">
                                    {{-- Contoh notifikasi --}}
                                    <a class="list-group-item list-group-item-action">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <img src="../assets/images/user/avatar-2.jpg" alt="user-image"
                                                    class="user-avtar">
                                            </div>
                                            <div class="flex-grow-1 ms-1">
                                                <span class="float-end text-muted">3:00 AM</span>
                                                <p class="text-body mb-1">It's <b>Cristina danny's</b> birthday today.</p>
                                                <span class="text-muted">2 min ago</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="text-center py-2">
                                <a href="#!" class="link-primary">View all</a>
                            </div>
                        </div>
                    </li>

                    <li class="dropdown pc-h-item header-user-profile">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside"
                            aria-expanded="false">
                            <img src="{{ $avatar }}" alt="user-image" class="user-avtar">
                            <span>{{ $name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-header">
                                <div class="d-flex mb-1 align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $avatar }}" alt="user-image"
                                            class="user-avtar wid-35">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">{{ $name }}</h6>
                                        <span>{{ $role }}</span>
                                    </div>
                                </div>
                            </div>
                            <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="drp-t1" data-bs-toggle="tab"
                                        data-bs-target="#drp-tab-1" type="button" role="tab"
                                        aria-controls="drp-tab-1" aria-selected="true"><i class="ti ti-user"></i>
                                        Profile</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="drp-t2" data-bs-toggle="tab"
                                        data-bs-target="#drp-tab-2" type="button" role="tab"
                                        aria-controls="drp-tab-2" aria-selected="false"><i
                                            class="ti ti-settings"></i> Setting</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="mysrpTabContent">
                                <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel"
                                    aria-labelledby="drp-t1" tabindex="0">
                                    <a href="/myprofile" class="dropdown-item">
                                        <i class="ti ti-user"></i>
                                        <span>My Profile</span>
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="ti ti-power"></i>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="drp-tab-2" role="tabpanel"
                                    aria-labelledby="drp-t2" tabindex="0">
                                    <a href="/contact-us" class="dropdown-item">
                                        <i class="ti ti-help"></i>
                                        <span>Support</span>
                                    </a>
                                    <a href="#!" class="dropdown-item">
                                        <i class="ti ti-user"></i>
                                        <span>Account Settings</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="pc-container">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <p class="text-center">© {{ date('Y') }} Your Company. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard-default.js') }}"></script>

    <script>
        layout_change('light');
        change_box_container('false');
        layout_rtl_change('false');
        preset_change("preset-1");
        font_change("Public-Sans");
        if (window.location.hash === '#_=_') history.replaceState(null, null, window.location.pathname);
    </script>
</body>
</html>
