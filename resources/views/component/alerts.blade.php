<!-- Alert Messages Component -->
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h4 class="alert-title">
            <i class="fas fa-exclamation-circle me-2"></i> Terjadi Kesalahan
        </h4>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-title">
            <i class="fas fa-check-circle me-2"></i> Sukses
        </h4>
        <p class="mb-0">{{ session('success') }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h4 class="alert-title">
            <i class="fas fa-times-circle me-2"></i> Gagal
        </h4>
        <p class="mb-0">{{ session('error') }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <h4 class="alert-title">
            <i class="fas fa-info-circle me-2"></i> Informasi
        </h4>
        <p class="mb-0">{{ session('info') }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <h4 class="alert-title">
            <i class="fas fa-exclamation-triangle me-2"></i> Peringatan
        </h4>
        <p class="mb-0">{{ session('warning') }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
