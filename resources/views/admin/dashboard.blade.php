@extends('layouts.master')

@section('page_title', 'Admin Dashboard')

@section('content')
<style>
    .dashboard-header {
        padding: 24px 0 32px 0;
        margin-bottom: 24px;
    }
    .dashboard-title {
        font-size: 32px;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 8px 0;
    }
    .dashboard-subtitle {
        color: #6b7280;
        font-size: 14px;
        margin: 0;
    }
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        border-radius: 4px;
    }
    .stat-card.primary::before { background: #4f46e5; }
    .stat-card.success::before { background: #10b981; }
    .stat-card.warning::before { background: #f59e0b; }
    .stat-card.info::before { background: #0ea5e9; }
    .stat-content {
        flex: 1;
    }
    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #1f2937;
        line-height: 1;
        margin-bottom: 8px;
    }
    .stat-label {
        font-size: 14px;
        color: #6b7280;
        font-weight: 500;
    }
    .stat-icon {
        font-size: 40px;
        opacity: 0.15;
        margin-left: 16px;
    }
    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin: 32px 0 20px 0;
        padding-bottom: 12px;
        border-bottom: 2px solid #e5e7eb;
    }
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    .card-header {
        background: #f9fafb;
        padding: 16px 20px;
        border-bottom: 1px solid #e5e7eb;
        font-weight: 600;
        color: #1f2937;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-body {
        padding: 20px;
    }
    .status-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 16px;
        margin-bottom: 30px;
    }
    .status-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    .status-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 24px;
        color: white;
    }
    .status-icon.success { background: #10b981; }
    .status-icon.warning { background: #f59e0b; }
    .status-icon.danger { background: #ef4444; }
    .status-icon.info { background: #0ea5e9; }
    .status-number {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 4px;
    }
    .status-label {
        font-size: 12px;
        color: #6b7280;
    }
    .table-responsive {
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    table thead {
        background: #f9fafb;
    }
    table th {
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: #1f2937;
        border-bottom: 1px solid #e5e7eb;
    }
    table td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
    }
    table tbody tr:hover {
        background: #f9fafb;
    }
    .badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    .badge-success { background: rgba(16, 185, 129, 0.1); color: #047857; }
    .badge-warning { background: rgba(245, 158, 11, 0.1); color: #92400e; }
    .badge-danger { background: rgba(239, 68, 68, 0.1); color: #991b1b; }
    .badge-info { background: rgba(14, 165, 233, 0.1); color: #0c4a6e; }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #9ca3af;
    }
    .empty-state-icon {
        font-size: 40px;
        margin-bottom: 12px;
        opacity: 0.5;
    }
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 12px;
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        padding: 20px;
        border-radius: 12px;
    }
    .btn {
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 13px;
    }
    .btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: white;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
    .btn-secondary {
        background: #e5e7eb;
        color: #1f2937;
    }
    .btn-secondary:hover {
        background: #d1d5db;
    }
    .list-group {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .list-item {
        padding: 16px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    .list-item:last-child {
        border-bottom: none;
    }
    .list-item-main h6 {
        margin: 0 0 4px 0;
        font-weight: 600;
        color: #1f2937;
        font-size: 13px;
    }
    .list-item-main p {
        margin: 0;
        font-size: 12px;
        color: #6b7280;
    }
</style>

<div class="dashboard-header">
    <h1 class="dashboard-title">📊 Dashboard PPDB SMK</h1>
    <p class="dashboard-subtitle">Selamat datang, {{ Auth::user()->name }}! • {{ now()->format('d F Y, H:i') }}</p>
</div>

<!-- QUICK STATS ROW -->
<div class="stat-cards-grid">
    <div class="stat-card primary">
        <div class="stat-content">
            <div class="stat-value">{{ $totalPendaftaran }}</div>
            <div class="stat-label">Total Pendaftar</div>
        </div>
        <div class="stat-icon">📋</div>
    </div>
    <div class="stat-card success">
        <div class="stat-content">
            <div class="stat-value">{{ $diterima }}</div>
            <div class="stat-label">Diterima</div>
        </div>
        <div class="stat-icon">✓</div>
    </div>
    <div class="stat-card warning">
        <div class="stat-content">
            <div class="stat-value">{{ $menunggu }}</div>
            <div class="stat-label">Menunggu Verifikasi</div>
        </div>
        <div class="stat-icon">⏳</div>
    </div>
    <div class="stat-card danger" style="border-left: 4px solid #ef4444;">
        <div class="stat-content">
            <div class="stat-value">{{ $ditolak }}</div>
            <div class="stat-label">Ditolak</div>
        </div>
        <div class="stat-icon">✕</div>
    </div>
</div>

<!-- DOKUMEN & RATE VERIFIKASI -->
<h2 class="section-title">📄 Status Dokumen</h2>
<div class="status-cards">
    <div class="status-card">
        <div class="status-icon info">📁</div>
        <div class="status-number">{{ $totalDokumen }}</div>
        <div class="status-label">Total Dokumen</div>
    </div>
    <div class="status-card">
        <div class="status-icon success">✓</div>
        <div class="status-number">{{ $dokumenTerverifikasi }}</div>
        <div class="status-label">Terverifikasi</div>
    </div>
    <div class="status-card">
        <div class="status-icon warning">⏳</div>
        <div class="status-number">{{ $dokumenTertunda }}</div>
        <div class="status-label">Menunggu</div>
    </div>
    <div class="status-card">
        <div class="status-icon info">📊</div>
        <div class="status-number">{{ round($verificationRate) }}%</div>
        <div class="status-label">Rate Verifikasi</div>
    </div>
</div>

<!-- MAIN CONTENT -->
<h2 class="section-title">🔄 Manajemen Pendaftaran</h2>
<div class="cards-grid">
    <!-- Action Required -->
    <div class="card">
        <div class="card-header">
            ⚡ Perlu Tindakan Segera
            <a href="{{ route('admin.verifikasi') }}" class="btn btn-primary" style="padding: 6px 12px;">Verifikasi</a>
        </div>
        <div class="card-body">
            @if($dokumenTertunda > 0)
                <div style="padding: 15px; background: rgba(245, 158, 11, 0.1); border-left: 4px solid #f59e0b; border-radius: 6px; margin-bottom: 15px;">
                    <strong style="color: #f59e0b;">{{ $dokumenTertunda }} dokumen</strong> menunggu verifikasi
                </div>
            @else
                <div style="padding: 15px; background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10b981; border-radius: 6px; margin-bottom: 15px;">
                    <strong style="color: #10b981;">Semua dokumen</strong> sudah terverifikasi ✓
                </div>
            @endif
            
            @if($menunggu > 0)
                <div style="padding: 15px; background: rgba(59, 130, 246, 0.1); border-left: 4px solid #3b82f6; border-radius: 6px;">
                    <strong style="color: #3b82f6;">{{ $menunggu }} pendaftar</strong> menunggu keputusan
                </div>
            @endif
        </div>
    </div>

    <!-- Registrations by Major -->
    <div class="card">
        <div class="card-header">
            🎓 Distribusi Jurusan
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary" style="padding: 6px 12px;">Lihat Detail</a>
        </div>
        <div class="card-body">
            @if($popularMajors->count() > 0)
                <ul class="list-group">
                    @foreach($popularMajors as $major)
                        <li class="list-item">
                            <div class="list-item-main">
                                <h6>{{ $major->nama ?? 'N/A' }}</h6>
                            </div>
                            <span class="badge badge-info" style="background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px;">{{ $major->total }} pendaftar</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="empty-state">
                    <p>Belum ada data jurusan</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Document Types -->
    <div class="card">
        <div class="card-header">
            📚 Jenis Dokumen
            <a href="{{ route('admin.jenis-dokumen.index') }}" class="btn btn-secondary" style="padding: 6px 12px;">Kelola</a>
        </div>
        <div class="card-body">
            @if($dokumenPerJenis->count() > 0)
                <ul class="list-group">
                    @foreach($dokumenPerJenis as $jenis)
                        <li class="list-item">
                            <div class="list-item-main">
                                <h6>{{ $jenis->nama ?? 'N/A' }}</h6>
                            </div>
                            <span class="badge badge-info" style="background: #f3f4f6; color: #1f2937; padding: 6px 12px; border-radius: 6px; font-size: 12px;">{{ $jenis->total }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="empty-state">
                    <p>Belum ada dokumen</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- DETAILED MANAGEMENT -->
<h2 class="section-title">📑 Daftar Pendaftar</h2>
<div class="cards-grid">
    <!-- Recent Registrations Table -->
    <div class="card" style="grid-column: 1 / -1;">
        <div class="card-header">
            👥 Pendaftar Terbaru
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-primary" style="padding: 6px 12px;">Lihat Semua</a>
        </div>
        <div class="card-body">
            @if($recentRegistrations->count() > 0)
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 25%;">Nama Pendaftar</th>
                                <th style="width: 20%;">Jurusan Pilihan</th>
                                <th style="width: 15%;">Tanggal Daftar</th>
                                <th style="width: 15%;">Status</th>
                                <th style="width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRegistrations as $reg)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $reg->siswa?->nama_lengkap ?? 'N/A' }}</strong><br>
                                        <small style="color: #9ca3af;">NISN: {{ $reg->siswa?->nisn ?? '-' }}</small>
                                    </td>
                                    <td>{{ $reg->jurusanPilihan1?->nama ?? '-' }}</td>
                                    <td>{{ $reg->created_at->format('d M Y') }}</td>
                                    <td>
                                        @php
                                            $statusLabel = $reg->statusPendaftaran?->label ?? 'Menunggu';
                                            $statusClass = match($statusLabel) {
                                                'Diterima' => 'success',
                                                'Menunggu' => 'warning',
                                                'Ditolak' => 'danger',
                                                default => 'info'
                                            };
                                        @endphp
                                        <span class="badge" style="background: {{ $statusClass === 'success' ? '#d1fae5' : ($statusClass === 'warning' ? '#fef3c7' : ($statusClass === 'danger' ? '#fee2e2' : '#dbeafe')) }}; color: {{ $statusClass === 'success' ? '#065f46' : ($statusClass === 'warning' ? '#78350f' : ($statusClass === 'danger' ? '#7f1d1d' : '#0c2d6b')) }}; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                            <a href="{{ route('admin.verifikasi') }}" class="btn btn-secondary" style="padding: 6px 10px; font-size: 11px;">
                                                <i class="fas fa-file-check"></i> Verifikasi
                                            </a>
                                            @if($statusLabel === 'Menunggu')
                                                <form action="{{ route('admin.pendaftaran.accept', $reg->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" style="padding: 6px 10px; background: linear-gradient(135deg, #10b981 0%, #34d399 100%); color: white; border: none; border-radius: 6px; font-size: 11px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;" title="Terima">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.pendaftaran.reject', $reg->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menolak?')">
                                                    @csrf
                                                    <button type="submit" style="padding: 6px 10px; background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); color: white; border: none; border-radius: 6px; font-size: 11px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;" title="Tolak">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="padding: 40px; text-align: center;">
                    <div style="font-size: 40px; margin-bottom: 15px; opacity: 0.3;">📭</div>
                    <p style="color: #6b7280;">Belum ada pendaftar</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- MONITORING -->
<h2 class="section-title">📊 Monitoring Dokumen</h2>
<div class="cards-grid">
    <!-- Recent Documents -->
    <div class="card">
        <div class="card-header">
            📄 Dokumen Terbaru
            <a href="{{ route('admin.verifikasi') }}" class="btn btn-primary" style="padding: 6px 12px;">Verifikasi</a>
        </div>
        <div class="card-body">
            @if($recentDocuments->count() > 0)
                <ul class="list-group">
                    @foreach($recentDocuments->take(8) as $doc)
                        <li class="list-item">
                            <div class="list-item-main">
                                <h6>{{ $doc->jenisDokumen?->nama ?? 'N/A' }}</h6>
                                <p>{{ $doc->siswa?->nama_lengkap ?? 'N/A' }} • {{ $doc->created_at->diffForHumans() }}</p>
                            </div>
                            @php
                                $statusClass = match($doc->statusVerifikasi?->label ?? '') {
                                    'Terverifikasi' => 'success',
                                    'Menunggu Verifikasi' => 'warning',
                                    'Ditolak' => 'danger',
                                    default => 'info'
                                };
                            @endphp
                            <span class="badge badge-{{ $statusClass }}">{{ $doc->statusVerifikasi?->label ?? '-' }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="empty-state">
                    <p>Belum ada dokumen</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="card">
        <div class="card-header">🔔 Aktivitas Terbaru</div>
        <div class="card-body">
            @if($recentVerifications->count() > 0)
                <ul class="list-group">
                    @foreach($recentVerifications->take(8) as $verify)
                        <li class="list-item">
                            <div class="list-item-main">
                                <h6>✓ {{ ucfirst($verify->tipe) }} Terverifikasi</h6>
                                <p>{{ $verify->pendaftaran?->siswa?->nama_lengkap ?? 'N/A' }}<br><small style="color: #9ca3af;">{{ $verify->tanggal_verifikasi->diffForHumans() }}</small></p>
                            </div>
                            <span class="badge" style="background: {{ $verify->status?->kode === 'verified' ? '#d1fae5' : ($verify->status?->kode === 'pending' ? '#fef3c7' : '#fee2e2') }}; color: {{ $verify->status?->kode === 'verified' ? '#065f46' : ($verify->status?->kode === 'pending' ? '#78350f' : '#7f1d1d') }}; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                {{ $verify->status?->label ?? '-' }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="empty-state">
                    <p>Belum ada aktivitas</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- QUICK ACTIONS -->
<h2 class="section-title">⚡ Menu Cepat Admin PPDB</h2>
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
    <a href="{{ route('admin.verifikasi') }}" style="padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); text-decoration: none; border-left: 4px solid #4f46e5; transition: all 0.3s;">
        <div style="font-size: 24px; margin-bottom: 10px;">✓</div>
        <div style="font-weight: 600; color: #1f2937; margin-bottom: 5px;">Verifikasi Dokumen</div>
        <div style="font-size: 13px; color: #6b7280;">{{ $dokumenTertunda }} dokumen menunggu</div>
    </a>
    <a href="{{ route('admin.jenis-dokumen.index') }}" style="padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); text-decoration: none; border-left: 4px solid #f59e0b; transition: all 0.3s;">
        <div style="font-size: 24px; margin-bottom: 10px;">📄</div>
        <div style="font-weight: 600; color: #1f2937; margin-bottom: 5px;">Jenis Dokumen</div>
        <div style="font-size: 13px; color: #6b7280;">Kelola jenis dokumen</div>
    </a>
    <a href="{{ route('admin.siswa.index') }}" style="padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); text-decoration: none; border-left: 4px solid #10b981; transition: all 0.3s;">
        <div style="font-size: 24px; margin-bottom: 10px;">👥</div>
        <div style="font-weight: 600; color: #1f2937; margin-bottom: 5px;">Data Siswa</div>
        <div style="font-size: 13px; color: #6b7280;">{{ $totalPendaftaran }} pendaftar</div>
    </a>
    <a href="{{ route('admin.peran.index') }}" style="padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); text-decoration: none; border-left: 4px solid #8b5cf6; transition: all 0.3s;">
        <div style="font-size: 24px; margin-bottom: 10px;">🔐</div>
        <div style="font-weight: 600; color: #1f2937; margin-bottom: 5px;">Manajemen Peran</div>
        <div style="font-size: 13px; color: #6b7280;">Kelola akses pengguna</div>
    </a>
    <a href="{{ route('admin.reports.index') }}" style="padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); text-decoration: none; border-left: 4px solid #0ea5e9; transition: all 0.3s;">
        <div style="font-size: 24px; margin-bottom: 10px;">📊</div>
        <div style="font-weight: 600; color: #1f2937; margin-bottom: 5px;">Laporan & Export</div>
        <div style="font-size: 13px; color: #6b7280;">Lihat statistik lengkap</div>
    </a>
    <a href="{{ route('admin.dashboard') }}" style="padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); text-decoration: none; border-left: 4px solid #ec4899; transition: all 0.3s;">
        <div style="font-size: 24px; margin-bottom: 10px;">🔄</div>
        <div style="font-weight: 600; color: #1f2937; margin-bottom: 5px;">Refresh Dashboard</div>
        <div style="font-size: 13px; color: #6b7280;">Perbarui data terbaru</div>
    </a>
</div>
@endsection
