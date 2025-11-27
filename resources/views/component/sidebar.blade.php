<!-- Sidebar Component -->
<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="@if(Auth::check() && Auth::user()->hasRole('admin')){{ route('admin.dashboard') }}@else{{ route('dashboard') }}@endif">
                <img src="{{ asset('assets/images/logo.png') }}" height="36" alt="Aplikasi PPDB">
            </a>
        </h1>

        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav pt-lg-3">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link @if(Auth::check() && Auth::user()->hasRole('admin') && request()->routeIs('admin.dashboard'))active @elseif(!Auth::check() || !Auth::user()->hasRole('admin') && request()->routeIs('dashboard'))active @endif" href="@if(Auth::check() && Auth::user()->hasRole('admin')){{ route('admin.dashboard') }}@else{{ route('dashboard') }}@endif" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-home"></i>
                        </span>
                        <span class="nav-link-title">Dashboard</span>
                    </a>
                </li>

                <!-- Biodata -->
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('biodata.*')) active @endif" href="{{ route('biodata.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-user-circle"></i>
                        </span>
                        <span class="nav-link-title">Biodata</span>
                    </a>
                </li>

                @auth
                    @if(Auth::user()->hasRole(['admin', 'panitia']))
                        <!-- Admin Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle @if(request()->routeIs('admin.*')) active @endif" href="#navbar-help" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="fas fa-cogs"></i>
                                </span>
                                <span class="nav-link-title">Admin</span>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item @if(request()->routeIs('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-chart-line me-2"></i> Dashboard Admin
                                </a>
                                <a class="dropdown-item @if(request()->routeIs('admin.siswa.*')) active @endif" href="{{ route('admin.siswa.index') }}">
                                    <i class="fas fa-users me-2"></i> Data Siswa
                                </a>
                                <a class="dropdown-item @if(request()->routeIs('admin.pendaftaran.*')) active @endif" href="{{ route('admin.pendaftaran.index') }}">
                                    <i class="fas fa-file-alt me-2"></i> Data Pendaftaran
                                </a>
                                <a class="dropdown-item @if(request()->routeIs('admin.verifikasi.*')) active @endif" href="{{ route('admin.verifikasi.index') }}">
                                    <i class="fas fa-check-square me-2"></i> Verifikasi Dokumen
                                </a>
                                <hr class="dropdown-divider">
                                <a class="dropdown-item @if(request()->routeIs('admin.jenis-dokumen.*')) active @endif" href="{{ route('admin.jenis-dokumen.index') }}">
                                    <i class="fas fa-list me-2"></i> Jenis Dokumen
                                </a>
                                <a class="dropdown-item @if(request()->routeIs('admin.peran.*')) active @endif" href="{{ route('admin.peran.index') }}">
                                    <i class="fas fa-users-cog me-2"></i> Manage Peran
                                </a>
                                <hr class="dropdown-divider">
                                <a class="dropdown-item @if(request()->routeIs('admin.laporan.*')) active @endif" href="{{ route('admin.laporan.index') }}">
                                    <i class="fas fa-chart-bar me-2"></i> Laporan
                                </a>
                            </div>
                        </li>
                    @elseif(Auth::user()->hasRole('user'))
                        <!-- User Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle @if(request()->routeIs('user.*')) active @endif" href="#navbar-help" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="fas fa-file-upload"></i>
                                </span>
                                <span class="nav-link-title">Dokumen</span>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item @if(request()->routeIs('user.dokumen.index')) active @endif" href="{{ route('user.dokumen.index') }}">
                                    <i class="fas fa-list me-2"></i> Kelola Dokumen
                                </a>
                                <a class="dropdown-item @if(request()->routeIs('user.dokumen.create')) active @endif" href="{{ route('user.dokumen.create') }}">
                                    <i class="fas fa-plus me-2"></i> Upload Dokumen
                                </a>
                                <hr class="dropdown-divider">
                                <a class="dropdown-item @if(request()->routeIs('user.cetak-kartu')) active @endif" href="{{ route('user.cetak-kartu') }}">
                                    <i class="fas fa-print me-2"></i> Cetak Kartu Ujian
                                </a>
                            </div>
                        </li>

                        <!-- Status -->
                        <li class="nav-item">
                            <a class="nav-link @if(request()->routeIs('user.status')) active @endif" href="{{ route('user.status') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="fas fa-info-circle"></i>
                                </span>
                                <span class="nav-link-title">Status Pendaftaran</span>
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>
</aside>
