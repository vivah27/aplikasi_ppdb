@extends('layouts.master')

@section('page_title', 'Pengumuman Hasil Seleksi')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-bullhorn me-2"></i>Pengumuman Hasil Seleksi PPDB</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <p class="text-muted">Masukkan nomor pendaftaran Anda untuk melihat hasil seleksi</p>
                    </div>

                    <form action="{{ route('pengumuman.cari') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nomor_pendaftaran" class="form-label">Nomor Pendaftaran</label>
                            <input type="text" class="form-control form-control-lg" id="nomor_pendaftaran" name="nomor_pendaftaran" 
                                   placeholder="Contoh: PPDB2025001" required maxlength="20">
                            @error('nomor_pendaftaran')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>Cek Hasil Seleksi
                            </button>
                        </div>
                    </form>

                    @if(session('error'))
                        <div class="alert alert-danger mt-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Hasil seleksi dapat dilihat setelah proses verifikasi oleh admin selesai.
                </small>
            </div>
        </div>
    </div>
</div>
@endsection