

<?php $__env->startSection('page_title', 'Verifikasi Dokumen Siswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 style="font-size: 32px; font-weight: 700; color: #1f2937; margin-bottom: 8px;">Verifikasi Dokumen Siswa</h1>
            <p style="color: #6b7280; font-size: 15px; margin: 0;">Kelola dan verifikasi dokumen siswa dengan mudah</p>
        </div>
    </div>

    <!-- Breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background: white; padding: 12px 16px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin: 0;">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>" style="color: #0ea5e9; text-decoration: none; font-weight: 500;">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.verifikasi')); ?>" style="color: #0ea5e9; text-decoration: none; font-weight: 500;">Verifikasi Dokumen</a></li>
                    <li class="breadcrumb-item active" style="color: #1f2937; font-weight: 600;"><?php echo e($siswa->nama_lengkap); ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-dismissible fade show" role="alert" style="background: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; border-radius: 10px; color: #059669; padding: 14px 16px;">
            <i class="fas fa-check-circle me-2" style="color: #10b981;"></i>
            <strong>Berhasil!</strong> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" style="color: #10b981; opacity: 0.7;"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-dismissible fade show" role="alert" style="background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; border-radius: 10px; color: #dc2626; padding: 14px 16px;">
            <i class="fas fa-exclamation-circle me-2" style="color: #ef4444;"></i>
            <strong>Error!</strong> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" style="color: #ef4444; opacity: 0.7;"></button>
        </div>
    <?php endif; ?>

    <!-- Siswa Info Card -->
    <div class="card mb-4" style="border: none; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1); border-radius: 12px; overflow: hidden;">
        <div style="background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%); padding: 20px; color: white;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-user-circle" style="font-size: 28px; opacity: 0.9;"></i>
                <h5 style="margin: 0; font-weight: 700; font-size: 20px;">Informasi Siswa</h5>
            </div>
        </div>
        <div class="card-body" style="background: #f9fafb; padding: 25px;">
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <!-- Nama Lengkap -->
                    <div style="margin-bottom: 18px; padding-bottom: 15px; border-bottom: 1px solid #e5e7eb;">
                        <label style="display: block; color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                            <i class="fas fa-id-card" style="margin-right: 6px; color: #6366f1;"></i>Nama Lengkap
                        </label>
                        <p style="margin: 0; color: #1f2937; font-size: 15px; font-weight: 600;">
                            <?php echo e($siswa->nama_lengkap); ?>

                        </p>
                    </div>

                    <!-- NISN -->
                    <div style="margin-bottom: 18px; padding-bottom: 15px; border-bottom: 1px solid #e5e7eb;">
                        <label style="display: block; color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                            <i class="fas fa-barcode" style="margin-right: 6px; color: #6366f1;"></i>NISN
                        </label>
                        <p style="margin: 0; color: #1f2937; font-size: 15px; font-weight: 600;">
                            <?php echo e($siswa->nisn); ?>

                        </p>
                    </div>

                    <!-- NIK -->
                    <div style="margin-bottom: 0;">
                        <label style="display: block; color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                            <i class="fas fa-credit-card" style="margin-right: 6px; color: #6366f1;"></i>NIK
                        </label>
                        <p style="margin: 0; color: #1f2937; font-size: 15px; font-weight: 600;">
                            <?php echo e($siswa->nik ?? '-'); ?>

                        </p>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <!-- Jenis Kelamin -->
                    <div style="margin-bottom: 18px; padding-bottom: 15px; border-bottom: 1px solid #e5e7eb;">
                        <label style="display: block; color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                            <i class="fas fa-venus-mars" style="margin-right: 6px; color: #6366f1;"></i>Jenis Kelamin
                        </label>
                        <p style="margin: 0; color: #1f2937; font-size: 15px; font-weight: 600;">
                            <span style="display: inline-block; padding: 4px 10px; background: <?php echo e($siswa->jenis_kelamin === 'L' ? 'rgba(59, 130, 246, 0.15); color: #3b82f6;' : 'rgba(236, 72, 153, 0.15); color: #ec4899;'); ?> border-radius: 6px;">
                                <?php echo e($siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'); ?>

                            </span>
                        </p>
                    </div>

                    <!-- Asal Sekolah -->
                    <div style="margin-bottom: 18px; padding-bottom: 15px; border-bottom: 1px solid #e5e7eb;">
                        <label style="display: block; color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                            <i class="fas fa-school" style="margin-right: 6px; color: #6366f1;"></i>Asal Sekolah
                        </label>
                        <p style="margin: 0; color: #1f2937; font-size: 15px; font-weight: 600;">
                            <?php echo e($siswa->asal_sekolah ?? '-'); ?>

                        </p>
                    </div>

                    <!-- Total Dokumen -->
                    <div style="margin-bottom: 0;">
                        <label style="display: block; color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                            <i class="fas fa-folder-open" style="margin-right: 6px; color: #6366f1;"></i>Total Dokumen
                        </label>
                        <p style="margin: 0;">
                            <span style="display: inline-block; padding: 6px 14px; background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%); color: white; border-radius: 8px; font-weight: 600; font-size: 14px;">
                                <?php echo e($siswa->dokumen->count()); ?> Dokumen
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents List -->
    <div class="card" style="border: none; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.1); border-radius: 12px; overflow: hidden;">
        <div style="background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%); padding: 20px; color: white;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-file-alt" style="font-size: 28px; opacity: 0.9;"></i>
                <h5 style="margin: 0; font-weight: 700; font-size: 20px;">Daftar Dokumen</h5>
            </div>
        </div>
        <div class="card-body p-0" style="background: white;">
            <?php if($dokumen->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="border-collapse: collapse;">
                        <thead style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                            <tr>
                                <th width="5%" style="padding: 15px; color: #6b7280; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">No</th>
                                <th width="25%" style="padding: 15px; color: #6b7280; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Jenis Dokumen</th>
                                <th width="20%" style="padding: 15px; color: #6b7280; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
                                <th width="20%" style="padding: 15px; color: #6b7280; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Tanggal Upload</th>
                                <th width="30%" style="padding: 15px; color: #6b7280; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $dokumen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr style="border-bottom: 1px solid #f3f4f6; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#f9fafb'" onmouseout="this.style.backgroundColor=''">
                                    <td class="align-middle" style="padding: 15px; color: #1f2937;"><?php echo e($loop->iteration); ?></td>
                                    <td class="align-middle" style="padding: 15px;">
                                        <div style="color: #1f2937; font-weight: 600; font-size: 14px;"><?php echo e($item->jenisDokumen->nama); ?></div>
                                        <small style="color: #6b7280; display: block; margin-top: 4px;"><?php echo e($item->jenisDokumen->deskripsi ?? '-'); ?></small>
                                    </td>
                                    <td class="align-middle" style="padding: 15px;">
                                        <?php if($item->statusVerifikasi): ?>
                                            <?php if($item->statusVerifikasi->kode === 'verified'): ?>
                                                <span style="display: inline-block; padding: 6px 12px; background: rgba(16, 185, 129, 0.15); color: #10b981; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                                    <i class="fas fa-check-circle me-1"></i><?php echo e($item->statusVerifikasi->label); ?>

                                                </span>
                                            <?php elseif($item->statusVerifikasi->kode === 'rejected'): ?>
                                                <span style="display: inline-block; padding: 6px 12px; background: rgba(239, 68, 68, 0.15); color: #ef4444; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                                    <i class="fas fa-times-circle me-1"></i><?php echo e($item->statusVerifikasi->label); ?>

                                                </span>
                                            <?php else: ?>
                                                <span style="display: inline-block; padding: 6px 12px; background: rgba(245, 158, 11, 0.15); color: #f59e0b; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                                    <i class="fas fa-clock me-1"></i><?php echo e($item->statusVerifikasi->label); ?>

                                                </span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span style="display: inline-block; padding: 6px 12px; background: rgba(107, 114, 128, 0.15); color: #6b7280; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                                <i class="fas fa-hourglass me-1"></i>Menunggu
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle" style="padding: 15px; color: #1f2937; font-size: 14px;">
                                        <?php echo e($item->created_at->format('d M Y H:i')); ?>

                                    </td>
                                    <td class="align-middle" style="padding: 15px;">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?php echo e(route('admin.verifikasi.preview', $item->id)); ?>" target="_blank" class="btn" style="padding: 6px 10px; background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%); color: white; border: none; border-radius: 6px; font-size: 11px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(14, 165, 233, 0.3)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                                                <i class="fas fa-eye" style="font-size: 11px;"></i> Lihat
                                            </a>
                                            <form action="<?php echo e(route('admin.verifikasi.accept', $item->id)); ?>" method="POST" style="display: inline;" class="verify-accept-form">
                                                <?php echo csrf_field(); ?>
                                                <button type="button" class="btn btn-verify-accept" data-dokumen-id="<?php echo e($item->id); ?>" data-dokumen-name="<?php echo e($item->jenisDokumen->nama); ?>" style="padding: 6px 10px; background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%); color: white; border: none; border-radius: 6px; font-size: 11px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: all 0.3s; cursor: pointer; margin-left: -1px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(139, 92, 246, 0.3)'" onmouseout="this.style.transform=''; this.style.boxShadow=''" title="Terima Dokumen">
                                                    <i class="fas fa-check" style="font-size: 11px;"></i> Terima
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('admin.verifikasi.reject', $item->id)); ?>" method="POST" style="display: inline;" class="verify-reject-form">
                                                <?php echo csrf_field(); ?>
                                                <button type="button" class="btn btn-verify-reject" data-dokumen-id="<?php echo e($item->id); ?>" data-dokumen-name="<?php echo e($item->jenisDokumen->nama); ?>" style="padding: 6px 10px; background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); color: white; border: none; border-radius: 6px; font-size: 11px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: all 0.3s; cursor: pointer; margin-left: -1px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(239, 68, 68, 0.3)'" onmouseout="this.style.transform=''; this.style.boxShadow=''" title="Tolak Dokumen">
                                                    <i class="fas fa-times" style="font-size: 11px;"></i> Tolak
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="p-5 text-center" style="background: #f9fafb;">
                    <i class="fas fa-inbox" style="font-size: 50px; opacity: 0.3; margin-bottom: 10px; display: block;"></i>
                    <p class="text-muted" style="margin: 0; color: #6b7280; font-size: 15px;">Siswa ini belum mengunggah dokumen apapun</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-4">
        <a href="<?php echo e(route('admin.verifikasi')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>
</div>

<!-- SweetAlert2 Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Setup CSRF token for AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || 
                     document.querySelector('input[name="_token"]')?.value;

    // Handle Verify Accept buttons
    document.querySelectorAll('.btn-verify-accept').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const dokumenName = this.dataset.dokumenName;
            const form = this.closest('form');

            Swal.fire({
                icon: 'question',
                title: 'Terima Dokumen',
                html: `<p>Apakah Anda yakin ingin <strong>menerima</strong> dokumen:</p><p><strong style="color: #6366f1;">${dokumenName}</strong>?</p>`,
                showCancelButton: true,
                confirmButtonText: 'Ya, Terima',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form via AJAX for smooth experience
                    const formData = new FormData(form);
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Dokumen berhasil diterima',
                            confirmButtonColor: '#10b981',
                            timer: 1500,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.reload();
                            }
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat memproses dokumen',
                            confirmButtonColor: '#ef4444'
                        });
                    });
                }
            });
        });
    });

    // Handle Verify Reject buttons
    document.querySelectorAll('.btn-verify-reject').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const dokumenName = this.dataset.dokumenName;
            const form = this.closest('form');

            Swal.fire({
                icon: 'warning',
                title: 'Tolak Dokumen',
                html: `<p>Apakah Anda yakin ingin <strong>menolak</strong> dokumen:</p><p><strong style="color: #ef4444;">${dokumenName}</strong>?</p>`,
                showCancelButton: true,
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form via AJAX for smooth experience
                    const formData = new FormData(form);
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Dokumen berhasil ditolak',
                            confirmButtonColor: '#10b981',
                            timer: 1500,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.reload();
                            }
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat memproses dokumen',
                            confirmButtonColor: '#ef4444'
                        });
                    });
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppdb_denico_09\resources\views/admin/verifikasi/siswa.blade.php ENDPATH**/ ?>