

<?php $__env->startSection('page_title', 'Tambah Gelombang'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <div class="d-flex align-items-center mb-4">
        <a href="<?php echo e(route('admin.gelombang.index')); ?>" class="btn btn-sm btn-secondary me-2">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
        <h1 class="h3 mb-0 text-gray-800">Tambah Gelombang</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form action="<?php echo e(route('admin.gelombang.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="nama_gelombang" class="form-label">
                            Nama Gelombang <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_gelombang" id="nama_gelombang" class="form-control <?php $__errorArgs = ['nama_gelombang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Contoh: Gelombang 1" value="<?php echo e(old('nama_gelombang')); ?>" required>
                        <?php $__errorArgs = ['nama_gelombang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6">
                        <label for="nomor_gelombang" class="form-label">
                            Nomor Gelombang <span class="text-danger">*</span>
                        </label>
                        <input type="number" name="nomor_gelombang" id="nomor_gelombang" class="form-control <?php $__errorArgs = ['nomor_gelombang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Contoh: 1" value="<?php echo e(old('nomor_gelombang')); ?>" required>
                        <?php $__errorArgs = ['nomor_gelombang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="tanggal_buka" class="form-label">
                            Tanggal Buka <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" name="tanggal_buka" id="tanggal_buka" class="form-control <?php $__errorArgs = ['tanggal_buka'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('tanggal_buka')); ?>" required>
                        <?php $__errorArgs = ['tanggal_buka'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6">
                        <label for="tanggal_tutup" class="form-label">
                            Tanggal Tutup <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" name="tanggal_tutup" id="tanggal_tutup" class="form-control <?php $__errorArgs = ['tanggal_tutup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('tanggal_tutup')); ?>" required>
                        <?php $__errorArgs = ['tanggal_tutup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="harga" class="form-label">Harga Pendaftaran</label>
                        <input type="number" name="harga" id="harga" class="form-control <?php $__errorArgs = ['harga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Contoh: 50000000" value="<?php echo e(old('harga')); ?>" min="0">
                        <?php $__errorArgs = ['harga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6">
                        <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                        <input type="text" name="jenis_pembayaran" id="jenis_pembayaran" class="form-control <?php $__errorArgs = ['jenis_pembayaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Contoh: Uang Pendaftaran" value="<?php echo e(old('jenis_pembayaran')); ?>">
                        <?php $__errorArgs = ['jenis_pembayaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="tujuan_rekening" class="form-label">Tujuan Rekening (Bank Account)</label>
                    <textarea name="tujuan_rekening" id="tujuan_rekening" class="form-control <?php $__errorArgs = ['tujuan_rekening'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                              placeholder="Masukkan informasi rekening bank" rows="3"><?php echo e(old('tujuan_rekening')); ?></textarea>
                    <small class="text-muted">Format: Bank BCA No.0125251 (Nama Pemilik)</small>
                    <?php $__errorArgs = ['tujuan_rekening'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" 
                               value="1" <?php echo e(old('is_active') ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="is_active">
                            Aktifkan gelombang ini
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                    <a href="<?php echo e(route('admin.gelombang.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppdb_denico_09\resources\views/admin/gelombang/create.blade.php ENDPATH**/ ?>