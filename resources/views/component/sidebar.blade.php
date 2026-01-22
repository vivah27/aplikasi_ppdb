<!-- Sidebar Component - Modern Premium Design -->
<style>
    @keyframes gradient-shift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    
    @keyframes slide-in {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes float-icon {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-4px); }
    }
    
    .sidebar-wrapper {
        background: linear-gradient(135deg, #0f1419 0%, #1a1f2e 50%, #0f1419 100%);
        background-size: 200% 200%;
        animation: gradient-shift 15s ease infinite;
        position: fixed;
        left: 0;
        top: 0;
        width: 280px;
        height: 100vh;
        overflow-y: auto;
        z-index: 1000;
        border-right: 2px solid transparent;
        background-clip: padding-box;
        box-shadow: 8px 0 32px rgba(255, 107, 53, 0.15), inset -1px 0 0 rgba(255, 107, 53, 0.1);
        transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
    }
    
    .sidebar-wrapper:hover {
        box-shadow: 8px 0 48px rgba(255, 107, 53, 0.25), inset -1px 0 0 rgba(255, 107, 53, 0.15);
    }
    
    .logo-section {
        padding: 28px 20px;
        background: linear-gradient(135deg, rgba(255, 107, 53, 0.15) 0%, rgba(255, 20, 147, 0.08) 100%);
        border-bottom: 2px solid rgba(255, 107, 53, 0.2);
        margin-bottom: 8px;
        position: relative;
        overflow: hidden;
    }
    
    .logo-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
        animation: slide-in 3s ease-in-out infinite;
    }
    
    .logo-badge {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #a8dadc 0%, #FF1493 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 24px rgba(255, 107, 53, 0.6), 0 0 20px rgba(255, 20, 147, 0.3);
        position: relative;
        flex-shrink: 0;
        border: 2px solid rgba(255, 255, 255, 0.1);
    }
    
    .logo-badge i {
        color: white;
        font-size: 1.8rem;
        animation: float-icon 3s ease-in-out infinite;
    }
    
    .nav-menu {
        padding: 24px 0;
    }
    
    .nav-item {
        margin-bottom: 6px;
        animation: slide-in 0.5s ease-out forwards;
    }
    
    .nav-link {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 13px 16px !important;
        margin: 0 10px;
        color: rgba(255, 255, 255, 0.7) !important;
        text-decoration: none;
        border-radius: 12px;
        transition: all 0.35s cubic-bezier(0.23, 1, 0.320, 1);
        border-left: 3px solid transparent;
        position: relative;
        font-weight: 500;
        font-size: 0.95rem;
        overflow: hidden;
    }
    
    .nav-link::before {
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
    
    .nav-link:hover::before {
        transform: translateX(100%);
    }
    
    .nav-link:hover {
        background: rgba(255, 107, 53, 0.15) !important;
        color: #a8dadc !important;
        transform: translateX(4px);
        box-shadow: -3px 0 12px rgba(255, 107, 53, 0.2);
    }
    
    .nav-link.active {
        background: linear-gradient(90deg, rgba(255, 107, 53, 0.25) 0%, rgba(255, 107, 53, 0.1) 100%) !important;
        color: #a8dadc !important;
        border-left-color: #a8dadc !important;
        box-shadow: -3px 0 16px rgba(255, 107, 53, 0.3), inset 2px 0 8px rgba(255, 107, 53, 0.15);
    }
    
    .nav-icon {
        font-size: 1.2rem;
        width: 24px;
        text-align: center;
        color: #a8dadc;
        transition: all 0.4s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .nav-link:hover .nav-icon {
        transform: scale(1.2) rotate(5deg);
        color: #FF1493;
        filter: drop-shadow(0 0 8px rgba(255, 107, 53, 0.6));
    }
    
    .section-header {
        margin-top: 28px;
        margin-bottom: 14px;
        padding: 0 20px;
        position: relative;
    }
    
    .section-header::before {
        content: '';
        position: absolute;
        left: 20px;
        right: 20px;
        top: -14px;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 107, 53, 0.3), transparent);
    }
    
    .section-title {
        font-size: 0.72rem;
        font-weight: 900;
        color: #a8dadc;
        text-transform: uppercase;
        letter-spacing: 1.3px;
        opacity: 0.9;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .section-title i {
        opacity: 0.7;
        transition: transform 0.3s ease;
    }
    
    .section-header:hover .section-title i {
        transform: scale(1.15);
    }
    
    .dropdown-toggle {
        position: relative;
    }
    
    .dropdown-toggle::after {
        content: '';
        position: absolute;
        right: 16px;
        transition: transform 0.4s cubic-bezier(0.23, 1, 0.320, 1);
    }
    
    .dropdown-menu {
        background: linear-gradient(135deg, rgba(15, 20, 35, 0.95) 0%, rgba(25, 30, 45, 0.95) 100%) !important;
        border: 1px solid rgba(255, 107, 53, 0.25) !important;
        border-radius: 12px;
        padding: 8px;
        margin: 4px 10px;
        box-shadow: 0 12px 32px rgba(255, 107, 53, 0.15), inset 0 1px 0 rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        animation: slide-in 0.3s ease-out;
    }
    
    .dropdown-item {
        color: rgba(255, 255, 255, 0.7) !important;
        padding: 11px 16px !important;
        border-radius: 10px;
        margin: 4px 0;
        transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
        border-left: 3px solid transparent;
        font-size: 0.9rem;
        position: relative;
        overflow: hidden;
    }
    
    .dropdown-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 107, 53, 0.2), transparent);
        transform: translateX(-100%);
        transition: transform 0.5s ease;
    }
    
    .dropdown-item:hover::before {
        transform: translateX(100%);
    }
    
    .dropdown-item:hover {
        background: rgba(255, 107, 53, 0.15) !important;
        color: #a8dadc !important;
        transform: translateX(4px);
        border-left-color: #a8dadc !important;
    }
    
    .dropdown-item.active {
        background: linear-gradient(90deg, rgba(255, 107, 53, 0.3) 0%, rgba(255, 107, 53, 0.1) 100%) !important;
        color: #a8dadc !important;
        border-left-color: #a8dadc !important;
        box-shadow: inset 2px 0 8px rgba(255, 107, 53, 0.15);
    }
    
    .dropdown-divider {
        border-color: rgba(255, 107, 53, 0.15) !important;
        margin: 8px 0 !important;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 107, 53, 0.2), transparent);
    }
    
    /* Scrollbar Styling */
    .sidebar-wrapper::-webkit-scrollbar {
        width: 8px;
    }
    
    .sidebar-wrapper::-webkit-scrollbar-track {
        background: rgba(255, 107, 53, 0.05);
        border-radius: 10px;
    }
    
    .sidebar-wrapper::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #a8dadc, #FF1493);
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(255, 107, 53, 0.4);
    }
    
    .sidebar-wrapper::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #FF1493, #FF69B4);
        box-shadow: 0 0 16px rgba(255, 107, 53, 0.6);
    }
    
    .user-menu-section {
        margin-top: 40px;
        padding-top: 20px;
        border-top: 2px solid rgba(255, 107, 53, 0.15);
    }
