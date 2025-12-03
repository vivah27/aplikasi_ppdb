<?php $__env->startSection('title', 'Laporan & Eksport Data'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header mb-4">
    <h1 class="page-title">
        <i class="fas fa-file-download me-2"></i>
        Laporan & Eksport Data
    </h1>
    <p class="page-subtitle">Download data pendaftaran dan dokumen dalam format CSV</p>
</div>

<div class="row g-3">
    <!-- Statistik Cards -->
    <div class="col-12 col-md-3">
        <div class="stat-card primary">
            <div>
                <div class="stat-value"><?php echo e($totalSiswa); ?></div>
                <div class="stat-label">Total Siswa</div>
            </div>
            <i class="fas fa-users stat-icon primary"></i>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="stat-card success">
            <div>
                <div class="stat-value"><?php echo e($totalPendaftaran); ?></div>
                <div class="stat-label">Total Pendaftaran</div>
            </div>
            <i class="fas fa-file-alt stat-icon success"></i>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="stat-card warning">
            <div>
                <div class="stat-value"><?php echo e($totalDokumen); ?></div>
                <div class="stat-label">Total Dokumen</div>
            </div>
            <i class="fas fa-folder stat-icon warning"></i>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="stat-card info">
            <div>
                <div class="stat-value"><?php echo e(now()->format('d M Y')); ?></div>
                <div class="stat-label">Tanggal Hari Ini</div>
            </div>
            <i class="fas fa-calendar stat-icon info"></i>
        </div>
    </div>
</div>

<div class="row g-3 mt-3">
    <!-- Pendaftaran Export -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-users-cog me-2"></i>
                <strong>Data Pendaftaran</strong>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Export semua data pendaftaran siswa termasuk nama, email, jurusan pilihan, dan status pendaftaran.</p>
                <div class="list-group mb-3">
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Format CSV</h6>
                                <small class="text-muted">Include: Nomor Pendaftaran, Nama, Email, Sekolah, Jurusan, Status</small>
                            </div>
                            <a href="<?php echo e(route('admin.reports.export.pendaftaran')); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-download me-2"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
                <a href="<?php echo e(route('admin.reports.statistics')); ?>" class="btn btn-outline-primary w-100">
                    <i class="fas fa-chart-pie me-2"></i>Lihat Statistik
                </a>
            </div>
        </div>
    </div>

    <!-- Dokumen Export -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-file-upload me-2"></i>
                <strong>Data Dokumen</strong>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Export semua data dokumen yang telah diupload siswa termasuk jenis dokumen, status verifikasi, dan tanggal upload.</p>
                <div class="list-group mb-3">
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Format CSV</h6>
                                <small class="text-muted">Include: Nama Siswa, Jenis Dokumen, Status, Tanggal</small>
                            </div>
                            <a href="<?php echo e(route('admin.reports.export.dokumen')); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-download me-2"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Log Export -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-history me-2"></i>
                <strong>Log Aktivitas</strong>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Export riwayat aktivitas pengguna termasuk aksi yang dilakukan, waktu, dan IP address untuk audit trail dan keamanan.</p>
                <div class="list-group mb-3">
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Format CSV</h6>
                                <small class="text-muted">Include: User, Aksi, Deskripsi, IP, Waktu</small>
                            </div>
                            <a href="<?php echo e(route('admin.reports.export.activity-log')); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-download me-2"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Info -->
    <div class="col-12 col-lg-6">
        <div class="card bg-light">
            <div class="card-header">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Informasi Laporan</strong>
            </div>
            <div class="card-body">
                <p class="mb-3"><strong>Format File:</strong> CSV (Comma Separated Values)</p>
                <p class="mb-3"><strong>Kompatibilitas:</strong> Microsoft Excel, Google Sheets, LibreOffice</p>
                <p class="mb-3"><strong>Encoding:</strong> UTF-8 (support karakter Indonesia)</p>
                
                <hr>
                
                <h6>Panduan Penggunaan:</h6>
                <ol class="small">
                    <li>Klik tombol Download untuk mengekspor data</li>
                    <li>File akan terunduh dalam format CSV</li>
                    <li>Buka dengan Excel atau aplikasi spreadsheet lainnya</li>
                    <li>Lakukan filter, sort, atau analisis sesuai kebutuhan</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        border-radius: 12px;
        color: white;
    }

    .stat-card.primary {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
    }

    .stat-card.success {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    }

    .stat-card.warning {
        background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
    }

    .stat-card.info {
        background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%);
    }

    .stat-value {
        font-size: 28px;
        font-weight: bold;
    }

    .stat-label {
        font-size: 12px;
        opacity: 0.9;
        margin-top: 5px;
    }

    .stat-icon {
        font-size: 40px;
        opacity: 0.2;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        padding: 15px 20px;
    }

    .list-group-item {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 15px;
    }

    .list-group-item h6 {
        color: #1f2937;
        margin-bottom: 5px;
    }

    .btn-outline-primary {
        border-color: #4f46e5;
        color: #4f46e5;
    }

    .btn-outline-primary:hover {
        background-color: #4f46e5;
        color: white;
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppdb_denico_09\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>