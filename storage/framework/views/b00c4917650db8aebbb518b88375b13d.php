<?php $__env->startSection('page_title', 'Kelola Jurusan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Jurusan</h1>
        <a href="<?php echo e(route('admin.jurusan.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Jurusan
        </a>
    </div>

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
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Jurusan</h5>
        </div>
        <div class="card-body">
            <?php if($jurusan->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="8%">No</th>
                                <th width="12%">Kode</th>
                                <th width="25%">Nama Jurusan</th>
                                <th width="12%">Kuota</th>
                                <th width="15%">Pendaftar</th>
                                <th width="10%">Status</th>
                                <th width="12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $jurusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(($jurusan->currentPage() - 1) * $jurusan->perPage() + $key + 1); ?></td>
                                    <td>
                                        <code><?php echo e($item->kode_jurusan); ?></code>
                                    </td>
                                    <td>
                                        <strong><?php echo e($item->nama_jurusan); ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?php echo e($item->kuota); ?> orang</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary"><?php echo e($item->pendaftarans()->count()); ?> orang</span>
                                    </td>
                                    <td>
                                        <?php if($item->is_active): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.jurusan.show', $item)); ?>" class="btn btn-sm btn-info" title="Lihat Pendaftar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.jurusan.edit', $item)); ?>" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if(!$item->pendaftarans()->exists()): ?>
                                            <form action="<?php echo e(route('admin.jurusan.destroy', $item)); ?>" method="POST" style="display:inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <nav>
                    <?php echo e($jurusan->links('pagination::bootstrap-5')); ?>

                </nav>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Belum ada jurusan. <a href="<?php echo e(route('admin.jurusan.create')); ?>" class="alert-link">Buat jurusan baru</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\aplikasi_ppdb_2\resources\views/admin/jurusan/index.blade.php ENDPATH**/ ?>