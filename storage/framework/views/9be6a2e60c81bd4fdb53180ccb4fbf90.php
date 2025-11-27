

<?php $__env->startSection('page_title', 'Verifikasi Dokumen'); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width: 100%;">
    <!-- Header Section -->
    <div style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 style="margin: 0; color: #1f2937; font-weight: 700;">Verifikasi Dokumen Pendaftaran</h4>
                <p style="margin: 5px 0 0 0; color: #6b7280; font-size: 14px;">Kelola dan verifikasi dokumen dari calon siswa</p>
            </div>
        </div>
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

    <?php if(session('error')): ?>
        <div style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid #ef4444; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-exclamation-circle" style="color: #ef4444; font-size: 18px;"></i>
            <div>
                <strong style="color: #ef4444;">Error!</strong>
                <p style="margin: 3px 0 0 0; font-size: 14px; color: #ef4444;"><?php echo e(session('error')); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Filter Card -->
    <div style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <h6 style="margin: 0 0 20px 0; color: #1f2937; font-weight: 600;">Filter Dokumen</h6>
        <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
            <div>
                <label style="display: block; margin-bottom: 8px; color: #1f2937; font-weight: 600; font-size: 14px;">Status</label>
                <select name="status" style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                    <option value="">-- Semua Status --</option>
                    <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Menunggu</option>
                    <option value="verified" <?php echo e(request('status') === 'verified' ? 'selected' : ''); ?>>Terverifikasi</option>
                    <option value="rejected" <?php echo e(request('status') === 'rejected' ? 'selected' : ''); ?>>Ditolak</option>
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; color: #1f2937; font-weight: 600; font-size: 14px;">Jenis Dokumen</label>
                <select name="jenis_dokumen_id" style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                    <option value="">-- Semua Jenis --</option>
                    <?php $__currentLoopData = App\Models\JenisDokumen::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($jenis->id); ?>" <?php echo e(request('jenis_dokumen_id') == $jenis->id ? 'selected' : ''); ?>><?php echo e($jenis->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; color: #1f2937; font-weight: 600; font-size: 14px;">Cari Siswa</label>
                <input type="text" name="search" placeholder="Nama atau NISN..." style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;" value="<?php echo e(request('search')); ?>">
            </div>
            <div style="display: flex; gap: 10px; align-items: flex-end;">
                <button type="submit" style="flex: 1; padding: 10px 16px; background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 14px;">
                    <i class="fas fa-search" style="margin-right: 6px;"></i>Filter
                </button>
                <a href="<?php echo e(route('admin.verifikasi')); ?>" style="flex: 1; padding: 10px 16px; background: #f3f4f6; color: #1f2937; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 14px; text-align: center; text-decoration: none;">
                    <i class="fas fa-redo" style="margin-right: 6px;"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Documents Table -->
    <div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">No</th>
                        <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">Siswa</th>
                        <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">Jenis Dokumen</th>
                        <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">Status</th>
                        <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">Tanggal Upload</th>
                        <th style="padding: 15px; text-align: left; color: #6b7280; font-weight: 600; font-size: 13px; text-transform: uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $dokumen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr style="border-bottom: 1px solid #f3f4f6; transition: all 0.3s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background=''">
                            <td style="padding: 15px; color: #1f2937;"><?php echo e($loop->iteration + ($dokumen->currentPage() - 1) * $dokumen->perPage()); ?></td>
                            <td style="padding: 15px;">
                                <div style="color: #1f2937; font-weight: 600;"><?php echo e($item->siswa->nama_lengkap ?? 'N/A'); ?></div>
                                <small style="color: #6b7280;">NISN: <?php echo e($item->siswa->nisn ?? '-'); ?></small>
                            </td>
                            <td style="padding: 15px; color: #1f2937;"><?php echo e($item->jenisDokumen->nama ?? '-'); ?></td>
                            <td style="padding: 15px;">
                                <?php if($item->statusVerifikasi): ?>
                                    <span style="display: inline-block; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; background: <?php echo e($item->statusVerifikasi->kode === 'verified' ? 'rgba(16, 185, 129, 0.15)' : ($item->statusVerifikasi->kode === 'rejected' ? 'rgba(239, 68, 68, 0.15)' : 'rgba(245, 158, 11, 0.15)')); ?>; color: <?php echo e($item->statusVerifikasi->kode === 'verified' ? '#10b981' : ($item->statusVerifikasi->kode === 'rejected' ? '#ef4444' : '#f59e0b')); ?>">
                                        <?php echo e($item->statusVerifikasi->label); ?>

                                    </span>
                                <?php else: ?>
                                    <span style="display: inline-block; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; background: rgba(107, 114, 128, 0.15); color: #6b7280;">Menunggu</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 15px; color: #1f2937; font-size: 14px;"><?php echo e($item->created_at->format('d M Y H:i')); ?></td>
                            <td style="padding: 15px;">
                                <div style="display: flex; gap: 8px;">
                                    <a href="<?php echo e(route('admin.verifikasi.edit', $item->id)); ?>" style="padding: 8px 12px; background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); color: white; text-decoration: none; border-radius: 6px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px); this.style.boxShadow='0 4px 12px rgba(245, 158, 11, 0.3)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                                        <i class="fas fa-edit"></i> Verifikasi
                                    </a>
                                    <a href="<?php echo e(asset('storage/' . $item->path)); ?>" target="_blank" style="padding: 8px 12px; background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%); color: white; text-decoration: none; border-radius: 6px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px); this.style.boxShadow='0 4px 12px rgba(14, 165, 233, 0.3)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" style="padding: 40px; text-align: center; color: #6b7280;">
                                <i class="fas fa-inbox" style="font-size: 40px; opacity: 0.3; margin-bottom: 10px; display: block;"></i>
                                <p style="margin: 10px 0 0 0;">Tidak ada dokumen untuk diverifikasi</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="padding: 20px; border-top: 1px solid #e5e7eb;">
            <?php echo e($dokumen->links('pagination::bootstrap-4')); ?>

        </div>
    </div>
</div>

<style>
    a:hover {
        opacity: 0.9;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\aplikasi_ppdb\resources\views/admin/verifikasi/index.blade.php ENDPATH**/ ?>