</style>

<aside class="sidebar-wrapper">
    <!-- Logo Section -->
    <div class="logo-section">
        <a href="@if(Auth::check() && Auth::user()->hasRole('admin')){{ route('admin.dashboard') }}@else{{ route('dashboard') }}@endif" 
           style="display: flex; align-items: center; gap: 12px; text-decoration: none; cursor: pointer; position: relative; z-index: 2;">
            <div class="logo-badge">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div style="flex: 1;">
                <div style="color: white; font-weight: 900; font-size: 1.1rem; letter-spacing: -0.5px; text-shadow: 0 2px 8px rgba(255, 107, 53, 0.3);">PPDB</div>
                <div style="font-size: 0.65rem; color: #a8dadc; font-weight: 700; letter-spacing: 0.5px;">SMK ANTARTIKA</div>
            </div>
        </a>
    </div>

    <!-- Main Navigation -->
    <nav class="nav-menu">
        <ul style="list-style: none; padding: 0; margin: 0;">
            <!-- Dashboard Item -->
            <li class="nav-item">
                <a href="@if(Auth::check() && Auth::user()->hasRole('admin')){{ route('admin.dashboard') }}@else{{ route('dashboard') }}@endif"
                   class="nav-link @if((Auth::check() && Auth::user()->hasRole('admin') && request()->routeIs('admin.dashboard')) || (Auth::check() && !Auth::user()->hasRole('admin') && request()->routeIs('dashboard'))) active @endif">
                    <i class="fas fa-home nav-icon"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Biodata Item -->
            <li class="nav-item">
                <a href="{{ route('biodata.index') }}"
                   class="nav-link @if(request()->routeIs('biodata.*')) active @endif">
                    <i class="fas fa-user-circle nav-icon"></i>
                    <span>Biodata</span>
                </a>
            </li>

            @auth
                @if(Auth::user()->hasRole(['admin', 'panitia']))
                    <!-- Admin Tools Section Header -->
                    <li class="section-header">
                        <div class="section-title">
                            <i class="fas fa-tools"></i>Admin Tools
                        </div>
                    </li>

                    <!-- Manajemen Dropdown -->
                    <li class="nav-item">
                        <div class="nav-link dropdown-toggle" 
                             onclick="this.nextElementSibling.classList.toggle('show'); this.querySelector('.chevron').style.transform = this.nextElementSibling.classList.contains('show') ? 'rotate(90deg)' : 'rotate(0deg)';"
                             style="cursor: pointer; user-select: none;">
                            <i class="fas fa-cogs nav-icon"></i>
                            <span style="flex: 1;">Manajemen</span>
                            <i class="fas fa-chevron-right chevron" style="font-size: 0.85rem; opacity: 0.7; transition: transform 0.4s ease; color: #a8dadc;"></i>
                        </div>
                        <div class="dropdown-menu" style="display: none;">
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                <i class="fas fa-chart-line" style="color: #a8dadc; width: 20px; text-align: center;"></i>
                                Dashboard Admin
                            </a>
                            <a href="{{ route('admin.siswa.index') }}" class="dropdown-item">
                                <i class="fas fa-users" style="color: #a8dadc; width: 20px; text-align: center;"></i>
                                Daftar Siswa
                            </a>
                            <a href="{{ route('admin.pendaftaran.index') }}" class="dropdown-item">
                                <i class="fas fa-file-alt" style="color: #a8dadc; width: 20px; text-align: center;"></i>
                                Data Pendaftaran
                            </a>
                            <a href="{{ route('admin.verifikasi.index') }}" class="dropdown-item">
                                <i class="fas fa-check-circle" style="color: #a8dadc; width: 20px; text-align: center;"></i>
                                Verifikasi Dokumen
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('admin.jenis-dokumen.index') }}" class="dropdown-item">
                                <i class="fas fa-list" style="color: #a8dadc; width: 20px; text-align: center;"></i>
                                Jenis Dokumen
                            </a>
