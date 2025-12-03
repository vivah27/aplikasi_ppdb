

<?php $__env->startSection('page_title', 'Atur Gelombang'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <h1 class="h3 mb-4 text-gray-800">Atur Gelombang</h1>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Atur Konfigurasi Gelombang</h5>
            <small class="text-muted d-block mt-2">
                <i class="fas fa-info-circle me-1"></i>Konfigurasi gelombang di sini akan ditampilkan kepada user saat pendaftaran dan pembayaran
            </small>
        </div>
        <div class="card-body">
            <?php if(count($hargaGelombang) > 0): ?>
                <form action="<?php echo e(route('admin.harga-gelombang.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="12%"><i class="fas fa-wave-square me-2"></i>Gelombang</th>
                                    <th width="10%"><i class="fas fa-users me-2"></i>Pendaftar</th>
                                    <th width="25%"><i class="fas fa-tag me-2"></i>Jenis Pembayaran</th>
                                    <th width="20%"><i class="fas fa-money-bill-wave me-2"></i>Harga (Rp)</th>
                                    <th width="20%"><i class="fas fa-bank me-2"></i>Tujuan Rekening</th>
                                    <th width="13%" class="text-center"><i class="fas fa-cog me-2"></i>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $hargaGelombang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gelombang => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary">Gelombang <?php echo e($gelombang); ?></span>
                                        </td>
                                        <td>
                                            <span class="text-muted"><?php echo e($data['count']); ?> siswa</span>
                                        </td>
                                        <td>
                                            <input type="text" 
                                                   name="jenis_pembayaran[<?php echo e($gelombang); ?>]" 
                                                   class="form-control" 
                                                   value="<?php echo e(old('jenis_pembayaran.' . $gelombang, $data['jenis_pembayaran'])); ?>"
                                                   placeholder="Contoh: Uang Pendaftaran">
                                            <?php $__errorArgs = ['jenis_pembayaran.' . $gelombang];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <small class="text-danger d-block mt-1"><?php echo e($message); ?></small>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" 
                                                       name="harga[<?php echo e($gelombang); ?>]" 
                                                       class="form-control text-end" 
                                                       value="<?php echo e(old('harga.' . $gelombang, $data['harga'])); ?>"
                                                       placeholder="0"
                                                       step="1000"
                                                       min="0">
                                            </div>
                                            <?php $__errorArgs = ['harga.' . $gelombang];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <small class="text-danger d-block mt-1"><?php echo e($message); ?></small>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </td>
                                        <td>
                                            <input type="text" 
                                                   name="tujuan_rekening[<?php echo e($gelombang); ?>]" 
                                                   class="form-control" 
                                                   value="<?php echo e(old('tujuan_rekening.' . $gelombang, $data['tujuan_rekening'])); ?>"
                                                   placeholder="Contoh: Bank BNI No. 12345678 (a.n. Sekolah)">
                                            <?php $__errorArgs = ['tujuan_rekening.' . $gelombang];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <small class="text-danger d-block mt-1"><?php echo e($message); ?></small>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            <small class="text-muted d-block mt-1">Akan ditampilkan readonly untuk user</small>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?php echo e(route('admin.siswa.index', ['gelombang' => $gelombang])); ?>" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Lihat Siswa Gelombang <?php echo e($gelombang); ?>">
                                                <i class="fas fa-users me-1"></i>Lihat Siswa
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <hr class="my-4">

                    <div class="d-grid gap-2 gap-md-3">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save me-2"></i>Simpan Konfigurasi Gelombang
                        </button>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                        </a>
                    </div>
                </form>

                <!-- Info Box -->
                <div class="alert alert-info mt-4">
                    <h6 class="alert-heading"><i class="fas fa-lightbulb me-2"></i>Catatan Penting</h6>
                    <ul class="mb-0">
                        <li>Pastikan semua data sudah benar sebelum menyimpan</li>
                        <li>Jenis pembayaran akan ditampilkan dalam formulir pembayaran user</li>
                        <li>Tujuan rekening akan ditampilkan sebagai read-only untuk user saat melakukan pembayaran</li>
                        <li>Perubahan akan berlaku untuk semua siswa dengan gelombang yang sama</li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fas fa-warning me-2"></i>
                    <strong>Belum ada data gelombang</strong>
                    <p class="mb-0 mt-2">Gelombang akan otomatis muncul ketika ada siswa yang melakukan pendaftaran.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        border: none;
        font-weight: 600;
        color: #5a6c7d;
        background-color: #f8f9fa;
        padding: 15px 12px;
    }

    .table tbody td {
        padding: 15px 12px;
        vertical-align: middle;
        border-color: #e9ecef;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        font-weight: 600;
    }

    .form-control, .input-group-text {
        border-radius: 6px;
    }

    input.form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppdb_denico_09\resources\views/admin/harga-gelombang/index.blade.php ENDPATH**/ ?>