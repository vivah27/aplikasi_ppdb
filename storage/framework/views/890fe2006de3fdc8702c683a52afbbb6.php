

<?php $__env->startSection('page_title', 'Detail Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <a href="<?php echo e(route('admin.pembayaran.index')); ?>" class="btn btn-outline-secondary btn-sm me-2">
                <i class="ti ti-arrow-left"></i>
            </a>
            Detail Pembayaran #<?php echo e($pembayaran->id); ?>

        </h1>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Informasi Pembayaran -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="ti ti-info-circle me-2"></i>Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><small>Nama Pembayaran</small></p>
                            <p class="fw-bold"><?php echo e($pembayaran->nama); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><small>Metode Pembayaran</small></p>
                            <p class="fw-bold"><?php echo e($pembayaran->metode); ?></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><small>Jumlah Pembayaran</small></p>
                            <p class="fw-bold text-success" style="font-size: 1.25rem;">
                                Rp <?php echo e(number_format($pembayaran->jumlah, 0, ',', '.')); ?>

                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><small>Status</small></p>
                            <p>
                                <?php
                                    $statusColor = match($pembayaran->status) {
                                        'Menunggu Verifikasi' => 'warning',
                                        'Terverifikasi' => 'success',
                                        'Ditolak' => 'danger',
                                        default => 'secondary'
                                    };
                                ?>
                                <span class="badge bg-<?php echo e($statusColor); ?>" style="font-size: 0.9rem; padding: 0.5rem 0.75rem;">
                                    <?php echo e($pembayaran->status); ?>

                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><small>Tanggal Upload</small></p>
                            <p><?php echo e($pembayaran->created_at->format('d F Y \p\u\k\u\l H:i')); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><small>Diperbarui</small></p>
                            <p><?php echo e($pembayaran->updated_at->format('d F Y \p\u\k\u\l H:i')); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Transfer/E-Wallet -->
            <?php if($pembayaran->metode === 'Transfer Bank' || str_contains($pembayaran->metode, 'Transfer')): ?>
                <div class="card shadow-sm mb-4 border-info">
                    <div class="card-header bg-info bg-opacity-10">
                        <h5 class="mb-0 text-info"><i class="ti ti-building-bank me-2"></i>Detail Transfer Bank</h5>
                    </div>
                    <div class="card-body">
                        <?php if($pembayaran->nama_bank): ?>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="text-muted mb-1"><small>Nama Bank</small></p>
                                    <p class="fw-bold"><?php echo e($pembayaran->nama_bank); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted mb-1"><small>Nomor Rekening</small></p>
                                    <p class="fw-bold font-monospace"><?php echo e($pembayaran->nomor_rekening); ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="text-muted mb-1"><small>Atas Nama Rekening</small></p>
                                    <p class="fw-bold"><?php echo e($pembayaran->atas_nama_rekening); ?></p>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="text-muted"><small>Tidak ada detail transfer bank</small></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php elseif($pembayaran->metode === 'E-Wallet' || str_contains($pembayaran->metode, 'Wallet')): ?>
                <div class="card shadow-sm mb-4 border-success">
                    <div class="card-header bg-success bg-opacity-10">
                        <h5 class="mb-0 text-success"><i class="ti ti-wallet me-2"></i>Detail E-Wallet</h5>
                    </div>
                    <div class="card-body">
                        <?php if($pembayaran->jenis_ewallet): ?>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="text-muted mb-1"><small>Jenis E-Wallet</small></p>
                                    <p class="fw-bold"><?php echo e($pembayaran->jenis_ewallet); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted mb-1"><small>Nomor/ID E-Wallet</small></p>
                                    <p class="fw-bold font-monospace"><?php echo e($pembayaran->nomor_ewallet); ?></p>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="text-muted"><small>Tidak ada detail e-wallet</small></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Bukti Pembayaran -->
            <?php if($pembayaran->bukti): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="ti ti-file me-2"></i>Bukti Pembayaran</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="<?php echo e(asset('storage/' . $pembayaran->bukti)); ?>" 
                             alt="Bukti Pembayaran" class="img-fluid rounded" style="max-height: 400px;">
                        <div class="mt-3">
                            <a href="<?php echo e(asset('storage/' . $pembayaran->bukti)); ?>" 
                               target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="ti ti-external-link me-1"></i>Buka Gambar
                            </a>
                            <a href="<?php echo e(asset('storage/' . $pembayaran->bukti)); ?>" 
                               download class="btn btn-outline-secondary btn-sm">
                                <i class="ti ti-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Catatan -->
            <?php if($pembayaran->catatan): ?>
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="ti ti-notes me-2"></i>Catatan Admin</h5>
                    </div>
                    <div class="card-body">
                        <p><?php echo e($pembayaran->catatan); ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <!-- Action Card -->
            <?php if($pembayaran->status === 'Menunggu Verifikasi'): ?>
                <div class="card shadow-sm mb-3 border-warning">
                    <div class="card-header bg-warning bg-opacity-10">
                        <h5 class="mb-0 text-warning"><i class="ti ti-alert-circle me-2"></i>Butuh Verifikasi</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted"><small>Pembayaran ini belum diverifikasi. Silahkan lakukan verifikasi.</small></p>
                        <div class="d-grid gap-2">
                            <a href="<?php echo e(route('admin.pembayaran.edit', $pembayaran->id)); ?>" 
                               class="btn btn-primary">
                                <i class="ti ti-edit me-1"></i>Verifikasi Pembayaran
                            </a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="card shadow-sm mb-3 <?php echo e($pembayaran->status === 'Terverifikasi' ? 'border-success' : 'border-danger'); ?>">
                    <div class="card-header <?php echo e($pembayaran->status === 'Terverifikasi' ? 'bg-success bg-opacity-10' : 'bg-danger bg-opacity-10'); ?>">
                        <h5 class="mb-0 <?php echo e($pembayaran->status === 'Terverifikasi' ? 'text-success' : 'text-danger'); ?>">
                            <i class="ti <?php echo e($pembayaran->status === 'Terverifikasi' ? 'ti-check' : 'ti-x'); ?> me-2"></i>
                            <?php echo e($pembayaran->status === 'Terverifikasi' ? 'Sudah Terverifikasi' : 'Telah Ditolak'); ?>

                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert <?php echo e($pembayaran->status === 'Terverifikasi' ? 'alert-success' : 'alert-danger'); ?> mb-0">
                            Pembayaran ini sudah di-<?php echo e(strtolower($pembayaran->status)); ?>.
                            <br><small>Diperbarui: <?php echo e($pembayaran->updated_at->format('d M Y H:i')); ?></small>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Quick Stats -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3"><i class="ti ti-calculator me-2"></i>Ringkasan</h6>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><small>ID Pembayaran</small></span>
                            <strong><?php echo e($pembayaran->id); ?></strong>
                        </div>
                        <div class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><small>Metode</small></span>
                            <strong><?php echo e($pembayaran->metode); ?></strong>
                        </div>
                        <div class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><small>Jumlah</small></span>
                            <strong>Rp <?php echo e(number_format($pembayaran->jumlah, 0, ',', '.')); ?></strong>
                        </div>
                        <div class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><small>Status</small></span>
                            <strong>
                                <span class="badge bg-<?php echo e(match($pembayaran->status) {
                                    'Menunggu Verifikasi' => 'warning',
                                    'Terverifikasi' => 'success',
                                    'Ditolak' => 'danger',
                                    default => 'secondary'
                                }); ?>"><?php echo e($pembayaran->status); ?></span>
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppdb_denico_09\resources\views/admin/pembayaran/show.blade.php ENDPATH**/ ?>