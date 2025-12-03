<?php $__env->startSection('page_title', 'Daftar Siswa'); ?>

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<div class="page-wrapper">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header d-print-none mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        <i class="fas fa-users" style="margin-right: 10px;"></i>Daftar Siswa Pendaftar
                    </h2>
                    <div class="text-muted mt-1">
                        Total: <strong><?php echo e($siswa->total()); ?></strong> siswa
                        <?php if($gelombang): ?>
                            di Gelombang <strong><?php echo e($gelombang); ?></strong>
                        <?php endif; ?>
                        <?php if($search): ?>
                            | Pencarian: <strong>"<?php echo e($search); ?>"</strong>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="card mb-3">
            <div class="card-body">
                <form action="<?php echo e(route('admin.siswa.index')); ?>" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Gelombang</label>
                        <select name="gelombang" class="form-select">
                            <option value="">-- Semua Gelombang --</option>
                            <?php $__currentLoopData = $gelombangList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($gb); ?>" <?php echo e($gelombang == $gb ? 'selected' : ''); ?>>
                                    Gelombang <?php echo e($gb); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Cari Siswa</label>
                        <input type="text" name="search" class="form-control" placeholder="Nama atau NISN..." value="<?php echo e($search); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <a href="<?php echo e(route('admin.siswa.index')); ?>" class="btn btn-secondary w-100">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Siswa</th>
                            <th>NISN</th>
                            <th>Gelombang</th>
                            <th>Jurusan Pilihan</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th class="text-end" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($loop->iteration + ($siswa->currentPage() - 1) * $siswa->perPage()); ?></td>
                                <td>
                                    <div class="font-weight-medium"><?php echo e($item->nama_lengkap); ?></div>
                                    <div class="text-muted text-sm"><?php echo e($item->asal_sekolah ?? '-'); ?></div>
                                </td>
                                <td class="font-monospace"><?php echo e($item->nisn); ?></td>
                                <td>
                                    <?php
                                        $pendaftaran = $item->pendaftaran()->first();
                                        $gelombangColors = [
                                            1 => 'bg-primary',
                                            2 => 'bg-success', 
                                            3 => 'bg-danger',
                                            4 => 'bg-warning',
                                        ];
                                        $badgeColor = $gelombangColors[$pendaftaran?->gelombang] ?? 'bg-secondary';
                                    ?>
                                    <?php if($pendaftaran): ?>
                                        <span class="badge <?php echo e($badgeColor); ?> text-white">Gelombang <?php echo e($pendaftaran->gelombang); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                        $pendaftaran = $pendaftaran ?? $item->pendaftaran()->first();
                                    ?>
                                    <?php if($pendaftaran?->jurusanPilihan1): ?>
                                        <span class="badge bg-info text-white"><?php echo e($pendaftaran->jurusanPilihan1->nama_jurusan); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                        $pendaftaran = $pendaftaran ?? $item->pendaftaran()->first();
                                    ?>
                                    <?php if($pendaftaran?->statusPendaftaran): ?>
                                        <?php
                                            $statusKode = $pendaftaran->statusPendaftaran->kode;
                                            $statusBadge = match($statusKode) {
                                                'diterima' => 'bg-success',
                                                'menunggu' => 'bg-warning',
                                                'ditolak' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        ?>
                                        <span class="badge <?php echo e($statusBadge); ?> text-white">
                                            <?php echo e($pendaftaran->statusPendaftaran->label); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                        $pendaftaran = $pendaftaran ?? $item->pendaftaran()->first();
                                    ?>
                                    <?php if($pendaftaran?->tanggal_daftar): ?>
                                        <?php echo e($pendaftaran->tanggal_daftar->format('d M Y')); ?>

                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <?php
                                        $pendaftaran = $pendaftaran ?? $item->pendaftaran()->first();
                                        $status = $pendaftaran?->statusPendaftaran?->kode;
                                    ?>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?php echo e(route('admin.siswa.show', $item->id)); ?>" class="btn btn-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if($status === 'menunggu'): ?>
                                            <button type="button" class="btn btn-success btn-accept" data-siswa-id="<?php echo e($item->id); ?>" data-siswa-name="<?php echo e($item->nama_lengkap); ?>" title="Terima">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-reject" data-siswa-id="<?php echo e($item->id); ?>" data-siswa-name="<?php echo e($item->nama_lengkap); ?>" title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="fas fa-inbox" style="font-size: 40px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                                    <p>Tidak ada data siswa</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex align-items-center">
                <?php echo e($siswa->links()); ?>

            </div>
        </div>
    </div>
</div>

<script>
    // Accept student
    document.querySelectorAll('.btn-accept').forEach(btn => {
        btn.addEventListener('click', function() {
            const siswaId = this.dataset.siswaId;
            const siswaName = this.dataset.siswaName;

            Swal.fire({
                title: 'Terima Pendaftar?',
                html: `<strong>${siswaName}</strong> akan diterima sebagai siswa baru`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Terima',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/siswa/${siswaId}/accept`;
                    form.innerHTML = `
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="siswa_id" value="${siswaId}">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    // Reject student
    document.querySelectorAll('.btn-reject').forEach(btn => {
        btn.addEventListener('click', function() {
            const siswaId = this.dataset.siswaId;
            const siswaName = this.dataset.siswaName;

            Swal.fire({
                title: 'Tolak Pendaftar?',
                html: `<strong>${siswaName}</strong> akan ditolak dan tidak diterima`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/siswa/${siswaId}/reject`;
                    form.innerHTML = `
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="siswa_id" value="${siswaId}">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppdb_denico_09\resources\views/admin/siswa/index.blade.php ENDPATH**/ ?>