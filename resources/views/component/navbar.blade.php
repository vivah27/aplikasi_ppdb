<!-- Top Navigation Bar -->
<header class="navbar navbar-expand-md navbar-light d-print-none sticky-top">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-nav flex-row order-md-last">
            <!-- Notifications -->
            <div class="nav-item d-none d-md-flex me-3">
                <div class="btn-list">
                    <a href="{{ route('user.dokumen.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Upload
                    </a>
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <span class="avatar avatar-sm me-2">
                            <img src="{{ Auth::user()->avatar ?? asset('assets/images/avatar.png') }}" class="avatar-img rounded-circle" alt="{{ Auth::user()->name }}">
                        </span>
                        <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
                    <div class="dropdown-item">
                        <a href="{{ route('profil.index') }}" class="dropdown-item">
                            <i class="fas fa-user me-2"></i> Profil
                        </a>
                    </div>
                    <a href="{{ route('profil.index') }}" class="dropdown-item">
                        <i class="fas fa-cog me-2"></i> Pengaturan
                    </a>
                    <hr class="dropdown-divider">
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
