

<?php $__env->startSection('page_title', 'Detail Gelombang'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <div class="d-flex align-items-center mb-4">
        <a href="<?php echo e(route('admin.gelombang.index')); ?>" class="btn btn-sm btn-secondary me-2">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
        <h1 class="h3 mb-0 text-gray-800">Detail <?php echo e($gelombang->nama_gelombang); ?></h1>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <p class="text-muted mb-1"><small>Tanggal Buka</small></p>
                    <p class="fw-bold"><?php echo e($gelombang->tanggal_buka->format('d M Y H:i')); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <p class="text-muted mb-1"><small>Tanggal Tutup</small></p>
                    <p class="fw-bold"><?php echo e($gelombang->tanggal_tutup->format('d M Y H:i')); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <p class="text-muted mb-1"><small>Harga</small></p>
                    <p class="fw-bold text-success">Rp <?php echo e(number_format($gelombang->harga, 0, ',', '.')); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <p class="text-muted mb-1"><small>Status</small></p>
                    <p>
                        <?php if($gelombang->isOpen()): ?>
                            <span class="badge bg-success">Aktif & Buka</span>
                        <?php elseif($gelombang->is_active): ?>
                            <span class="badge bg-warning">Belum/Sudah Ditutup</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Nonaktif</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-users me-2"></i>Pendaftar <?php echo e($gelombang->nama_gelombang); ?> (<?php echo e($pendaftaran->total()); ?> orang)</h5>
        </div>
        <div class="card-body">
            <?php if($pendaftaran->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Nama</th>
                                <th width="15%">NISN</th>
                                <th width="15%">Jurusan</th>
                                <th width="20%">Status</th>
                                <th width="15%">Tanggal Daftar</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pendaftaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(($pendaftaran->currentPage() - 1) * $pendaftaran->perPage() + $key + 1); ?></td>
                                    <td>
                                        <strong><?php echo e($item->siswa->nama_lengkap ?? $item->pengguna->name ?? 'N/A'); ?></strong>
                                    </td>
                                    <td>
                                        <?php echo e($item->siswa->nisn ?? $item->biodata->nisn ?? '-'); ?>

                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?php echo e($item->jurusan->nama_jurusan ?? '-'); ?></span>
                                    </td>
                                    <td>
                                        <?php
                                            $statusClass = match($item->status_pendaftaran ?? '') {
                                                'Diterima' => 'success',
                                                'Ditolak' => 'danger',
                                                'Menunggu' => 'warning',
                                                default => 'secondary'
                                            };
                                        ?>
                                        <span class="badge bg-<?php echo e($statusClass); ?>"><?php echo e($item->status_pendaftaran ?? 'Menunggu'); ?></span>
                                    </td>
                                    <td>
                                        <small><?php echo e($item->created_at->format('d M Y H:i')); ?></small>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.siswa.show', $item)); ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <nav>
                    <?php echo e($pendaftaran->links('pagination::bootstrap-5')); ?>

                </nav>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Belum ada pendaftar untuk gelombang ini
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppdb_denico_09\resources\views/admin/gelombang/show.blade.php ENDPATH**/ ?>