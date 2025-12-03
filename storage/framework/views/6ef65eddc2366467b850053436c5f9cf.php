<?php $__env->startSection('page_title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .dashboard-header {
        padding: 0 0 24px 0;
        margin-bottom: 32px;
    }
    .dashboard-title {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 8px 0;
    }
    .dashboard-subtitle {
        color: #6b7280;
        font-size: 14px;
        margin: 0;
    }

    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-left: 4px solid;
        transition: all 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
    }

    .stat-card.primary { border-left-color: #6366f1; }
    .stat-card.success { border-left-color: #10b981; }
    .stat-card.warning { border-left-color: #f59e0b; }
    .stat-card.danger { border-left-color: #ef4444; }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin: 32px 0 20px 0;
        padding-bottom: 12px;
        border-bottom: 2px solid #e5e7eb;
    }

    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        padding: 16px 20px;
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
        padding: 8px 14px;
        border-radius: 6px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 12px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .list-group {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .list-item {
        padding: 14px 0;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .list-item:last-child {
        border-bottom: none;
    }

    .list-item-main h6 {
        margin: 0 0 4px 0;
        font-weight: 600;
        color: #1f2937;
        font-size: 13px;
    }

    .list-item-main p {
        margin: 0;
        font-size: 12px;
        color: #6b7280;
    }

    .badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-success { background: rgba(16, 185, 129, 0.15); color: #10b981; }
    .badge-warning { background: rgba(245, 158, 11, 0.15); color: #f59e0b; }
    .badge-danger { background: rgba(239, 68, 68, 0.15); color: #ef4444; }
    .badge-info { background: rgba(99, 102, 241, 0.15); color: #6366f1; }

    .alert {
        padding: 14px 16px;
        border-radius: 8px;
        border-left: 4px solid;
        font-size: 13px;
        margin-bottom: 16px;
    }

    .alert-warning {
        background: rgba(245, 158, 11, 0.1);
        border-left-color: #f59e0b;
        color: #92400e;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border-left-color: #10b981;
        color: #047857;
    }

    .action-links {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 12px;
        margin-top: 16px;
    }

    .action-link {
        padding: 12px;
        background: #f9fafb;
        border-radius: 8px;
        text-decoration: none;
        color: #1f2937;
        font-weight: 500;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #e5e7eb;
        transition: all 0.3s;
    }

    .action-link:hover {
        background: #f3f4f6;
        border-color: #6366f1;
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    table th {
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: #1f2937;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }

    table td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
    }

    table tbody tr:hover {
        background: #f9fafb;
    }

    .text-muted {
        color: #6b7280;
    }
</style>

<!-- Dashboard Header -->
<div class="dashboard-header">
    <h1 class="dashboard-title">Dashboard Admin</h1>
    <p class="dashboard-subtitle">Selamat datang, <?php echo e(Auth::user()->name); ?></p>
</div>

<!-- Key Statistics -->
<div class="stat-cards-grid">
    <div class="stat-card primary">
        <div class="stat-value"><?php echo e($totalPendaftaran); ?></div>
        <div class="stat-label">Total Pendaftar</div>
    </div>
    <div class="stat-card success">
        <div class="stat-value"><?php echo e($diterima); ?></div>
        <div class="stat-label">Diterima</div>
    </div>
    <div class="stat-card warning">
        <div class="stat-value"><?php echo e($menunggu); ?></div>
        <div class="stat-label">Menunggu Keputusan</div>
    </div>
    <div class="stat-card danger">
        <div class="stat-value"><?php echo e($ditolak); ?></div>
        <div class="stat-label">Ditolak</div>
    </div>
</div>

<!-- Main Content -->
<h2 class="section-title">Manajemen PPDB</h2>
<div class="cards-grid">
    <!-- Document Verification -->
    <div class="card">
        <div class="card-header">
            Verifikasi Dokumen
            <a href="<?php echo e(route('admin.verifikasi')); ?>" class="btn btn-primary">Lihat</a>
        </div>
        <div class="card-body">
            <?php if($dokumenTertunda > 0): ?>
                <div class="alert alert-warning">
                    <strong><?php echo e($dokumenTertunda); ?> dokumen</strong> menunggu verifikasi
                </div>
            <?php else: ?>
                <div class="alert alert-success">
                    <strong>Semua dokumen</strong> sudah terverifikasi ✓
                </div>
            <?php endif; ?>
            <div class="action-links">
                <a href="<?php echo e(route('admin.verifikasi')); ?>" class="action-link">
                    <i class="fas fa-check-circle"></i> Verifikasi
                </a>
                <a href="<?php echo e(route('admin.jenis-dokumen.index')); ?>" class="action-link">
                    <i class="fas fa-file-alt"></i> Jenis Dokumen
                </a>
            </div>
        </div>
    </div>

    <!-- Document Statistics -->
    <div class="card">
        <div class="card-header">
            Status Dokumen
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-item">
                    <div class="list-item-main">
                        <h6>Total Dokumen</h6>
                    </div>
                    <span class="badge badge-info"><?php echo e($totalDokumen); ?></span>
                </li>
                <li class="list-item">
                    <div class="list-item-main">
                        <h6>Terverifikasi</h6>
                    </div>
                    <span class="badge badge-success"><?php echo e($dokumenTerverifikasi); ?></span>
                </li>
                <li class="list-item">
                    <div class="list-item-main">
                        <h6>Menunggu Verifikasi</h6>
                    </div>
                    <span class="badge badge-warning"><?php echo e($dokumenTertunda); ?></span>
                </li>
                <li class="list-item">
                    <div class="list-item-main">
                        <h6>Tingkat Verifikasi</h6>
                    </div>
                    <span class="badge badge-info"><?php echo e(round($verificationRate)); ?>%</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Student Distribution -->
    <div class="card">
        <div class="card-header">
            Distribusi Jurusan
            <a href="<?php echo e(route('admin.siswa.index')); ?>" class="btn btn-primary">Lihat Semua</a>
        </div>
        <div class="card-body">
            <?php if($popularMajors->count() > 0): ?>
                <ul class="list-group">
                    <?php $__currentLoopData = $popularMajors->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $major): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-item">
                            <div class="list-item-main">
                                <h6><?php echo e($major->nama ?? 'N/A'); ?></h6>
                            </div>
                            <span class="badge badge-info"><?php echo e($major->total); ?></span>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">Belum ada data</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Recent Registrations -->
<h2 class="section-title">Pendaftar Terbaru</h2>
<div style="display: grid; grid-template-columns: 250px 1fr; gap: 20px;">
    <!-- Sidebar Filter -->
    <div class="card" style="height: fit-content; position: sticky; top: 100px;">
        <div class="card-header" style="padding: 14px 16px; font-size: 14px;">
            🔍 Filter & Cari
        </div>
        <div class="card-body" style="padding: 16px;">
            <form method="GET" action="<?php echo e(route('admin.dashboard')); ?>" style="display: flex; flex-direction: column; gap: 16px;">
                <!-- Search by Name -->
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #1f2937; margin-bottom: 6px; text-transform: uppercase;">Cari Nama</label>
                    <input type="text" name="search" placeholder="Nama atau NISN" value="<?php echo e(request('search')); ?>" style="width: 100%; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                </div>

                <!-- Filter by Status -->
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #1f2937; margin-bottom: 6px; text-transform: uppercase;">Status</label>
                    <select name="status" style="width: 100%; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                        <option value="">Semua Status</option>
                        <option value="waiting" <?php echo e(request('status') === 'waiting' ? 'selected' : ''); ?>>Menunggu</option>
                        <option value="accepted" <?php echo e(request('status') === 'accepted' ? 'selected' : ''); ?>>Diterima</option>
                        <option value="rejected" <?php echo e(request('status') === 'rejected' ? 'selected' : ''); ?>>Ditolak</option>
                    </select>
                </div>

                <!-- Filter by Date Range -->
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #1f2937; margin-bottom: 6px; text-transform: uppercase;">Dari Tanggal</label>
                    <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" style="width: 100%; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #1f2937; margin-bottom: 6px; text-transform: uppercase;">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>" style="width: 100%; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 8px;">
                    <button type="submit" style="flex: 1; padding: 10px; background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%); color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 12px; cursor: pointer; transition: all 0.3s;">
                        Cari
                    </button>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" style="flex: 1; padding: 10px; background: #f3f4f6; color: #1f2937; border: none; border-radius: 6px; font-weight: 600; font-size: 12px; cursor: pointer; text-align: center; text-decoration: none; transition: all 0.3s;">
                        Reset
                    </a>
                </div>

                <!-- Quick Stats -->
                <div style="border-top: 1px solid #e5e7eb; padding-top: 16px; margin-top: 8px;">
                    <div style="font-size: 12px; font-weight: 600; color: #1f2937; margin-bottom: 10px;">📊 Statistik</div>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px;">
                        <li style="padding: 8px; background: rgba(99, 102, 241, 0.1); border-radius: 6px; font-size: 12px;">
                            <div style="color: #6366f1; font-weight: 600;"><?php echo e($totalPendaftaran); ?></div>
                            <div style="color: #6b7280; font-size: 11px;">Total Pendaftar</div>
                        </li>
                        <li style="padding: 8px; background: rgba(245, 158, 11, 0.1); border-radius: 6px; font-size: 12px;">
                            <div style="color: #f59e0b; font-weight: 600;"><?php echo e($menunggu); ?></div>
                            <div style="color: #6b7280; font-size: 11px;">Menunggu Verifikasi</div>
                        </li>
                        <li style="padding: 8px; background: rgba(16, 185, 129, 0.1); border-radius: 6px; font-size: 12px;">
                            <div style="color: #10b981; font-weight: 600;"><?php echo e($diterima); ?></div>
                            <div style="color: #6b7280; font-size: 11px;">Diterima</div>
                        </li>
                    </ul>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="card">
        <div class="card-header">
            10 Pendaftar Terbaru
            <a href="<?php echo e(route('admin.siswa.index')); ?>" class="btn btn-primary">Lihat Semua</a>
        </div>
        <div class="card-body">
            <?php if($recentRegistrations->count() > 0): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th width="20%">Nama</th>
                                <th width="15%">NISN</th>
                                <th width="20%">Jurusan</th>
                                <th width="15%">Tanggal Daftar</th>
                                <th width="15%">Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentRegistrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><strong><?php echo e($reg->siswa?->nama_lengkap ?? 'N/A'); ?></strong></td>
                                    <td class="text-muted"><?php echo e($reg->siswa?->nisn ?? '-'); ?></td>
                                    <td><?php echo e($reg->jurusanPilihan1?->nama ?? '-'); ?></td>
                                    <td><?php echo e($reg->created_at->format('d M Y')); ?></td>
                                    <td>
                                        <?php
                                            $status = $reg->statusPendaftaran?->label ?? 'Menunggu';
                                            $badgeClass = match($status) {
                                                'Diterima' => 'badge-success',
                                                'Menunggu' => 'badge-warning',
                                                'Ditolak' => 'badge-danger',
                                                default => 'badge-info'
                                            };
                                        ?>
                                        <span class="badge <?php echo e($badgeClass); ?>"><?php echo e($status); ?></span>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.verifikasi')); ?>" class="btn btn-primary" style="font-size: 11px; padding: 6px 10px;">
                                            Verifikasi
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted" style="text-align: center; padding: 30px;">Belum ada pendaftar</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppdb_denico_09\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>