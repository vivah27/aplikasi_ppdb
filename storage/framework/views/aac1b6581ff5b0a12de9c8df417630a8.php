<?php $__env->startSection('page_title', 'Cetak Dokumen'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-print"></i> Cetak Dokumen PPDB
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if(!isset($pendaftaran) || !$pendaftaran): ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> 
                            Anda belum melakukan pendaftaran. Silakan <a href="<?php echo e(route('formulir.index')); ?>">daftar terlebih dahulu</a>.
                        </div>
                    <?php else: ?>
                        <!-- Status Pembayaran -->
                        <?php
                            // Check pembayaran status - admin verifikasi set status = "Terverifikasi" di kolom status
                            $pembayaranLunas = false;
                            
                            // DEBUG: Force load pembayaran if not already loaded
                            if ($pendaftaran && !$pendaftaran->relationLoaded('pembayaran')) {
                                $pendaftaran->load('pembayaran.statusPembayaran');
                            }
                            
                            if ($pendaftaran && $pendaftaran->pembayaran) {
                                $pembayaran = $pendaftaran->pembayaran;
                                // Check status field (from admin verification) - case insensitive
                                if ($pembayaran->status && strtoupper(trim($pembayaran->status)) === 'TERVERIFIKASI') {
                                    $pembayaranLunas = true;
                                }
                                // Also check statusPembayaran relationship if exists
                                elseif ($pembayaran->statusPembayaran && in_array(strtoupper($pembayaran->statusPembayaran->nama ?? ''), ['LUNAS', 'TERVERIFIKASI'])) {
                                    $pembayaranLunas = true;
                                }
                            }
                            
                            $pembayaranStatus = $pendaftaran && $pendaftaran->pembayaran ? ($pendaftaran->pembayaran->status ?? 'MENUNGGU VERIFIKASI') : 'TIDAK ADA';
                        ?>
                        <div class="alert <?php echo e($pembayaranLunas ? 'alert-success' : 'alert-warning'); ?> mb-4">
                            <strong>Status Pembayaran:</strong> 
                            <span class="badge <?php echo e($pembayaranLunas ? 'bg-success' : 'bg-warning'); ?>">
                                <?php echo e(strtoupper($pembayaranStatus)); ?>

                            </span>
                            <?php if(!$pembayaranLunas && $pendaftaran->pembayaran): ?>
                                <br>
                                <small>Menunggu verifikasi dari admin. Silakan hubungi admin untuk verifikasi pembayaran Anda.</small>
                            <?php elseif(!$pendaftaran->pembayaran): ?>
                                <br>
                                <small>Anda belum membuat pembayaran. <a href="<?php echo e(route('user.pembayaran.create')); ?>">Lakukan pembayaran sekarang</a></small>
                            <?php elseif($pembayaranLunas): ?>
                                <br>
                                <small class="text-success"><i class="fas fa-check-circle"></i> Pembayaran Anda telah diverifikasi oleh admin!</small>
                            <?php endif; ?>
                        </div>

                        <!-- Tombol Cetak -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                        <h6>Formulir Pendaftaran</h6>
                                        <p class="text-muted small">Cetak formulir lengkap dengan data pribadi</p>
                                        <a href="<?php echo e(route('cetak.formulir', ['pendaftaranId' => $pendaftaran->id])); ?>" class="btn btn-sm btn-danger" target="_blank">
                                            <i class="fas fa-print"></i> Tampilkan
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-id-card fa-3x text-success mb-3"></i>
                                        <h6>Kartu Peserta</h6>
                                        <p class="text-muted small">
                                            <?php if($pembayaranLunas): ?>
                                                Cetak kartu peserta ujian
                                            <?php else: ?>
                                                (Hanya untuk pembayaran terverifikasi)
                                            <?php endif; ?>
                                        </p>
                                        <?php if($pembayaranLunas): ?>
                                            <a href="<?php echo e(route('cetak.kartu', ['pendaftaranId' => $pendaftaran->id])); ?>" class="btn btn-sm btn-success" target="_blank">
                                                <i class="fas fa-print"></i> Tampilkan
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-secondary" disabled title="Pembayaran belum diverifikasi admin">
                                                <i class="fas fa-lock"></i> Terkunci
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-receipt fa-3x text-info mb-3"></i>
                                        <h6>Kuitansi Pembayaran</h6>
                                        <p class="text-muted small">
                                            <?php if($pembayaranLunas): ?>
                                                Cetak bukti pembayaran
                                            <?php else: ?>
                                                (Hanya untuk pembayaran terverifikasi)
                                            <?php endif; ?>
                                        </p>
                                        <?php if($pembayaranLunas && $pendaftaran->pembayaran): ?>
                                            <a href="<?php echo e(route('cetak.kuitansi', ['pembayaranId' => $pendaftaran->pembayaran->id])); ?>" class="btn btn-sm btn-info" target="_blank">
                                                <i class="fas fa-print"></i> Tampilkan
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-secondary" disabled title="Pembayaran belum diverifikasi admin">
                                                <i class="fas fa-lock"></i> Terkunci
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Riwayat Cetak -->
                        <div class="mt-4">
                            <h6>
                                <i class="fas fa-history"></i> Riwayat Cetak
                            </h6>
                            <hr>

                            <?php if($berkasCetak->count() > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Jenis Dokumen</th>
                                                <th>Tanggal Cetak</th>
                                                <th>Informasi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $berkasCetak; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $berkas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <span class="badge bg-primary">
                                                            <?php echo e($berkas->jenisBerkas->nama ?? 'UNKNOWN'); ?>

                                                        </span>
                                                    </td>
                                                    <td>
                                                        <small><?php echo e($berkas->created_at->format('d/m/Y H:i')); ?></small>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $meta = json_decode($berkas->meta, true);
                                                        ?>
                                                        <small class="text-muted">
                                                            <?php if($meta && isset($meta['nama'])): ?>
                                                                <?php echo e($meta['nama']); ?>

                                                            <?php elseif($meta && isset($meta['jumlah'])): ?>
                                                                Rp <?php echo e(number_format($meta['jumlah'], 0, ',', '.')); ?>

                                                            <?php else: ?>
                                                                -
                                                            <?php endif; ?>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo e(route('cetak.download', $berkas->id)); ?>" class="btn btn-xs btn-outline-primary" title="Download">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>

                                <?php echo e($berkasCetak->links()); ?>

                            <?php else: ?>
                                <div class="alert alert-secondary text-center">
                                    <i class="fas fa-inbox"></i> Belum ada dokumen yang dicetak
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .btn-xs {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }

    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .card-header {
        border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppdb_denico_09\resources\views/cetak/index.blade.php ENDPATH**/ ?>