<<<<<<< HEAD
                            <a href="{{ route('admin.peran.index') }}" class="dropdown-item">
                                <i class="fas fa-users-cog" style="color: #a8dadc; width: 20px; text-align: center;"></i>
                                Manage Peran
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('admin.laporan.index') }}" class="dropdown-item">
                                <i class="fas fa-chart-bar" style="color: #a8dadc; width: 20px; text-align: center;"></i>
                                Laporan
                            </a>
=======
                            <!-- Removed Manage Peran and Laporan menu items -->
>>>>>>> 72e2c9e0425e4d8887f92164fa4154fe96d31a50
                        </div>
                    </li>

                @elseif(Auth::user()->hasRole('user'))
                    <!-- Dokumen Section Header -->
                    <li class="section-header">
                        <div class="section-title">
                            <i class="fas fa-file-alt"></i>Dokumen
                        </div>
                    </li>

                    <!-- Dokumen Dropdown -->
                    <li class="nav-item">
                        <div class="nav-link dropdown-toggle" 
                             onclick="this.nextElementSibling.classList.toggle('show'); this.querySelector('.chevron').style.transform = this.nextElementSibling.classList.contains('show') ? 'rotate(90deg)' : 'rotate(0deg)';"
                             style="cursor: pointer; user-select: none;">
                            <i class="fas fa-file-upload nav-icon"></i>
                            <span style="flex: 1;">Dokumen</span>
                            <i class="fas fa-chevron-right chevron" style="font-size: 0.85rem; opacity: 0.7; transition: transform 0.4s ease; color: #a8dadc;"></i>
                        </div>
                        <div class="dropdown-menu" style="display: none;">
                            <a href="{{ route('user.dokumen.index') }}" class="dropdown-item">
                                <i class="fas fa-list" style="color: #a8dadc; width: 20px; text-align: center;"></i>
                                Kelola Dokumen
                            </a>
                            <a href="{{ route('user.dokumen.create') }}" class="dropdown-item">
                                <i class="fas fa-plus-circle" style="color: #a8dadc; width: 20px; text-align: center;"></i>
                                Upload Dokumen
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('user.cetak-kartu') }}" class="dropdown-item">
                                <i class="fas fa-print" style="color: #a8dadc; width: 20px; text-align: center;"></i>
                                Cetak Kartu Ujian
                            </a>
                        </div>
                    </li>

                    <!-- Status Pendaftaran Item -->
                    <li class="nav-item">
                        <a href="{{ route('user.status') }}"
                           class="nav-link @if(request()->routeIs('user.status')) active @endif">
                            <i class="fas fa-info-circle nav-icon"></i>
                            <span>Status Pendaftaran</span>
                        </a>
                    </li>
                @endif

                <!-- User Profile Section -->
                <li class="user-menu-section">
                    <li class="nav-item">
                        <a href="{{ route('profile.edit') }}"
                           class="nav-link @if(request()->routeIs('profile.*')) active @endif">
                            <i class="fas fa-user nav-icon"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="nav-link" style="color: rgba(255, 107, 53, 0.9) !important;">
                            <i class="fas fa-sign-out-alt nav-icon"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </li>
            @endauth
        </ul>
    </nav>
</aside>


