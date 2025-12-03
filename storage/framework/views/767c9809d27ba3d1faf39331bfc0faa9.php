<?php $__env->startSection('page_title', 'Formulir Pendaftaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header mb-4">
    <h1 class="page-title"><i class="fas fa-form me-2"></i>Formulir Pendaftaran</h1>
    <p class="page-subtitle">Isi data pendaftaran Anda dengan lengkap dan benar</p>
</div>

<!-- Info Box untuk Urutan Pengisian -->
<div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
    <i class="fas fa-lightbulb me-2"></i>
    <strong>Urutan Pengisian Data:</strong>
    <ol class="mb-0 mt-2">
        <li><strong>Isi Formulir Pendaftaran</strong> terlebih dahulu (halaman ini)</li>
        <li>Setelah formulir selesai, lanjutkan ke <strong>Biodata Pribadi</strong></li>
        <li>Kemudian lanjutkan ke tahap selanjutnya (Upload Dokumen, Pembayaran, dll)</li>
    </ol>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

<div class="row g-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Data Pendaftaran</h5>
            </div>
            <div class="card-body">
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                        <p class="mb-0 mt-2"><strong>✅ Langkah 1 Selesai!</strong> Sekarang lanjutkan ke menu <strong>Biodata</strong> untuk melanjutkan pengisian data.</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php if($isSubmitted): ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Data Sudah Tersimpan!</strong> Data formulir Anda sudah disimpan. Anda hanya bisa melihat data yang sudah diisi.
                        Jika perlu mengubah, silakan hubungi admin.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php if(session('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php if($errors->any()): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-warning me-2"></i>Periksa kembali form Anda:
                        <ul class="mb-0 mt-2">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('user.formulir.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                            <input type="text" name="tahun_ajaran" class="form-control" 
                                   value="<?php echo e(old('tahun_ajaran', optional($pendaftaran)->tahun_ajaran ?? '2025/2026')); ?>" readonly style="background-color: #f8f9fa; cursor: not-allowed;">
                            <small class="text-muted d-block mt-1"><i class="fas fa-lock me-1"></i>Tahun ajaran ditentukan oleh admin</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jalur Pendaftaran <span class="text-danger">*</span></label>
                            <select name="jalur_pendaftaran" class="form-select <?php $__errorArgs = ['jalur_pendaftaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" <?php echo e($isSubmitted ? 'disabled' : 'required'); ?>>
                                <option value="">-- Pilih Jalur --</option>
                                <option value="Reguler" <?php echo e(old('jalur_pendaftaran', optional($pendaftaran)->jalur_pendaftaran ?? '') == 'Reguler' ? 'selected' : ''); ?>>Reguler</option>
                                <option value="Prestasi" <?php echo e(old('jalur_pendaftaran', optional($pendaftaran)->jalur_pendaftaran ?? '') == 'Prestasi' ? 'selected' : ''); ?>>Prestasi</option>
                            </select>
                            <?php $__errorArgs = ['jalur_pendaftaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Gelombang <span class="text-danger">*</span></label>
                            <input type="number" name="gelombang" class="form-control" 
                                   value="<?php echo e(old('gelombang', optional($pendaftaran)->gelombang ?? optional($gelombangAktif)->nomor_gelombang ?? '1')); ?>" readonly style="background-color: #f8f9fa; cursor: not-allowed;">
                            <small class="text-muted d-block mt-1"><i class="fas fa-lock me-1"></i>Gelombang ditentukan oleh admin</small>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Jurusan Pilihan <span class="text-danger">*</span></label>
                            <select name="jurusan_pilihan" id="jurusan_pilihan" class="form-select <?php $__errorArgs = ['jurusan_pilihan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" <?php echo e($isSubmitted ? 'disabled' : 'required'); ?>>
                                <option value="">-- Pilih Jurusan --</option>
                                <?php $__empty_1 = true; $__currentLoopData = $jurusans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jurusan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <option value="<?php echo e($jurusan->id); ?>" 
                                            <?php echo e(old('jurusan_pilihan', optional($pendaftaran)->jurusan_pilihan_1 ?? '') == $jurusan->id ? 'selected' : ''); ?>>
                                        <?php echo e($jurusan->kode_jurusan); ?> - <?php echo e($jurusan->nama_jurusan); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <option value="" disabled>Tidak ada jurusan tersedia</option>
                                <?php endif; ?>
                            </select>
                            <?php $__errorArgs = ['jurusan_pilihan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rata-rata Nilai Raport <span class="text-danger">*</span></label>
                        <input type="number" name="rata_nilai" step="0.01" class="form-control <?php $__errorArgs = ['rata_nilai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('rata_nilai', optional($pendaftaran)->rata_nilai ?? '')); ?>" <?php echo e($isSubmitted ? 'readonly' : 'required'); ?>>
                        <?php $__errorArgs = ['rata_nilai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="d-grid gap-2 gap-md-3">
                        <?php if(!$isSubmitted): ?>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Simpan Formulir
                            </button>
                        <?php endif; ?>
                        <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .page-header {
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 1.5rem;
    }
    .page-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #2c3e50;
    }
    .page-subtitle {
        font-size: 0.95rem;
        color: #6c757d;
        margin: 0.5rem 0 0 0;
    }
</style>
<script>
    // Script removed - simplified to single jurusan field
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppdb_denico_09\resources\views/user/formulir.blade.php ENDPATH**/ ?>