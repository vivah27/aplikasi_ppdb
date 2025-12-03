<?php $__env->startSection('page_title', 'Dokumen'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 30px;
    }
    .header-title {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }
    .header-subtitle {
        color: #6b7280;
        font-size: 14px;
        margin: 8px 0 0 0;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-left: 4px solid #4f46e5;
    }
    .stat-card.success { border-left-color: #10b981; }
    .stat-card.warning { border-left-color: #f59e0b; }
    .stat-card.danger { border-left-color: #ef4444; }
    .stat-label {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 8px;
    }
    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
    }
    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    .card-header {
        background: #f9fafb;
        padding: 20px;
        border-bottom: 1px solid #e5e7eb;
        font-weight: 600;
        color: #1f2937;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-body {
        padding: 20px;
    }
    .btn {
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: white;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
    .btn-download {
        background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
        color: white;
        padding: 8px 12px;
        font-size: 12px;
    }
    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
        color: white;
        padding: 8px 12px;
        font-size: 12px;
    }
    .btn-delete:hover { opacity: 0.9; }
    .table-responsive {
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    table thead {
        background: #f9fafb;
    }
    table th {
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: #1f2937;
        border-bottom: 1px solid #e5e7eb;
    }
    table td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
    }
    table tbody tr:hover {
        background: #f9fafb;
    }
    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-success { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .badge-warning { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .badge-danger { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
    .badge-info { background: rgba(14, 165, 233, 0.1); color: #0ea5e9; }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-icon {
        font-size: 50px;
        opacity: 0.3;
        margin-bottom: 20px;
    }
    .empty-title {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
    }
    .empty-text {
        color: #6b7280;
        margin-bottom: 20px;
    }
    .action-buttons {
        display: flex;
        gap: 8px;
    }
</style>

<div class="header-section">
    <div>
        <h1 class="header-title">Kelola Dokumen Pendaftaran</h1>
        <p class="header-subtitle">Upload dan kelola dokumen pendukung untuk pendaftaran Anda</p>
    </div>
    <a href="<?php echo e(route('user.dokumen.create')); ?>" class="btn btn-primary">
        ↑ Upload Dokumen Baru
    </a>
</div>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Dokumen</div>
        <div class="stat-value"><?php echo e($dokumen->total() ?? 0); ?></div>
    </div>
    <div class="stat-card success">
        <div class="stat-label">Terverifikasi</div>
        <div class="stat-value"><?php echo e($dokumen->where('status_verifikasi_id', 1)->count() ?? 0); ?></div>
    </div>
    <div class="stat-card warning">
        <div class="stat-label">Menunggu Verifikasi</div>
        <div class="stat-value"><?php echo e($dokumen->filter(function($d) { return !$d->status_verifikasi_id; })->count() ?? 0); ?></div>
    </div>
    <div class="stat-card danger">
        <div class="stat-label">Ditolak</div>
        <div class="stat-value"><?php echo e($dokumen->where('status_verifikasi_id', 3)->count() ?? 0); ?></div>
    </div>
</div>

<!-- Documents Card -->
<div class="card">
    <div class="card-header">
        📋 Daftar Dokumen
    </div>
    <div class="card-body">
        <?php if($dokumen->count() > 0): ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Dokumen</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th>Tanggal Upload</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $dokumen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td>
                                    <strong><?php echo e($item->jenisDokumen->nama ?? 'N/A'); ?></strong>
                                </td>
                                <td>
                                    <?php
                                        $status = $item->statusVerifikasi?->label ?? 'Menunggu';
                                        $statusClass = match($status) {
                                            'Terverifikasi' => 'success',
                                            'Menunggu' => 'warning',
                                            'Ditolak' => 'danger',
                                            default => 'info'
                                        };
                                    ?>
                                    <span class="status-badge badge-<?php echo e($statusClass); ?>"><?php echo e($status); ?></span>
                                </td>
                                <td>
                                    <?php if($item->catatan): ?>
                                        <small><?php echo e(Str::limit($item->catatan, 30)); ?></small>
                                    <?php else: ?>
                                        <span style="color: #d1d5db;">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><small><?php echo e($item->created_at->format('d M Y')); ?></small></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?php echo e(route('user.dokumen.download', $item->id)); ?>" class="btn btn-download">
                                            ↓ Unduh
                                        </a>
                                        <button type="button" class="btn btn-delete btn-delete" data-action="<?php echo e(route('user.dokumen.destroy', $item->id)); ?>" data-csrf="<?php echo e(csrf_token()); ?>">
                                            🗑 Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <?php if($dokumen->hasPages()): ?>
                <div style="margin-top: 20px; display: flex; justify-content: center;">
                    <?php echo e($dokumen->links()); ?>

                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">📁</div>
                <div class="empty-title">Belum Ada Dokumen</div>
                <p class="empty-text">Silakan upload dokumen terlebih dahulu untuk melanjutkan proses verifikasi</p>
                <a href="<?php echo e(route('user.dokumen.create')); ?>" class="btn btn-primary">
                    ↑ Upload Dokumen Pertama
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppdb_denico_09\resources\views/user/dokumen/index.blade.php ENDPATH**/ ?>