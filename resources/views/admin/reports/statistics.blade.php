@extends('layouts.master')

@section('title', 'Statistik Laporan')

@section('content')
<div class="page-header mb-4">
    <h1 class="page-title">
        <i class="fas fa-chart-bar me-2"></i>
        Statistik Laporan
    </h1>
    <p class="page-subtitle">Ringkasan statistik pendaftaran, dokumen, dan jurusan</p>
</div>

<div class="row g-3">
    <!-- Status Pendaftaran -->
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header">
                <strong>Status Pendaftaran</strong>
            </div>
            <div class="card-body">
                @if($pendaftaranPerStatus->count() > 0)
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td><strong>Status</strong></td>
                            <td><strong>Jumlah</strong></td>
                            <td><strong>Persentase</strong></td>
                        </tr>
                        @php
                            $total = $pendaftaranPerStatus->sum('total');
                        @endphp
                        @foreach($pendaftaranPerStatus as $item)
                            <tr>
                                <td>{{ $item->label }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $item->total }}</span>
                                </td>
                                <td>
                                    {{ $total > 0 ? round(($item->total / $total) * 100, 1) : 0 }}%
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar" style="width: {{ $total > 0 ? ($item->total / $total) * 100 : 0 }}%"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <p class="text-muted small mt-3">Total: {{ $total }} pendaftaran</p>
                @else
                    <p class="text-muted text-center py-4">Belum ada data</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Status Dokumen -->
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header">
                <strong>Status Verifikasi Dokumen</strong>
            </div>
            <div class="card-body">
                @if($dokumenPerStatus->count() > 0)
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td><strong>Status</strong></td>
                            <td><strong>Jumlah</strong></td>
                            <td><strong>Persentase</strong></td>
                        </tr>
                        @php
                            $totalDok = $dokumenPerStatus->sum('total');
                        @endphp
                        @foreach($dokumenPerStatus as $item)
                            <tr>
                                <td>{{ $item->label }}</td>
                                <td>
                                    <span class="badge bg-warning">{{ $item->total }}</span>
                                </td>
                                <td>
                                    {{ $totalDok > 0 ? round(($item->total / $totalDok) * 100, 1) : 0 }}%
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-warning" style="width: {{ $totalDok > 0 ? ($item->total / $totalDok) * 100 : 0 }}%"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <p class="text-muted small mt-3">Total: {{ $totalDok }} dokumen</p>
                @else
                    <p class="text-muted text-center py-4">Belum ada data</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Siswa per Jurusan -->
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header">
                <strong>Distribusi Siswa per Jurusan</strong>
            </div>
            <div class="card-body">
                @if($siswaPerJurusan->count() > 0)
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td><strong>Jurusan</strong></td>
                            <td><strong>Jumlah</strong></td>
                        </tr>
                        @foreach($siswaPerJurusan as $item)
                            <tr>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    <span class="badge bg-success">{{ $item->total }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" style="width: {{ ($item->total / $siswaPerJurusan->sum('total')) * 100 }}%"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <p class="text-muted small mt-3">Total: {{ $siswaPerJurusan->sum('total') }} siswa</p>
                @else
                    <p class="text-muted text-center py-4">Belum ada data</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-3">
    <div class="col-12">
        <div class="card bg-light">
            <div class="card-body">
                <h5 class="mb-3">Kembali ke Laporan</h5>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Halaman Eksport
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        padding: 15px 20px;
        border-radius: 12px 12px 0 0;
    }

    .badge {
        padding: 5px 10px;
    }

    .progress {
        background-color: #e5e7eb;
    }

    table td {
        padding: 10px 0;
    }

    .page-header {
        padding: 20px 0;
    }

    .page-title {
        font-size: 28px;
        margin-bottom: 5px;
    }

    .page-subtitle {
        color: #6b7280;
    }
</style>

@endsection
