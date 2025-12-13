<?php $__env->startSection('page_title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<!-- Dashboard Header -->
<div class="dashboard-header">
    <h1 class="dashboard-title">🎯 Dashboard Admin</h1>
    <p class="dashboard-subtitle">Selamat datang kembali, <strong><?php echo e(Auth::user()->name); ?>!</strong> Pantau status registrasi siswa secara real-time.</p>
</div>

<!-- Key Statistics -->
<div class="stat-cards-grid">
    <div class="stat-card primary">
        <div class="stat-value"><?php echo e($totalPendaftaran); ?></div>
        <div class="stat-label">📝 Total Pendaftar</div>
    </div>
    <div class="stat-card success">
        <div class="stat-value"><?php echo e($diterima); ?></div>
        <div class="stat-label">✅ Diterima</div>
    </div>
    <div class="stat-card warning">
        <div class="stat-value"><?php echo e($menunggu); ?></div>
        <div class="stat-label">⏳ Menunggu</div>
    </div>
    <div class="stat-card danger">
        <div class="stat-value"><?php echo e($ditolak); ?></div>
        <div class="stat-label">❌ Ditolak</div>
    </div>
</div>

<!-- Main Content -->
<h2 class="section-title">📊 Manajemen PPDB</h2>
<div class="cards-grid">
    <!-- Document Verification -->
    <div class="card">
        <div class="card-header">
            <div style="display: flex; align-items: center; gap: 8px; flex: 1;">
                <i class="ti ti-file-check" style="color: var(--primary);"></i>
                Verifikasi Dokumen
            </div>
            <a href="<?php echo e(route('admin.verifikasi')); ?>" class="btn btn-primary">Lihat</a>
        </div>
        <div class="card-body">
            <?php if($dokumenTertunda > 0): ?>
                <div class="alert alert-warning">
                    <strong>⚠️ <?php echo e($dokumenTertunda); ?> dokumen</strong> menunggu verifikasi
                </div>
            <?php else: ?>
                <div class="alert alert-success">
                    <strong>✨ Semua dokumen</strong> sudah terverifikasi ✓
                </div>
            <?php endif; ?>
            <div class="action-links">
                <a href="<?php echo e(route('admin.verifikasi')); ?>" class="action-link">
                    <i class="ti ti-check-circle" style="color: var(--primary);"></i> Verifikasi
                </a>
                <a href="<?php echo e(route('admin.jenis-dokumen.index')); ?>" class="action-link">
                    <i class="ti ti-file-text" style="color: var(--secondary);"></i> Jenis Dokumen
                </a>
            </div>
        </div>
    </div>

    <!-- Document Statistics -->
    <div class="card">
        <div class="card-header">
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="ti ti-chart-bar" style="color: var(--primary);"></i>
                Status Dokumen
            </div>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-item">
                    <div class="list-item-main">
                        <h6>📄 Total Dokumen</h6>
                    </div>
                    <span class="badge badge-info"><?php echo e($totalDokumen); ?></span>
                </li>
                <li class="list-item">
                    <div class="list-item-main">
                        <h6>✅ Terverifikasi</h6>
                    </div>
                    <span class="badge badge-success"><?php echo e($dokumenTerverifikasi); ?></span>
                </li>
                <li class="list-item">
                    <div class="list-item-main">
                        <h6>⏳ Menunggu Verifikasi</h6>
                    </div>
                    <span class="badge badge-warning"><?php echo e($dokumenTertunda); ?></span>
                </li>
                <li class="list-item">
                    <div class="list-item-main">
                        <h6>📈 Tingkat Verifikasi</h6>
                    </div>
                    <span class="badge badge-info"><?php echo e(round($verificationRate)); ?>%</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Student Distribution -->
    <div class="card">
        <div class="card-header">
            <div style="display: flex; align-items: center; gap: 8px; flex: 1;">
                <i class="ti ti-users-group" style="color: var(--primary);"></i>
                Distribusi Jurusan
            </div>
            <a href="<?php echo e(route('admin.siswa.index')); ?>" class="btn btn-primary">Lihat Semua</a>
        </div>
        <div class="card-body">
            <?php if($popularMajors->count() > 0): ?>
                <ul class="list-group">
                    <?php $__currentLoopData = $popularMajors->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $major): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-item">
                            <div class="list-item-main">
                                <h6><?php echo e($major->nama ?? 'N/A'); ?></h6>
                                <p style="color: var(--text-light);">Pendaftar aktif</p>
                            </div>
                            <span class="badge badge-info"><?php echo e($major->total); ?> siswa</span>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php else: ?>
                <p class="text-muted" style="text-align: center; padding: 20px;">📭 Belum ada data</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Recent Registrations -->
