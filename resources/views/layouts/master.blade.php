<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PPDB SMK ANTARTIKA 1') - SMK ANTARTIKA 1 SIDOARJO</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Custom theme additions -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom-theme.css') }}">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
        }
        
        :root {
            --primary: #4f46e5;
            --primary-light: #6366f1;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #0ea5e9;
            --dark: #1f2937;
            --light: #f9fafb;
            --gray: #6b7280;
        }
        
        body {
            background-color: var(--light);
            color: var(--dark);
            min-height: 100vh;
        }
        
        /* SIDEBAR STYLING */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .sidebar-brand {
            padding: 20px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            color: white;
            transition: 0.3s;
        }
        
        .sidebar-brand:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-brand i {
            font-size: 24px;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 10px 0;
            margin: 0;
        }
        
        .sidebar-menu-item {
            margin: 0;
        }
        
        .sidebar-menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .sidebar-menu-link:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding-left: 30px;
        }
        
        .sidebar-menu-link.active {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            border-right: 4px solid white;
            padding-left: 20px;
        }
        
        .sidebar-menu-link i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }
        
        .sidebar-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
            margin: 15px 0;
        }

        .sidebar-section-title {
            padding: 12px 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 10px;
        }
        
        /* NAVBAR STYLING */
        .navbar-custom {
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 15px 30px;
            margin-left: 250px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .navbar-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }
        
        .navbar-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        
        .navbar-user-name {
            color: var(--dark);
            font-weight: 600;
            font-size: 14px;
        }
        
        /* MAIN CONTENT AREA */
        .main-content {
            margin-left: 250px;
            padding: 30px;
        }
        
        .page-header {
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }
        
        .page-subtitle {
            font-size: 14px;
            color: var(--gray);
        }
        
        /* CARDS STYLING */
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s;
        }
        
        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }
        
        .card-header {
            background: white;
            border-bottom: 2px solid var(--light);
            padding: 20px;
            font-weight: 600;
            color: var(--dark);
        }
        
        .card-body {
            padding: 20px;
        }
        
        /* STAT CARD */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-left: 4px solid;
            transition: all 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
        }
        
        .stat-card.primary {
            border-left-color: var(--primary);
        }
        
        .stat-card.success {
            border-left-color: var(--success);
        }
        
        .stat-card.danger {
            border-left-color: var(--danger);
        }
        
        .stat-card.warning {
            border-left-color: var(--warning);
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
        }
        
        .stat-label {
            font-size: 13px;
            color: var(--gray);
            font-weight: 500;
            margin-top: 5px;
        }
        
        .stat-icon {
            font-size: 40px;
            opacity: 0.15;
        }
        
        .stat-icon.primary {
            color: var(--primary);
        }
        
        .stat-icon.success {
            color: var(--success);
        }
        
        .stat-icon.danger {
            color: var(--danger);
        }
        
        .stat-icon.warning {
            color: var(--warning);
        }
        
        /* BADGE STYLING */
        .badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-primary {
            background: rgba(79, 70, 229, 0.15);
            color: var(--primary);
        }
        
        .badge-success {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
        }
        
        .badge-danger {
            background: rgba(239, 68, 68, 0.15);
            color: var(--danger);
        }
        
        .badge-warning {
            background: rgba(245, 158, 11, 0.15);
            color: var(--warning);
        }
        
        /* BUTTON STYLING */
        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 16px;
            font-size: 14px;
            transition: all 0.3s;
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(79, 70, 229, 0.3);
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        /* TABLE STYLING */
        .table {
            color: var(--dark);
        }
        
        .table thead th {
            background: var(--light);
            border: none;
            font-weight: 600;
            font-size: 13px;
            color: var(--gray);
            text-transform: uppercase;
            padding: 15px;
        }
        
        .table tbody td {
            padding: 15px;
            border-bottom: 1px solid var(--light);
            vertical-align: middle;
        }
        
        .table tbody tr:hover {
            background: var(--light);
        }
        
        /* FORM STYLING */
        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-control {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        /* ALERT STYLING */
        .alert {
            border-radius: 8px;
            border: none;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }
        
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }
        
        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }
        
        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                margin-left: -250px;
                transition: all 0.3s;
            }
            
            .sidebar.active {
                width: 250px;
                margin-left: 0;
            }
            
            .navbar-custom {
                margin-left: 0;
            }
            
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            
            .page-title {
                font-size: 20px;
            }
            
            .stat-card {
                flex-direction: column;
                text-align: center;
            }
            
            .stat-icon {
                order: -1;
                margin-bottom: 10px;
            }
        }
        
        /* PRINT STYLING */
        @media print {
            .sidebar, .navbar-custom, .btn, .d-print-none {
                display: none !important;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    
    @yield('extra_css')
</head>
<body>
    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <a href="@if(Auth::user()?->hasRole('admin')){{ route('admin.dashboard') }}@else{{ route('dashboard') }}@endif" class="sidebar-brand">
            <i class="fas fa-graduation-cap"></i>
            <span>PPDB</span>
        </a>
        
        <ul class="sidebar-menu">
            @if(Auth::check())
                <!-- Dashboard -->
                <li class="sidebar-menu-item">
                    <a href="@if(Auth::user()->hasRole('admin')){{ route('admin.dashboard') }}@else{{ route('dashboard') }}@endif" class="sidebar-menu-link @if(Auth::user()->hasRole('admin') && request()->routeIs('admin.dashboard'))active @elseif(!Auth::user()->hasRole('admin') && request()->routeIs('dashboard'))active @endif">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @if(Auth::user()->hasRole('admin'))
                    <!-- ADMIN SECTION -->
                    <div class="sidebar-divider"></div>
                    <div class="sidebar-section-title">
                        <i class="fas fa-lock-open" style="margin-right: 6px; opacity: 0.7;"></i>Admin Tools
                    </div>

                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.siswa.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.siswa*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Daftar Siswa</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.verifikasi') }}" class="sidebar-menu-link {{ request()->routeIs('admin.verifikasi*') ? 'active' : '' }}">
                            <i class="fas fa-check-circle"></i>
                            <span>Verifikasi Dokumen</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.gelombang.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.gelombang*') ? 'active' : '' }}">
                            <i class="fas fa-wave-square"></i>
                            <span>Atur Gelombang</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.jurusan.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.jurusan*') ? 'active' : '' }}">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Atur Jurusan</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.pembayaran.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.pembayaran*') ? 'active' : '' }}">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Kelola Pembayaran</span>
                        </a>
                    </li>

                    <div class="sidebar-divider"></div>

                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.jenis-dokumen.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.jenis-dokumen*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt"></i>
                            <span>Jenis Dokumen</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.reports.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                            <i class="fas fa-file-download"></i>
                            <span>Laporan & Eksport</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.peran.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.peran*') ? 'active' : '' }}">
                            <i class="fas fa-users-cog"></i>
                            <span>Manajemen Peran</span>
                        </a>
                    </li>
                @elseif(Auth::user()->hasRole('user'))
                    <!-- USER SECTION -->
                    <div class="sidebar-divider"></div>
                    <div class="sidebar-section-title">
                        <i class="fas fa-pencil-alt" style="margin-right: 6px; opacity: 0.7;"></i>Aplikasi
                    </div>

                    <li class="sidebar-menu-item">
                        <a href="{{ route('formulir.index') }}" class="sidebar-menu-link {{ request()->routeIs('formulir*') ? 'active' : '' }}">
                            <i class="fas fa-edit"></i>
                            <span>Isi Formulir</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('biodata.index') }}" class="sidebar-menu-link {{ request()->routeIs('biodata.*') ? 'active' : '' }}">
                            <i class="fas fa-user-circle"></i>
                            <span>Biodata</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('user.dokumen') }}" class="sidebar-menu-link {{ request()->routeIs('user.dokumen*') || request()->routeIs('dokumen.*') ? 'active' : '' }}">
                            <i class="fas fa-folder"></i>
                            <span>Dokumen</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('cetak.index') }}" class="sidebar-menu-link {{ request()->routeIs('cetak.*') ? 'active' : '' }}">
                            <i class="fas fa-id-card"></i>
                            <span>Cetak Kartu</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('user.pembayaran.index') }}" class="sidebar-menu-link {{ request()->routeIs('user.pembayaran*') ? 'active' : '' }}">
                            <i class="fas fa-credit-card"></i>
                            <span>Pembayaran</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('user.status') }}" class="sidebar-menu-link {{ request()->routeIs('user.status') ? 'active' : '' }}">
                            <i class="fas fa-info-circle"></i>
                            <span>Status</span>
                        </a>
                    </li>
                @endif

                <!-- ACCOUNT SECTION -->
                <div class="sidebar-divider"></div>
                <div class="sidebar-section-title">
                    <i class="fas fa-user" style="margin-right: 6px; opacity: 0.7;"></i>Akun
                </div>

                <li class="sidebar-menu-item">
                    <a href="{{ route('profil.index') }}" class="sidebar-menu-link {{ request()->routeIs('profil.index') ? 'active' : '' }}">
                        <i class="fas fa-user-circle"></i>
                        <span>Profil</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="sidebar-menu-link w-100 border-0 bg-transparent text-start">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            @endif
        </ul>
    </div>
    
    <!-- NAVBAR -->
    <div class="navbar-custom">
        <button class="btn btn-link d-md-none" onclick="toggleSidebar()">
            <i class="fas fa-bars fa-lg"></i>
        </button>
        
        <h6 class="navbar-title">@yield('page_title', 'Dashboard')</h6>
        
        <div class="navbar-user">
            @if(Auth::check())
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="navbar-user-name">{{ Auth::user()->name }}</div>
                    <small class="text-muted">{{ Auth::user()->email }}</small>
                </div>
            @endif
        </div>
    </div>
    
    <!-- MAIN CONTENT -->
    <div class="main-content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Terjadi kesalahan!</strong>
                    <ul class="mb-0 mt-2" style="font-size: 12px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        @endif
        
        @if (session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-times-circle"></i>
                <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif
        
        @yield('content')
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <!-- SweetAlert2 Helper Functions -->
    <script src="{{ asset('assets/js/sweetalert-helpers.js') }}"></script>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
        
        // Close sidebar when clicking on content
        document.querySelector('.main-content').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth < 768) {
                sidebar.classList.remove('active');
            }
        });
        
        // Filter input number fields - hanya angka
        document.addEventListener('DOMContentLoaded', function() {
            // Fields yang hanya boleh berisi angka
            const numericFields = ['nomor_rekening', 'no_hp_wali'];
            
            numericFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    // Filter saat input
                    field.addEventListener('input', function(e) {
                        this.value = this.value.replace(/[^0-9]/g, '');
                    });
                    
                    // Cegah paste non-numeric
                    field.addEventListener('paste', function(e) {
                        e.preventDefault();
                        const text = (e.clipboardData || window.clipboardData).getData('text');
                        const numbersOnly = text.replace(/[^0-9]/g, '');
                        this.value = numbersOnly;
                    });
                }
            });
        });
    </script>
    
    @yield('extra_js')
</body>
</html>
