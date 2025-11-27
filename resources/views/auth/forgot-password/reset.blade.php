@extends('layouts.auth')

@section('title', 'Resetting Your Password ?')

@section('content')
<div class="container-fluid h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100dvh; display: flex; align-items: center;">
    <div class="row w-100 justify-content-center">
        <div class="col-md-8 col-lg-5 col-xl-4">
            <div class="card shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 2rem; text-align: center;">
                    <h2 class="text-white mb-2" style="font-weight: 700;">Reset Password</h2>
                    <p class="text-white-50 mb-0">Masukkan password baru untuk akun Anda</p>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="mb-3">
                            <p class="mb-2"><b>{{ $user->name }}</b>, kamu mau mengganti password untuk email <b>{{ $user->email }}</b> ya?</p>
                            <p>Bikin password yang kuat dan mudah diingat ya</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-600">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Confirm Password" required>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Reset Password</button>
                        </div>
                    </form>
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
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .form-control:focus { border-color: #667eea; box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25); }
    .btn-primary:hover { background: linear-gradient(135deg, #5568d3 0%, #6a3a95 100%); border-color: transparent; transform: translateY(-2px); box-shadow: 0 8px 16px rgba(102, 126, 234, 0.4); }
    .text-white-50 { color: rgba(255,255,255,0.7); }
</style>

@endsection
