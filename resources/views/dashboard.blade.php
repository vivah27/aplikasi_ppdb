@extends('layouts.master')

@section('page_title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-tachometer-alt me-2"></i>
        Dashboard
    </h1>
    <p class="page-subtitle">Selamat datang, {{ Auth::user()->name }}! Berikut ringkasan data Anda.</p>
</div>

<!-- STAT CARDS ROW -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card primary">
            <div>
                <div class="stat-value">{{ $statsData['total_siswa'] ?? 0 }}</div>
                <div class="stat-label">Total Siswa</div>
            </div>
            <i class="fas fa-users stat-icon primary"></i>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card success">
            <div>
                <div class="stat-value">{{ $statsData['diterima'] ?? 0 }}</div>
                <div class="stat-label">Diterima</div>
            </div>
            <i class="fas fa-check-circle stat-icon success"></i>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card warning">
            <div>
                <div class="stat-value">{{ $statsData['menunggu'] ?? 0 }}</div>
                <div class="stat-label">Menunggu</div>
            </div>
            <i class="fas fa-clock stat-icon warning"></i>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card danger">
            <div>
                <div class="stat-value">{{ $statsData['ditolak'] ?? 0 }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
            <i class="fas fa-times-circle stat-icon danger"></i>
        </div>
    </div>
</div>

<!-- MAIN CONTENT ROW -->
<div class="row g-3">
    <!-- LEFT COLUMN - Documents -->
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-file-alt me-2"></i>
                Dokumen Terbaru
            </div>
            <div class="card-body">
                @if($recentDocuments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Jenis Dokumen</th>
                                    <th>Tanggal Upload</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentDocuments as $doc)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fas fa-file-pdf text-danger"></i>
                                                <span>{{ $doc->jenisDokumen->nama ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $doc->created_at->format('d M Y') }}</td>
                                        <td>
                                            @php
                                                $statusLabel = $doc->statusVerifikasi?->label ?? 'Menunggu Verifikasi';
                                                $statusBadgeClass = match($doc->statusVerifikasi?->kode ?? '') {
                                                    'verified' => 'success',
                                                    'pending' => 'warning',
                                                    'rejected' => 'danger',
                                                    'revision' => 'info',
                                                    default => 'warning'
                                                };
                                            @endphp
                                            <span class="badge badge-{{ $statusBadgeClass }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('user.dokumen.download', $doc->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3" style="opacity: 0.3;"></i>
                        <p class="text-muted">Belum ada dokumen yang diupload</p>
                        <a href="{{ route('user.dokumen.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Upload Dokumen
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- RIGHT COLUMN - Quick Actions & Info -->
    <div class="col-12 col-lg-4">
        <!-- Registration Status -->
        @if($pendaftaran)
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2"></i>
                    Status Pendaftaran
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Nomor Pendaftaran</small>
                        <p class="mb-0 fw-bold">{{ $pendaftaran->nomor_pendaftaran }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Status</small>
                        <p class="mb-0">
                            @php
                                $statusKode = $pendaftaran->statusPendaftaran?->kode ?? '';
                                $statusLabel = $pendaftaran->statusPendaftaran?->label ?? 'Unknown';
                                $badgeClass = match($statusKode) {
                                    'diterima' => 'success',
                                    'menunggu' => 'warning',
                                    'ditolak' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge badge-{{ $badgeClass }}">
                                {{ $statusLabel }}
                            </span>
                        </p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Jurusan Pilihan</small>
                        <p class="mb-0 fw-bold">{{ $pendaftaran->jurusanPilihan1?->nama_jurusan ?? 'N/A' }}</p>
                        <p class="mb-0 small text-muted">Pilihan 2: {{ $pendaftaran->jurusanPilihan2?->nama_jurusan ?? 'N/A' }}</p>
                    </div>
                    <hr>
                    <a href="{{ route('user.status') }}" class="btn btn-primary w-100 btn-sm">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
        @endif
        
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bolt me-2"></i>
                Aksi Cepat
            </div>
            <div class="card-body">
                <a href="{{ route('user.dokumen.create') }}" class="btn btn-primary w-100 mb-2">
                    <i class="fas fa-cloud-upload-alt"></i> Upload Dokumen
                </a>
                <a href="{{ route('user.dokumen') }}" class="btn btn-outline-primary w-100 mb-2">
                    <i class="fas fa-folder"></i> Kelola Dokumen
                </a>
                @if($pendaftaran && $pendaftaran->pembayaran && $pendaftaran->pembayaran->statusPembayaran->nama === 'LUNAS')
                    <a href="{{ route('cetak.kartu', ['pendaftaranId' => $pendaftaran->id]) }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-print"></i> Cetak Kartu
                    </a>
                @else
                    <button class="btn btn-outline-secondary w-100" disabled title="Pembayaran harus lunas untuk mencetak kartu">
                        <i class="fas fa-print"></i> Cetak Kartu (Tunggu Pembayaran)
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