<h2 class="section-title">🔔 Pendaftar Terbaru</h2>
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
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px; text-transform: uppercase;">🔎 Cari Nama</label>
                    <input type="text" name="search" placeholder="Nama atau NISN" value="<?php echo e(request('search')); ?>" style="width: 100%; padding: 10px 12px; border: 2px solid var(--border-color); border-radius: 8px; font-size: 13px; font-family: 'Inter', sans-serif; transition: all 0.3s;">
                </div>

                <!-- Filter by Status -->
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px; text-transform: uppercase;">📋 Status</label>
                    <select name="status" style="width: 100%; padding: 10px 12px; border: 2px solid var(--border-color); border-radius: 8px; font-size: 13px; font-family: 'Inter', sans-serif; transition: all 0.3s;">
                        <option value="">Semua Status</option>
                        <option value="waiting" <?php echo e(request('status') === 'waiting' ? 'selected' : ''); ?>>Menunggu</option>
                        <option value="accepted" <?php echo e(request('status') === 'accepted' ? 'selected' : ''); ?>>Diterima</option>
                        <option value="rejected" <?php echo e(request('status') === 'rejected' ? 'selected' : ''); ?>>Ditolak</option>
                    </select>
                </div>

                <!-- Filter by Date Range -->
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px; text-transform: uppercase;">📅 Dari Tanggal</label>
                    <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" style="width: 100%; padding: 10px 12px; border: 2px solid var(--border-color); border-radius: 8px; font-size: 13px; font-family: 'Inter', sans-serif; transition: all 0.3s;">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px; text-transform: uppercase;">📅 Sampai Tanggal</label>
                    <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>" style="width: 100%; padding: 10px 12px; border: 2px solid var(--border-color); border-radius: 8px; font-size: 13px; font-family: 'Inter', sans-serif; transition: all 0.3s;">
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 8px;">
                    <button type="submit" style="flex: 1; padding: 10px; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 12px; cursor: pointer; transition: all 0.3s; text-transform: uppercase; letter-spacing: 0.5px;">
                        🔍 Cari
                    </button>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" style="flex: 1; padding: 10px; background: var(--border-color); color: var(--text-dark); border: none; border-radius: 8px; font-weight: 600; font-size: 12px; cursor: pointer; text-align: center; text-decoration: none; transition: all 0.3s; text-transform: uppercase; letter-spacing: 0.5px;">
                        Reset
                    </a>
                </div>

                <!-- Quick Stats -->
                <div style="border-top: 1px solid var(--border-color); padding-top: 16px; margin-top: 8px;">
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-dark); margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                        <span>📊</span> Statistik Cepat
                    </div>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px;">
                        <li style="padding: 12px; background: linear-gradient(135deg, rgba(255, 107, 53, 0.1) 0%, rgba(255, 107, 53, 0.05) 100%); border-left: 4px solid var(--primary); border-radius: 6px; font-size: 12px;">
                            <div style="color: var(--primary); font-weight: 700;"><?php echo e($totalPendaftaran); ?></div>
                            <div style="color: var(--text-light); font-size: 11px;">Total Pendaftar</div>
                        </li>
                        <li style="padding: 12px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(245, 158, 11, 0.05) 100%); border-left: 4px solid #f59e0b; border-radius: 6px; font-size: 12px;">
                            <div style="color: #f59e0b; font-weight: 700;"><?php echo e($menunggu); ?></div>
                            <div style="color: var(--text-light); font-size: 11px;">Menunggu Verifikasi</div>
                        </li>
                        <li style="padding: 12px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%); border-left: 4px solid #10b981; border-radius: 6px; font-size: 12px;">
                            <div style="color: #10b981; font-weight: 700;"><?php echo e($diterima); ?></div>
                            <div style="color: var(--text-light); font-size: 11px;">Diterima</div>
                        </li>
                    </ul>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="card">
        <div class="card-header">
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="ti ti-clock" style="color: var(--primary);"></i>
                10 Pendaftar Terbaru
            </div>
            <a href="<?php echo e(route('admin.siswa.index')); ?>" class="btn btn-primary">Lihat Semua</a>
        </div>
        <div class="card-body">
            <?php if($recentRegistrations->count() > 0): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th width="20%">👤 Nama</th>
                                <th width="15%">🔑 NISN</th>
                                <th width="20%">📚 Jurusan</th>
                                <th width="15%">📅 Tanggal</th>
                                <th width="15%">📊 Status</th>
                                <th width="15%">⚙️ Aksi</th>
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
                <div style="text-align: center; padding: 40px; color: var(--text-light);">
                    <div style="font-size: 48px; margin-bottom: 12px;">📭</div>
                    <p>Belum ada pendaftar terdaftar</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\aplikasi_ppdb_2\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>