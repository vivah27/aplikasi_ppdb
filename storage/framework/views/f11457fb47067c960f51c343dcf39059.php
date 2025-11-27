<?php $__env->startSection('page_title', 'Profil Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header mb-3">
    <h1 class="page-title"><i class="fas fa-user-circle me-2"></i>Profil Saya</h1>
    <p class="page-subtitle">Lihat dan perbarui informasi profil Anda</p>
</div>

<?php
    $user = auth()->user();
    $siswa = $user ? $user->siswa : null;
    $dokumenCount = $siswa ? $siswa->dokumen()->count() : 0;
    $pendaftaran = $siswa ? $siswa->pendaftaran()->first() : null;
    $statusPendaftaran = $pendaftaran ? $pendaftaran->statusPendaftaran : null;
?>

<div class="row g-3">
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <?php if($siswa && $siswa->foto): ?>
                    <img src="<?php echo e(asset('storage/' . $siswa->foto)); ?>" alt="Foto Profil" class="rounded-circle mb-3" style="width:110px;height:110px;object-fit:cover;">
                <?php elseif($user && $user->avatar): ?>
                    <img src="<?php echo e(asset('storage/' . $user->avatar)); ?>" alt="avatar" class="rounded-circle mb-3" style="width:110px;height:110px;object-fit:cover;">
                <?php else: ?>
                    <div class="user-avatar mb-3" style="width:110px;height:110px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:32px;background:#e9ecef;"><?php echo e(strtoupper(substr($user->name ?? 'U', 0, 1))); ?></div>
                <?php endif; ?>

                <h4 class="mb-0"><?php echo e(optional($siswa)->nama_lengkap ?? $user->name ?? 'Pengguna'); ?></h4>
                <p class="text-muted"><?php echo e(optional($siswa)->nisn ?? '-'); ?></p>

                <div class="d-grid gap-2 mt-3">
                    <a href="<?php echo e(route('profil.edit')); ?>" class="btn btn-primary"><i class="fas fa-edit me-1"></i>Edit Profil</a>
                    <a href="<?php echo e(route('password.change')); ?>" class="btn btn-outline-secondary"><i class="fas fa-key me-1"></i>Ubah Password</a>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="mb-3">Ringkasan</h6>
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted">Dokumen</small>
                    <strong><?php echo e($dokumenCount); ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted">Pendaftaran</small>
                    <strong><?php echo e(optional($pendaftaran)->nomor_pendaftaran ?? '-'); ?></strong>
                </div>
                <div class="d-flex justify-content-between">
                    <small class="text-muted">Status</small>
                    <span class="badge badge-<?php echo e($statusPendaftaran && $statusPendaftaran->nama == 'Diterima' ? 'success' : ($statusPendaftaran && $statusPendaftaran->nama == 'Menunggu' ? 'warning' : 'secondary')); ?>">
                        <?php echo e($statusPendaftaran ? $statusPendaftaran->nama : 'Belum Daftar'); ?>

                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-8">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Tentang Saya</h5>
            </div>
            <div class="card-body">
                <p class="mb-0"><?php echo e(optional($siswa)->bio ?? 'Belum ada deskripsi tentang diri.'); ?></p>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Detail Personal</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 mb-3">
                        <small class="text-muted">Nama Lengkap</small>
                        <div><?php echo e(optional($siswa)->nama_lengkap ?? $user->name ?? '-'); ?></div>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted">Email</small>
                        <div><?php echo e($user->email ?? '-'); ?></div>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted">NISN</small>
                        <div><?php echo e(optional($siswa)->nisn ?? '-'); ?></div>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted">NIK</small>
                        <div><?php echo e(optional($siswa)->nik ?? '-'); ?></div>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted">Tempat, Tanggal Lahir</small>
                        <div>
                            <?php
                                $tempat = optional($siswa)->tempat_lahir ?? '-';
                                $tanggal = optional($siswa)->tanggal_lahir ? optional($siswa)->tanggal_lahir->format('d M Y') : '-';
                            ?>
                            <?php echo e($tempat . ', ' . $tanggal); ?>

                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted">Jenis Kelamin</small>
                        <div><?php echo e(optional($siswa)->jenis_kelamin ?? '-'); ?></div>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted">Asal Sekolah</small>
                        <div><?php echo e(optional($siswa)->asal_sekolah ?? '-'); ?></div>
                    </div>
                    <div class="col-6 mb-3">
                        <small class="text-muted">No. Telepon</small>
                        <div><?php echo e(optional($siswa)->no_telepon ?? '-'); ?></div>
                    </div>
                    <div class="col-12">
                        <small class="text-muted">Alamat</small>
                        <div><?php echo e(optional($siswa)->alamat ?? '-'); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Aktivitas Terakhir</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php if($siswa): ?>
                        <?php $__empty_1 = true; $__currentLoopData = $siswa->dokumen()->latest()->limit(5)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?php echo e(optional($doc->jenisDokumen)->nama ?? 'Dokumen'); ?></strong>
                                    <div class="text-muted small"><?php echo e($doc->created_at->diffForHumans()); ?></div>
                                </div>
                                <div>
                                    <a href="<?php echo e(route('user.dokumen.download', $doc->id)); ?>" class="btn btn-sm btn-outline-primary">Download</a>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="list-group-item text-muted">Belum ada dokumen.</li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="list-group-item text-muted">Belum ada data siswa.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\aplikasi_ppdb\resources\views/myprofile.blade.php ENDPATH**/ ?>