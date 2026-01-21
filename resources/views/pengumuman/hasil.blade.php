@extends('layouts.master')

@section('page_title', 'Hasil Seleksi')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0"><i class="fas fa-trophy me-2"></i>Hasil Seleksi PPDB</h4>
                    <p class="mb-0 mt-1">SMK Antartika 1 Sidoarjo</p>
                </div>
                <div class="card-body">
                    <!-- Info Pendaftaran -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-box">
                                <strong>Nomor Pendaftaran:</strong><br>
                                <span class="text-primary">{{ $pendaftaran->nomor_pendaftaran }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <strong>Nama Lengkap:</strong><br>
                                {{ $siswa->nama_lengkap ?? 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <!-- Status Hasil -->
                    <div class="text-center mb-4">
                        @php
                            $statusLabel = $status ? $status->label : 'Menunggu';
                            $statusClass = match($statusLabel) {
                                'Diterima' => 'success',
                                'Menunggu' => 'warning',
                                'Ditolak' => 'danger',
                                default => 'info'
                            };
                            $statusIcon = match($statusLabel) {
                                'Diterima' => 'fas fa-check-circle',
                                'Menunggu' => 'fas fa-clock',
                                'Ditolak' => 'fas fa-times-circle',
                                default => 'fas fa-question-circle'
                            };
                        @endphp

                        <div class="status-result status-{{ $statusClass }}">
                            <i class="{{ $statusIcon }} status-icon"></i>
                            <h3 class="status-title">{{ $statusLabel }}</h3>
                            @if($statusLabel === 'Diterima')
                                <p class="status-message">Selamat! Anda telah diterima di SMK Antartika 1 Sidoarjo</p>
                            @elseif($statusLabel === 'Ditolak')
                                <p class="status-message">Maaf, Anda belum diterima pada periode ini. Tetap semangat!</p>
                            @else
                                <p class="status-message">Hasil seleksi sedang diproses. Silakan cek kembali nanti.</p>
                            @endif
                        </div>
                    </div>

                    @if($statusLabel === 'Diterima')
                        <!-- Info Tambahan untuk Diterima -->
                        <div class="alert alert-success">
                            <h5><i class="fas fa-info-circle me-2"></i>Informasi Selanjutnya</h5>
                            <ul class="mb-0">
                                <li>Silakan lakukan daftar ulang sesuai jadwal yang akan diumumkan</li>
                                <li>Persiapkan dokumen yang diperlukan untuk daftar ulang</li>
                                <li>Informasi lebih lanjut akan dikirim melalui email atau WhatsApp</li>
                            </ul>
                        </div>
                    @endif

                    <!-- Tombol Aksi -->
                    <div class="text-center mt-4">
                        <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-1"></i>Login ke Akun
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.status-result {
    padding: 40px 20px;
    border-radius: 15px;
    margin: 20px 0;
}

.status-result.status-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border: 2px solid #28a745;
}

.status-result.status-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    border: 2px solid #dc3545;
}

.status-result.status-warning {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    border: 2px solid #ffc107;
}

.status-result.status-info {
    background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
    border: 2px solid #17a2b8;
}

.status-icon {
    font-size: 48px;
    margin-bottom: 15px;
    display: block;
}

.status-result.status-success .status-icon { color: #155724; }
.status-result.status-danger .status-icon { color: #721c24; }
.status-result.status-warning .status-icon { color: #856404; }
.status-result.status-info .status-icon { color: #0c5460; }

.status-title {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 10px;
}

.status-result.status-success .status-title { color: #155724; }
.status-result.status-danger .status-title { color: #721c24; }
.status-result.status-warning .status-title { color: #856404; }
.status-result.status-info .status-title { color: #0c5460; }

.status-message {
    font-size: 16px;
    margin-bottom: 0;
}

.info-box {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 4px solid #007bff;
    margin-bottom: 15px;
}
</style>
@endsection