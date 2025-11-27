@extends('layouts.master')

@section('page_title', 'Formulir Pendaftaran')

@section('content')
<div class="page-header mb-4">
    <h1 class="page-title"><i class="fas fa-form me-2"></i>Formulir Pendaftaran</h1>
    <p class="page-subtitle">Isi data pendaftaran Anda dengan lengkap dan benar</p>
</div>

<div class="row g-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Data Pendaftaran</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-warning me-2"></i>Periksa kembali form Anda:
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('user.formulir.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                            <input type="text" name="tahun_ajaran" class="form-control @error('tahun_ajaran') is-invalid @enderror" 
                                   value="{{ old('tahun_ajaran', optional($pendaftaran)->tahun_ajaran ?? '2025/2026') }}" required>
                            @error('tahun_ajaran')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jalur Pendaftaran <span class="text-danger">*</span></label>
                            <select name="jalur_pendaftaran" class="form-select @error('jalur_pendaftaran') is-invalid @enderror" required>
                                <option value="">-- Pilih Jalur --</option>
                                <option value="Reguler" {{ old('jalur_pendaftaran', optional($pendaftaran)->jalur_pendaftaran ?? '') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                                <option value="Prestasi" {{ old('jalur_pendaftaran', optional($pendaftaran)->jalur_pendaftaran ?? '') == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                            </select>
                            @error('jalur_pendaftaran')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Gelombang <span class="text-danger">*</span></label>
                            <input type="number" name="gelombang" class="form-control" 
                                   value="{{ old('gelombang', optional($pendaftaran)->gelombang ?? '1') }}" readonly style="background-color: #f8f9fa; cursor: not-allowed;">
                            <small class="text-muted d-block mt-1"><i class="fas fa-lock me-1"></i>Gelombang ditentukan oleh admin</small>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Jurusan Pilihan <span class="text-danger">*</span></label>
                            <select name="jurusan_pilihan" id="jurusan_pilihan" class="form-select @error('jurusan_pilihan') is-invalid @enderror" required>
                                <option value="">-- Pilih Jurusan --</option>
                                <option value="1" {{ old('jurusan_pilihan', optional($pendaftaran)->jurusan_pilihan_1 ?? '') == 1 ? 'selected' : '' }}>1. Teknik Kendaraan Ringan (TKR)</option>
                                <option value="2" {{ old('jurusan_pilihan', optional($pendaftaran)->jurusan_pilihan_1 ?? '') == 2 ? 'selected' : '' }}>2. Teknik Permesinan (TPM)</option>
                                <option value="3" {{ old('jurusan_pilihan', optional($pendaftaran)->jurusan_pilihan_1 ?? '') == 3 ? 'selected' : '' }}>3. Teknik Instalasi Tenaga Listrik (TITL)</option>
                                <option value="4" {{ old('jurusan_pilihan', optional($pendaftaran)->jurusan_pilihan_1 ?? '') == 4 ? 'selected' : '' }}>4. Rekayasa Perangkat Lunak (RPL)</option>
                            </select>
                            @error('jurusan_pilihan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rata-rata Nilai Raport <span class="text-danger">*</span></label>
                        <input type="number" name="rata_nilai" step="0.01" class="form-control @error('rata_nilai') is-invalid @enderror" 
                               value="{{ old('rata_nilai', optional($pendaftaran)->rata_nilai ?? '') }}" required>
                        @error('rata_nilai')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 gap-md-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Simpan Formulir
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .page-header {
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 1.5rem;
    }
    .page-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #2c3e50;
    }
    .page-subtitle {
        font-size: 0.95rem;
        color: #6c757d;
        margin: 0.5rem 0 0 0;
    }
</style>
<script>
    // Script removed - simplified to single jurusan field
</script>
@endsection