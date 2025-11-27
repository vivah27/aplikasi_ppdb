

<?php $__env->startSection('page_title', 'Verifikasi Dokumen'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="row mb-3">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.verifikasi')); ?>">Verifikasi Dokumen</a></li>
                    <li class="breadcrumb-item active">Edit Verifikasi</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- Dokumen Preview -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Preview Dokumen</h5>
                </div>
                <div class="card-body">
                    <?php if(str_ends_with($dokumen->path, '.pdf')): ?>
                        <embed src="<?php echo e(route('admin.verifikasi.preview', $dokumen->id)); ?>" type="application/pdf" width="100%" height="600" style="border: none;">
                    <?php else: ?>
                        <img src="<?php echo e(route('admin.verifikasi.preview', $dokumen->id)); ?>" class="img-fluid rounded" alt="Preview Dokumen">
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <a href="<?php echo e(route('admin.verifikasi.preview', $dokumen->id)); ?>" target="_blank" class="btn btn-sm btn-info">
                        <i class="ti ti-external-link"></i> Buka di Tab Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Verifikasi Form -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Data Dokumen & Verifikasi</h5>
                </div>
                <div class="card-body">
                    <!-- Info Siswa -->
                    <div class="mb-4 pb-4 border-bottom">
                        <h6 class="text-primary mb-3">Informasi Siswa</h6>
                        <p class="mb-2">
                            <strong>Nama:</strong> <?php echo e($dokumen->siswa->nama_lengkap); ?>

                        </p>
                        <p class="mb-2">
                            <strong>NISN:</strong> <?php echo e($dokumen->siswa->nisn); ?>

                        </p>
                        <p class="mb-2">
                            <strong>Email:</strong> <?php echo e($dokumen->siswa->email ?? '-'); ?>

                        </p>
                    </div>

                    <!-- Info Dokumen -->
                    <div class="mb-4 pb-4 border-bottom">
                        <h6 class="text-primary mb-3">Informasi Dokumen</h6>
                        <p class="mb-2">
                            <strong>Jenis Dokumen:</strong> <?php echo e($dokumen->jenisDokumen->nama); ?>

                        </p>
                        <p class="mb-2">
                            <strong>Deskripsi:</strong> <?php echo e($dokumen->jenisDokumen->deskripsi ?? '-'); ?>

                        </p>
                        <p class="mb-2">
                            <strong>Wajib:</strong> 
                            <span class="badge bg-<?php echo e($dokumen->jenisDokumen->wajib ? 'danger' : 'success'); ?>">
                                <?php echo e($dokumen->jenisDokumen->wajib ? 'Ya' : 'Tidak'); ?>

                            </span>
                        </p>
                        <p class="mb-2">
                            <strong>Tanggal Upload:</strong> <?php echo e($dokumen->created_at->format('d M Y H:i')); ?>

                        </p>
                    </div>

                    <!-- Verifikasi Form -->
                    <form action="<?php echo e(route('admin.verifikasi.update', $dokumen->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <!-- Status Verifikasi (hidden) -->
                        <input type="hidden" id="status_verifikasi_id" name="status_verifikasi_id" value="<?php echo e(old('status_verifikasi_id', $dokumen->status_verifikasi_id)); ?>">
                        <div class="mb-3">
                            <label class="form-label">Status Verifikasi</label>
                            <div>
                                <?php
                                    $currentStatusLabel = $dokumen->statusVerifikasi?->label ?? 'Menunggu Verifikasi';
                                    $currentStatusKode = $dokumen->statusVerifikasi?->kode ?? 'pending';
                                ?>
                                <span class="badge bg-<?php echo e($currentStatusKode === 'verified' ? 'success' : ($currentStatusKode === 'rejected' ? 'danger' : 'warning')); ?>">
                                    <?php echo e($currentStatusLabel); ?>

                                </span>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control <?php $__errorArgs = ['catatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      id="catatan" name="catatan" rows="4" placeholder="Masukkan catatan verifikasi..."><?php echo e(old('catatan', $dokumen->catatan)); ?></textarea>
                            <?php $__errorArgs = ['catatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="form-text text-muted">
                                Catatan akan diteruskan ke siswa
                            </small>
                        </div>

                        <!-- Buttons (main form: Kembali + Simpan) -->
                        <div class="d-flex gap-2 justify-content-between align-items-center">
                            <div>
                                <a href="<?php echo e(route('admin.verifikasi')); ?>" class="btn btn-secondary">
                                    <i class="ti ti-arrow-left me-2"></i> Kembali
                                </a>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-success">
                                    <i class="ti ti-check me-2"></i> Simpan Verifikasi
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Quick action buttons (outside main form to avoid nested-form validation issues) -->
                    <div class="mt-3 d-flex gap-2">
                        <form action="<?php echo e(route('admin.verifikasi.accept', $dokumen->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin langsung menandai dokumen ini sebagai TER-VERIFIKASI?');">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-check me-2"></i> Terima
                            </button>
                        </form>

                        <form action="<?php echo e(route('admin.verifikasi.reject', $dokumen->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menolak dokumen ini?');">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="catatan" value="Ditolak oleh admin (quick action)">
                            <button type="submit" class="btn btn-danger">
                                <i class="ti ti-x me-2"></i> Tolak
                            </button>
                        </form>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\aplikasi_ppdb\resources\views/admin/verifikasi/edit.blade.php ENDPATH**/ ?>