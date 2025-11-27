@extends('layouts.master')

@section('page_title', 'Status Seleksi')

@section('content')
<style>
    .status-header {
        padding: 24px 0 32px 0;
        margin-bottom: 24px;
    }
    .status-title {
        font-size: 32px;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 8px 0;
    }
    .status-subtitle {
        color: #6b7280;
        font-size: 14px;
        margin: 0;
    }
    .status-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }
    .status-main {
        text-align: center;
        padding: 40px 20px;
    }
    .status-icon-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 40px;
        color: white;
    }
    .status-icon-large.success { background: linear-gradient(135deg, #10b981 0%, #34d399 100%); }
    .status-icon-large.warning { background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); }
    .status-icon-large.danger { background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); }
    .status-icon-large.info { background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%); }
    .status-label {
        font-size: 16px;
        color: #6b7280;
        margin-bottom: 8px;
    }
    .status-value {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
    }
    .progress-timeline {
        margin: 30px 0;
    }
    .timeline-step {
        display: flex;
        align-items: flex-start;
        margin-bottom: 30px;
        position: relative;
    }
    .timeline-step:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 39px;
        top: 60px;
        width: 2px;
        height: 30px;
        background: #e5e7eb;
    }
    .timeline-step.completed:not(:last-child)::after {
        background: #10b981;
    }
    .timeline-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f3f4f6;
        border: 3px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }
    .timeline-step.completed .timeline-circle {
        background: #10b981;
        border-color: #10b981;
        color: white;
    }
    .timeline-step.active .timeline-circle {
        background: #4f46e5;
        border-color: #4f46e5;
        color: white;
        box-shadow: 0 0 0 8px rgba(79, 70, 229, 0.1);
    }
    .timeline-step.pending .timeline-circle {
        background: #f3f4f6;
        border-color: #e5e7eb;
        color: #9ca3af;
    }
    .timeline-content {
        margin-left: 30px;
        flex: 1;
    }
    .timeline-title {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
        font-size: 16px;
    }
    .timeline-description {
        color: #6b7280;
        font-size: 14px;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }
    .info-box {
        background: #f9fafb;
        padding: 20px;
        border-radius: 8px;
        border-left: 4px solid #4f46e5;
    }
    .info-label {
        font-size: 12px;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .info-value {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-icon {
        font-size: 60px;
        margin-bottom: 20px;
        opacity: 0.5;
    }
    .empty-title {
        font-size: 20px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
    }
    .empty-description {
        color: #6b7280;
        margin-bottom: 24px;
    }
    .btn {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
    }
    .btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: white;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
</style>

<div class="status-header">
    <h1 class="status-title">Status Seleksi</h1>
    <p class="status-subtitle">Pantau perkembangan proses pendaftaran Anda</p>
</div>

@if(Auth::user()->siswa)
    @php
        $siswa = Auth::user()->siswa;
        $pendaftaran = $siswa->pendaftaran()->first();
    @endphp

    @if($pendaftaran)
        <div class="status-card">
            <div class="status-main">
                @php
                    $status = $pendaftaran->statusPendaftaran;
                    $statusLabel = $status ? $status->label : 'Menunggu';
                    $statusClass = match($statusLabel) {
                        'Diterima' => 'success',
                        'Menunggu' => 'warning',
                        'Ditolak' => 'danger',
                        default => 'info'
                    };
                @endphp
                <div class="status-icon-large {{ $statusClass }}">
                    @if($statusClass === 'success')
                        ✓
                    @elseif($statusClass === 'warning')
                        ⏳
                    @elseif($statusClass === 'danger')
                        ✕
                    @else
                        ?
                    @endif
                </div>
                <div class="status-label">Status Saat Ini</div>
                <div class="status-value">{{ $statusLabel }}</div>
            </div>

            <!-- PROGRESS TIMELINE -->
            <div class="progress-timeline">
                @php
                    // Check if formulir is actually completed (not just exists)
                    $isFormulirComplete = $pendaftaran && 
                        !empty($pendaftaran->tahun_ajaran) && 
                        !empty($pendaftaran->jalur_pendaftaran) && 
                        !empty($pendaftaran->gelombang) && 
                        !empty($pendaftaran->jurusan_pilihan_1) && 
                        !empty($pendaftaran->rata_nilai);
                    
                    // Check if required documents are uploaded
                    $requiredDocs = \App\Models\JenisDokumen::where('wajib', true)->pluck('id')->toArray();
                    $uploadedDocIds = $siswa && $siswa->dokumen ? $siswa->dokumen()->pluck('jenis_dokumen_id')->toArray() : [];
                    $allRequiredDocsUploaded = count($requiredDocs) > 0 && 
                                              count($uploadedDocIds) > 0 && 
                                              count(array_intersect($requiredDocs, $uploadedDocIds)) == count($requiredDocs);
                    
                    $statusLabel = $status->label ?? 'Menunggu';
                    
                    $steps = [
                        ['title' => 'Pendaftaran', 'description' => 'Akun telah dibuat', 'status' => 'completed'],
                        ['title' => 'Isi Formulir', 'description' => 'Data diri lengkap', 'status' => $isFormulirComplete ? 'completed' : 'pending'],
                        ['title' => 'Upload Dokumen', 'description' => 'Dokumen diverifikasi', 'status' => $allRequiredDocsUploaded ? 'completed' : 'pending'],
                        ['title' => 'Hasil Seleksi', 'description' => 'Pengumuman hasil akhir', 'status' => ($statusLabel === 'Diterima' || $statusLabel === 'Ditolak') ? 'completed' : ($statusLabel === 'Menunggu' ? 'active' : 'pending')],
                    ];
                @endphp

                @foreach($steps as $step)
                    <div class="timeline-step {{ $step['status'] }}">
                        <div class="timeline-circle">
                            @if($step['status'] === 'completed')
                                ✓
                            @elseif($step['status'] === 'active')
                                →
                            @else
                                ●
                            @endif
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">{{ $step['title'] }}</div>
                            <div class="timeline-description">{{ $step['description'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- INFO BOXES -->
            <div class="info-grid">
                <div class="info-box">
                    <div class="info-label">Nomor Pendaftaran</div>
                    <div class="info-value">{{ $pendaftaran->nomor_pendaftaran ?? '-' }}</div>
                </div>
                <div class="info-box">
                    <div class="info-label">Tanggal Daftar</div>
                    <div class="info-value">{{ $pendaftaran->created_at->format('d M Y') }}</div>
                </div>
                <div class="info-box">
                    <div class="info-label">Jurusan Pilihan</div>
                    <div class="info-value">{{ $pendaftaran->jurusanPilihan1->nama ?? '-' }}</div>
                </div>
                <div class="info-box">
                    <div class="info-label">Dokumen Diunggah</div>
                    <div class="info-value">{{ $siswa->dokumen()->count() ?? 0 }} file</div>
                </div>
            </div>
        </div>

        <!-- NEXT STEPS -->
        @if($statusLabel === 'Menunggu')
            <div class="status-card">
                <h3 style="margin-top: 0;">Langkah Selanjutnya</h3>
                <p style="color: #6b7280; margin: 8px 0 20px 0;">Untuk memastikan aplikasi Anda diproses dengan baik, silakan:</p>
                <ol style="color: #1f2937; line-height: 2;">
                    <li>Pastikan semua dokumen sudah diupload dengan lengkap</li>
                    <li>Periksa format dokumen sesuai persyaratan (PDF/JPG, max 5MB)</li>
                    <li>Tunggu hasil seleksi dalam waktu yang telah ditentukan</li>
                    <li>Hubungi admin jika ada pertanyaan</li>
                </ol>
            </div>
        @elseif($statusLabel === 'Diterima')
            <div class="status-card" style="border-left: 4px solid #10b981;">
                <h3 style="margin-top: 0; color: #10b981;">🎉 Selamat!</h3>
                <p style="color: #6b7280;">Anda telah diterima sebagai siswa di sekolah kami. Silakan cetak kartu kelulusan untuk melanjutkan proses pendaftaran ulang (daftar ulang).</p>
                <a href="{{ route('cetak.kartu', $pendaftaran->id) }}" class="btn btn-primary">Cetak Kartu Kelulusan</a>
            </div>
        @elseif($statusLabel === 'Ditolak')
            <div class="status-card" style="border-left: 4px solid #ef4444;">
                <h3 style="margin-top: 0; color: #ef4444;">Mohon Maaf</h3>
                <p style="color: #6b7280;">Sayangnya, Anda belum diterima dalam kesempatan ini. Namun jangan menyerah! Silakan hubungi sekolah untuk mendapatkan feedback dan kesempatan di periode berikutnya.</p>
            </div>
        @endif
    @else
        <div class="status-card">
            <div class="empty-state">
                <div class="empty-icon">📋</div>
                <div class="empty-title">Belum Ada Data Pendaftaran</div>
                <p class="empty-description">Anda belum mengisi formulir pendaftaran. Silakan isi formulir terlebih dahulu untuk melanjutkan proses seleksi.</p>
                <a href="{{ route('formulir.index') }}" class="btn btn-primary">Isi Formulir Sekarang</a>
            </div>
        </div>
    @endif
@else
    <div class="status-card">
        <div class="empty-state">
            <div class="empty-icon">⚠️</div>
            <div class="empty-title">Data Tidak Ditemukan</div>
            <p class="empty-description">Sistem tidak dapat menemukan data siswa Anda. Silakan hubungi admin untuk bantuan.</p>
        </div>
    </div>
@endif
@endsection
