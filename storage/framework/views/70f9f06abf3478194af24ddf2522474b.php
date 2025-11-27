

<?php $__env->startSection('page_title', 'Jenis Dokumen'); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width: 100%;">
    <!-- Header Section -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h3 style="margin: 0; color: #1f2937; font-weight: 700;">Manajemen Jenis Dokumen</h3>
            <p style="margin: 8px 0 0 0; color: #6b7280; font-size: 14px;">Kelola jenis-jenis dokumen yang diperlukan dalam pendaftaran</p>
        </div>
        <a href="<?php echo e(route('admin.jenis-dokumen.create')); ?>" style="padding: 12px 24px; background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 10px; transition: all 0.3s;">
            <i class="fas fa-plus"></i>Tambah Jenis Dokumen
        </a>
    </div>

    <!-- Alert Messages -->
    <?php if(session('success')): ?>
        <div style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-check-circle" style="color: #10b981; font-size: 18px;"></i>
            <div>
                <strong style="color: #10b981;">Berhasil!</strong>
                <p style="margin: 3px 0 0 0; font-size: 14px; color: #10b981;"><?php echo e(session('success')); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- List Card -->
    <div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">No</th>
                        <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">Nama Jenis</th>
                        <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">Deskripsi</th>
                        <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">Wajib</th>
                        <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">Dibuat</th>
                        <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $jenisDokumen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr style="border-bottom: 1px solid #f3f4f6; transition: all 0.3s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background=''">
                            <td style="padding: 15px; color: #1f2937;"><?php echo e($loop->iteration + ($jenisDokumen->currentPage() - 1) * $jenisDokumen->perPage()); ?></td>
                            <td style="padding: 15px; color: #1f2937; font-weight: 600;"><?php echo e($item->nama); ?></td>
                            <td style="padding: 15px; color: #6b7280; font-size: 14px;">
                                <?php if($item->deskripsi): ?>
                                    <?php echo e(substr($item->deskripsi, 0, 50)); ?><?php echo e(strlen($item->deskripsi) > 50 ? '...' : ''); ?>

                                <?php else: ?>
                                    <span style="color: #d1d5db;">-</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 15px;">
                                <span style="display: inline-block; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; background: <?php echo e($item->wajib ? 'rgba(239, 68, 68, 0.15)' : 'rgba(16, 185, 129, 0.15)'); ?>; color: <?php echo e($item->wajib ? '#ef4444' : '#10b981'); ?>">
                                    <?php echo e($item->wajib ? 'Wajib' : 'Opsional'); ?>

                                </span>
                            </td>
                            <td style="padding: 15px; color: #6b7280; font-size: 14px;"><?php echo e($item->created_at->format('d M Y')); ?></td>
                            <td style="padding: 15px;">
                                <div style="display: flex; gap: 8px;">
                                    <a href="<?php echo e(route('admin.jenis-dokumen.edit', $item->id)); ?>" style="padding: 8px 12px; background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); color: white; text-decoration: none; border-radius: 6px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: all 0.3s;">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="<?php echo e(route('admin.jenis-dokumen.destroy', $item->id)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" style="padding: 8px 12px; background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); color: white; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.3s;">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" style="padding: 40px; text-align: center; color: #6b7280;">
                                <i class="fas fa-inbox" style="font-size: 40px; opacity: 0.3; margin-bottom: 10px; display: block;"></i>
                                <p style="margin: 10px 0 0 0;">Belum ada jenis dokumen</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="padding: 20px; border-top: 1px solid #e5e7eb;">
            <?php echo e($jenisDokumen->links('pagination::bootstrap-4')); ?>

        </div>
    </div>
</div>

<style>
    a:hover, button:hover {
        opacity: 0.9;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\aplikasi_ppdb\resources\views/admin/jenis-dokumen/index.blade.php ENDPATH**/ ?>