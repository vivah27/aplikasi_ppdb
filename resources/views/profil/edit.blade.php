@extends('layouts.master')

@section('page_title', 'Edit Profil')

@section('content')
<div class="page-header mb-3">
    <h1 class="page-title"><i class="fas fa-user-edit me-2"></i>Edit Profil</h1>
    <p class="page-subtitle">Perbarui informasi profil Anda</p>
</div>

<div class="row">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Data Pribadi</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('profil.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama Lengkap -->
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label fw-600">
                            <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap
                        </label>
                        <input type="text" class="form-control form-control-lg @error('nama_lengkap') is-invalid @enderror" 
                               id="nama_lengkap" name="nama_lengkap" 
                               value="{{ old('nama_lengkap', optional($siswa)->nama_lengkap ?? '') }}" 
                               placeholder="Masukkan nama lengkap">
                        @error('nama_lengkap')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- NISN -->
                    <div class="mb-3">
                        <label for="nisn" class="form-label fw-600">
                            <i class="fas fa-id-card me-2 text-primary"></i>NISN
                        </label>
                        <input type="text" class="form-control form-control-lg @error('nisn') is-invalid @enderror" 
                               id="nisn" name="nisn" 
                               value="{{ old('nisn', optional($siswa)->nisn ?? '') }}" 
                               placeholder="Masukkan NISN">
                        @error('nisn')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- NIK -->
                    <div class="mb-3">
                        <label for="nik" class="form-label fw-600">
                            <i class="fas fa-passport me-2 text-primary"></i>NIK
                        </label>
                        <input type="text" class="form-control form-control-lg @error('nik') is-invalid @enderror" 
                               id="nik" name="nik" 
                               value="{{ old('nik', optional($siswa)->nik ?? '') }}" 
                               placeholder="Masukkan NIK">
                        @error('nik')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Row untuk Tempat dan Tanggal Lahir -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tempat_lahir" class="form-label fw-600">
                                    <i class="fas fa-map-pin me-2 text-primary"></i>Tempat Lahir
                                </label>
                                <input type="text" class="form-control form-control-lg @error('tempat_lahir') is-invalid @enderror" 
                                       id="tempat_lahir" name="tempat_lahir" 
                                       value="{{ old('tempat_lahir', optional($siswa)->tempat_lahir ?? '') }}" 
                                       placeholder="Masukkan tempat lahir">
                                @error('tempat_lahir')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label fw-600">
                                    <i class="fas fa-calendar me-2 text-primary"></i>Tanggal Lahir
                                </label>
                                <input type="date" class="form-control form-control-lg @error('tanggal_lahir') is-invalid @enderror" 
                                       id="tanggal_lahir" name="tanggal_lahir" 
                                       value="{{ old('tanggal_lahir', optional($siswa)->tanggal_lahir?->format('Y-m-d') ?? '') }}">
                                @error('tanggal_lahir')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label fw-600">
                            <i class="fas fa-venus-mars me-2 text-primary"></i>Jenis Kelamin
                        </label>
                        <select class="form-select form-select-lg @error('jenis_kelamin') is-invalid @enderror" 
                                id="jenis_kelamin" name="jenis_kelamin">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            @php
                                $currentJK = old('jenis_kelamin', optional($siswa)->jenis_kelamin ?? '');
                                // Convert L to Laki-laki and P to Perempuan for display
                                $currentJK = $currentJK === 'L' ? 'Laki-laki' : ($currentJK === 'P' ? 'Perempuan' : $currentJK);
                            @endphp
                            <option value="Laki-laki" {{ $currentJK === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $currentJK === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Row untuk No Telepon dan Asal Sekolah -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_telepon" class="form-label fw-600">
                                    <i class="fas fa-phone me-2 text-primary"></i>No. Telepon
                                </label>
                                <input type="text" class="form-control form-control-lg @error('no_telepon') is-invalid @enderror" 
                                       id="no_telepon" name="no_telepon" 
                                       value="{{ old('no_telepon', optional($siswa)->no_telepon ?? '') }}" 
                                       placeholder="Masukkan nomor telepon">
                                @error('no_telepon')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="asal_sekolah" class="form-label fw-600">
                                    <i class="fas fa-school me-2 text-primary"></i>Asal Sekolah
                                </label>
                                <input type="text" class="form-control form-control-lg @error('asal_sekolah') is-invalid @enderror" 
                                       id="asal_sekolah" name="asal_sekolah" 
                                       value="{{ old('asal_sekolah', optional($siswa)->asal_sekolah ?? '') }}" 
                                       placeholder="Masukkan asal sekolah">
                                @error('asal_sekolah')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-600">
                            <i class="fas fa-home me-2 text-primary"></i>Alamat
                        </label>
                        <textarea class="form-control form-control-lg @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="3" 
                                  placeholder="Masukkan alamat lengkap">{{ old('alamat', optional($siswa)->alamat ?? '') }}</textarea>
                        @error('alamat')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Bio -->
                    <div class="mb-3">
                        <label for="bio" class="form-label fw-600">
                            <i class="fas fa-quote-left me-2 text-primary"></i>Bio / Tentang Saya
                        </label>
                        <textarea class="form-control form-control-lg @error('bio') is-invalid @enderror" 
                                  id="bio" name="bio" rows="3" 
                                  placeholder="Tulis tentang diri Anda (opsional)">{{ old('bio', optional($siswa)->bio ?? '') }}</textarea>
                        <small class="text-muted d-block mt-1">Maksimal 1000 karakter</small>
                        @error('bio')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2 justify-content-between mt-4">
                        <a href="{{ route('profil.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Sidebar -->
    <div class="col-12 col-lg-4">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-info-circle me-2 text-info"></i>Informasi Penting</h6>
                <p class="small text-muted mb-2">
                    <i class="fas fa-check text-success me-2"></i>Isi data dengan lengkap dan benar
                </p>
                <p class="small text-muted mb-2">
                    <i class="fas fa-check text-success me-2"></i>Data akan disimpan otomatis
                </p>
                <p class="small text-muted">
                    <i class="fas fa-check text-success me-2"></i>Perubahan akan langsung terlihat di profil Anda
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
