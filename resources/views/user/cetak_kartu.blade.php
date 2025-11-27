@extends('layouts.master')

@section('page_title', 'Cetak Kartu Ujian')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="row mb-3">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Cetak Kartu Ujian</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Info Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="ti ti-info-circle me-2"></i>
                <strong>Informasi:</strong> Kartu ujian akan tersedia setelah status pendaftaran diterima.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Kartu Ujian Anda</h5>
                </div>
                <div class="card-body">
                    @php
                        $user = Auth::user();
                        $siswa = $user->siswa ?? null;
                        $pendaftaran = $siswa ? $siswa->pendaftaran->first() : null;
                    @endphp

                    @if ($siswa && $pendaftaran)
                        <!-- Info Pendaftaran -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong>Nama Lengkap:</strong> {{ $siswa->nama_lengkap }}
                                </p>
                                <p class="mb-2">
                                    <strong>NISN:</strong> {{ $siswa->nisn }}
                                </p>
                                <p class="mb-2">
                                    <strong>Jenis Kelamin:</strong> {{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong>Nomor Pendaftaran:</strong> {{ $pendaftaran->nomor_pendaftaran ?? '-' }}
                                </p>
                                <p class="mb-2">
                                    <strong>Tahun Ajaran:</strong> {{ $pendaftaran->tahun_ajaran }}
                                </p>
                                <p class="mb-2">
                                    <strong>Jalur Pendaftaran:</strong> {{ $pendaftaran->jalur_pendaftaran }}
                                </p>
                            </div>
                        </div>

                        <hr>

                        <!-- Pilihan Jurusan -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">Pilihan Jurusan</h6>
                            <p class="mb-2">
                                <strong>Pilihan 1:</strong> {{ $pendaftaran->jurusanPilihan1?->nama ?? '-' }}
                            </p>
                            <p class="mb-2">
                                <strong>Pilihan 2:</strong> {{ $pendaftaran->jurusanPilihan2?->nama ?? '-' }}
                            </p>
                        </div>

                        <hr>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-primary" onclick="window.print()">
                                <i class="ti ti-printer me-2"></i> Cetak Kartu
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                                <i class="ti ti-arrow-left me-2"></i> Kembali
                            </button>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="ti ti-alert-circle me-2"></i>
                            <strong>Informasi Belum Lengkap</strong>
                            <p class="mt-2 mb-0">Silakan lengkapi data pribadi dan daftar terlebih dahulu untuk mendapatkan kartu ujian.</p>
                        </div>
                        <a href="{{ route('biodata.index') }}" class="btn btn-primary">
                            <i class="ti ti-edit me-2"></i> Lengkapi Data
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if ($siswa && $pendaftaran)
<style media="print">
    body {
        font-family: Arial, sans-serif;
    }
    .navbar, .breadcrumb, .btn, .card-header, .card-footer {
        display: none !important;
    }
    .container-fluid {
        padding: 0;
    }
    .card {
        border: 1px solid #000;
    }
</style>
@endif
@endsection
