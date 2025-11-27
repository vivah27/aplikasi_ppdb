@extends('layouts.auth')

@section('title', 'Verifikasi Kode Reset Password')

@section('content')
<div class="container-fluid h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100dvh; display: flex; align-items: center;">
    <div class="row w-100 justify-content-center">
        <div class="col-md-8 col-lg-5 col-xl-4">
            <div class="card shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 2rem; text-align: center;">
                    <h2 class="text-white mb-2" style="font-weight: 700;">
                        <i class="fas fa-shield-alt me-2"></i>Verifikasi Kode
                    </h2>
                    <p class="text-white-50 mb-0">Masukkan kode yang telah dikirim ke email Anda</p>
                </div>

                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Petunjuk:</strong> Kode verifikasi telah dikirim ke email <strong>{{ optional($user)->email }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>

                    <form method="POST" action="{{ route('password.verify-otp') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-4">
                            <label class="form-label fw-600">
                                <i class="fas fa-lock me-2 text-primary"></i>Kode Verifikasi
                            </label>
                            <input type="text" name="otp" class="form-control form-control-lg text-center @error('otp') is-invalid @enderror" 
                                   placeholder="Masukkan 6 digit kode" maxlength="6" pattern="[0-9]{6}" 
                                   inputmode="numeric" required autofocus 
                                   style="font-size: 1.5rem; letter-spacing: 10px; font-weight: bold;">
                            @error('otp')
                                <small class="text-danger d-block mt-2">{{ $message }}</small>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-clock me-1"></i>Kode berlaku selama 10 menit
                            </small>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-600">
                                <i class="fas fa-check me-2"></i>Verifikasi Kode
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p class="text-muted small mb-2">
                            Tidak menerima kode?
                        </p>
                        <a href="{{ route('forgot_password.email_form') }}" class="text-decoration-none fw-600">
                            <i class="fas fa-refresh me-1"></i>Request Kode Ulang
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small mb-2">
                    <i class="fas fa-shield-alt me-1"></i>Data Anda aman terlindungi
                </p>
                <p class="text-muted small">© 2025 PPDB SMK Antartika 1 Sidoarjo</p>
            </div>
        </div>
    </div>
</div>

<style>
    body { 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
    }
    
    .form-control:focus { 
        border-color: #667eea; 
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25); 
    }
    
    .btn-primary:hover { 
        background: linear-gradient(135deg, #5568d3 0%, #6a3a95 100%); 
        border-color: transparent; 
        transform: translateY(-2px); 
        box-shadow: 0 8px 16px rgba(102, 126, 234, 0.4); 
    }
    
    .text-white-50 { 
        color: rgba(255,255,255,0.7); 
    }

    input[type="text"]::-webkit-outer-spin-button,
    input[type="text"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

@endsection
