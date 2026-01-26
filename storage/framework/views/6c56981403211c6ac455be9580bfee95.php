<?php $__env->startSection('page_title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-tachometer-alt me-2"></i>
        Dashboard
    </h1>
    <p class="page-subtitle">Selamat datang, <?php echo e(Auth::user()->name); ?>! Berikut ringkasan data Anda.</p>
</div>

<!-- STAT CARDS ROW -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card primary">
            <div>
                <div class="stat-value"><?php echo e($statsData['total_siswa'] ?? 0); ?></div>
                <div class="stat-label">Total Siswa</div>
            </div>
            <i class="fas fa-users stat-icon primary"></i>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card success">
            <div>
                <div class="stat-value"><?php echo e($statsData['diterima'] ?? 0); ?></div>
                <div class="stat-label">Diterima</div>
            </div>
            <i class="fas fa-check-circle stat-icon success"></i>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card warning">
            <div>
                <div class="stat-value"><?php echo e($statsData['menunggu'] ?? 0); ?></div>
                <div class="stat-label">Menunggu</div>
            </div>
            <i class="fas fa-clock stat-icon warning"></i>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="stat-card danger">
            <div>
                <div class="stat-value"><?php echo e($statsData['ditolak'] ?? 0); ?></div>
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
                <?php if($recentDocuments->count() > 0): ?>
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
                                <?php $__currentLoopData = $recentDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fas fa-file-pdf text-danger"></i>
                                                <span><?php echo e($doc->jenisDokumen->nama ?? 'N/A'); ?></span>
                                            </div>
                                        </td>
                                        <td><?php echo e($doc->created_at->format('d M Y')); ?></td>
                                        <td>
                                            <?php
                                                $statusLabel = $doc->statusVerifikasi?->label ?? 'Menunggu Verifikasi';
                                                $statusBadgeClass = match($doc->statusVerifikasi?->kode ?? '') {
                                                    'verified' => 'success',
                                                    'pending' => 'warning',
                                                    'rejected' => 'danger',
                                                    'revision' => 'info',
                                                    default => 'warning'
                                                };
                                            ?>
                                            <span class="badge badge-<?php echo e($statusBadgeClass); ?>">
                                                <?php echo e($statusLabel); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('user.dokumen.download', $doc->id)); ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3" style="opacity: 0.3;"></i>
                        <p class="text-muted">Belum ada dokumen yang diupload</p>
                        <a href="<?php echo e(route('user.dokumen.create')); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Upload Dokumen
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- RIGHT COLUMN - Quick Actions & Info -->
    <div class="col-12 col-lg-4">
        <!-- Registration Status -->
        <?php if($pendaftaran): ?>
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2"></i>
                    Status Pendaftaran
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Nomor Pendaftaran</small>
                        <p class="mb-0 fw-bold"><?php echo e($pendaftaran->nomor_pendaftaran); ?></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Status</small>
                        <p class="mb-0">
                            <?php
                                $statusKode = $pendaftaran->statusPendaftaran?->kode ?? '';
                                $statusLabel = $pendaftaran->statusPendaftaran?->label ?? 'Unknown';
                                $badgeClass = match($statusKode) {
                                    'diterima' => 'success',
                                    'menunggu' => 'warning',
                                    'ditolak' => 'danger',
                                    default => 'secondary'
                                };
                            ?>
                            <span class="badge badge-<?php echo e($badgeClass); ?>">
                                <?php echo e($statusLabel); ?>

                            </span>
                        </p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Jurusan Pilihan</small>
                        <p class="mb-0 fw-bold"><?php echo e($pendaftaran->jurusanPilihan1?->nama_jurusan ?? 'N/A'); ?></p>
                        <p class="mb-0 small text-muted">Pilihan 2: <?php echo e($pendaftaran->jurusanPilihan2?->nama_jurusan ?? 'N/A'); ?></p>
                    </div>
                    <hr>
                    <a href="<?php echo e(route('user.status')); ?>" class="btn btn-primary w-100 btn-sm">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bolt me-2"></i>
                Aksi Cepat
            </div>
            <div class="card-body">
                <div style="display: flex; gap: 12px; align-items: flex-start;">
                    <a href="<?php echo e(route('user.dokumen.create')); ?>" class="quick-action-btn" title="Upload Dokumen">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="<?php echo e(route('user.dokumen')); ?>" class="quick-action-btn" title="Kelola Dokumen">
                        <i class="fas fa-edit"></i>
                    </a>
                    <?php if($pendaftaran && $pendaftaran->pembayaran && $pendaftaran->pembayaran->statusPembayaran && $pendaftaran->pembayaran->statusPembayaran->nama === 'LUNAS'): ?>
                        <a href="<?php echo e(route('cetak.kartu', ['pendaftaranId' => $pendaftaran->id])); ?>" class="quick-action-btn" title="Cetak Kartu">
                            <i class="fas fa-trash"></i>
                        </a>
                    <?php else: ?>
                        <button class="quick-action-btn" disabled title="Pembayaran harus lunas untuk mencetak kartu">
                            <i class="fas fa-trash"></i>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC_\aplikasi_ppdb\resources\views/dashboard.blade.php ENDPATH**/ ?>