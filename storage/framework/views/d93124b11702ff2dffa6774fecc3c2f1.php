

<?php $__env->startSection('page_title', 'Detail Siswa'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .detail-header {
        background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
        color: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .detail-title {
        font-size: 24px;
        font-weight: 700;
        margin: 0;
    }

    .detail-subtitle {
        font-size: 14px;
        opacity: 0.9;
        margin-top: 8px;
    }

    .back-btn {
        padding: 10px 16px;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        border-radius: 6px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }

    .back-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .info-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .info-card-header {
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        padding: 16px 20px;
        border-bottom: 1px solid #e5e7eb;
        font-weight: 600;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 15px;
    }

    .info-card-body {
        padding: 20px;
    }

    .info-item {
        margin-bottom: 16px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 16px;
        border-bottom: 1px solid #f3f4f6;
    }

    .info-item:last-child {
        margin-bottom: 0;
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-label {
        font-weight: 600;
        color: #6b7280;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        min-width: 150px;
    }

    .info-value {
        color: #1f2937;
        font-weight: 500;
        text-align: right;
        flex: 1;
    }

    .badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-primary { background: rgba(99, 102, 241, 0.15); color: #6366f1; }
    .badge-success { background: rgba(16, 185, 129, 0.15); color: #10b981; }
    .badge-warning { background: rgba(245, 158, 11, 0.15); color: #f59e0b; }
    .badge-danger { background: rgba(239, 68, 68, 0.15); color: #ef4444; }

    .photo-container {
        text-align: center;
        padding: 20px;
    }

    .photo-image {
        width: 200px;
        height: 200px;
        border-radius: 12px;
        object-fit: cover;
        border: 3px solid #f3f4f6;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .photo-placeholder {
        width: 200px;
        height: 200px;
        border-radius: 12px;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: #9ca3af;
        font-size: 60px;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 10px 16px;
        border-radius: 6px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s;
        font-size: 13px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        color: white;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
        color: white;
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #1f2937;
    }

    .btn-secondary:hover {
        background: #d1d5db;
    }
</style>

<div style="max-width: 1200px; margin: 0 auto;">
    <!-- Header -->
    <div class="detail-header">
        <div>
            <h1 class="detail-title"><?php echo e($siswa->nama_lengkap); ?></h1>
            <p class="detail-subtitle">NISN: <?php echo e($siswa->nisn); ?></p>
        </div>
        <a href="<?php echo e(route('admin.siswa.index')); ?>" class="back-btn">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Photo & Personal Info -->
    <div class="info-grid">
        <!-- Photo Card -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-image"></i> Foto Profil
            </div>
            <div class="photo-container">
                <?php if($siswa->foto): ?>
                    <img src="<?php echo e(asset('storage/' . $siswa->foto)); ?>" alt="Foto <?php echo e($siswa->nama_lengkap); ?>" class="photo-image">
                <?php else: ?>
                    <div class="photo-placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Personal Info Card -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-user-circle"></i> Informasi Pribadi
            </div>
            <div class="info-card-body">
                <div class="info-item">
                    <span class="info-label">Nama Lengkap</span>
                    <span class="info-value"><strong><?php echo e($siswa->nama_lengkap); ?></strong></span>
                </div>
                <div class="info-item">
                    <span class="info-label">NISN</span>
                    <span class="info-value"><strong><?php echo e($siswa->nisn); ?></strong></span>
                </div>
                <div class="info-item">
                    <span class="info-label">NIK</span>
                    <span class="info-value"><?php echo e($siswa->nik ?? '-'); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Jenis Kelamin</span>
                    <span class="info-value">
                        <?php if($siswa->jenis_kelamin === 'L'): ?>
                            <span class="badge badge-primary">Laki-laki</span>
                        <?php elseif($siswa->jenis_kelamin === 'P'): ?>
                            <span class="badge badge-primary">Perempuan</span>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tempat Lahir</span>
                    <span class="info-value"><?php echo e($siswa->tempat_lahir ?? '-'); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Lahir</span>
                    <span class="info-value"><?php echo e($siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('d M Y') : '-'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact & Address Info -->
    <div class="info-grid">
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-phone"></i> Kontak
            </div>
            <div class="info-card-body">
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value"><?php echo e($siswa->email ?? '-'); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">No. HP</span>
                    <span class="info-value"><?php echo e($siswa->no_hp ?? '-'); ?></span>
                </div>
            </div>
        </div>

        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-map-marker-alt"></i> Alamat
            </div>
            <div class="info-card-body">
                <div class="info-item">
                    <span class="info-label">Alamat</span>
                    <span class="info-value"><?php echo e($siswa->alamat ?? '-'); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Asal Sekolah</span>
                    <span class="info-value"><?php echo e($siswa->asal_sekolah ?? '-'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pendaftaran Info -->
    <?php if($pendaftaran): ?>
        <div class="info-grid">
            <div class="info-card" style="grid-column: 1 / -1;">
                <div class="info-card-header">
                    <i class="fas fa-clipboard-list"></i> Informasi Pendaftaran
                </div>
                <div class="info-card-body">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                        <div>
                            <div class="info-label">Nomor Pendaftaran</div>
                            <div style="color: #1f2937; font-weight: 600; font-size: 14px; margin-top: 6px;"><?php echo e($pendaftaran->nomor_pendaftaran ?? '-'); ?></div>
                        </div>
                        <div>
                            <div class="info-label">Gelombang</div>
                            <div style="margin-top: 6px;">
                                <span class="badge badge-primary">Gelombang <?php echo e($pendaftaran->gelombang ?? '-'); ?></span>
                            </div>
                        </div>
                        <div>
                            <div class="info-label">Tanggal Daftar</div>
                            <div style="color: #1f2937; font-weight: 600; font-size: 14px; margin-top: 6px;"><?php echo e($pendaftaran->tanggal_daftar ? $pendaftaran->tanggal_daftar->format('d M Y') : '-'); ?></div>
                        </div>
                        <div>
                            <div class="info-label">Status Pendaftaran</div>
                            <div style="margin-top: 6px;">
                                <?php
                                    $statusKode = $pendaftaran->statusPendaftaran?->kode;
                                    $badgeClass = match($statusKode) {
                                        'diterima' => 'badge-success',
                                        'menunggu' => 'badge-warning',
                                        'ditolak' => 'badge-danger',
                                        default => 'badge-primary'
                                    };
                                ?>
                                <span class="badge <?php echo e($badgeClass); ?>"><?php echo e($pendaftaran->statusPendaftaran?->label ?? 'Menunggu'); ?></span>
                            </div>
                        </div>
                        <div>
                            <div class="info-label">Jurusan Pilihan 1</div>
                            <div style="color: #1f2937; font-weight: 600; font-size: 14px; margin-top: 6px;"><?php echo e($pendaftaran->jurusanPilihan1?->nama_jurusan ?? '-'); ?></div>
                        </div>
                        <div>
                            <div class="info-label">Jurusan Pilihan 2</div>
                            <div style="color: #1f2937; font-weight: 600; font-size: 14px; margin-top: 6px;"><?php echo e($pendaftaran->jurusanPilihan2?->nama_jurusan ?? '-'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <?php if($pendaftaran->statusPendaftaran?->kode === 'menunggu'): ?>
            <div class="info-card" style="border: 2px solid #e5e7eb;">
                <div class="info-card-header">
                    <i class="fas fa-check-double"></i> Verifikasi Status
                </div>
                <div class="info-card-body">
                    <p style="color: #6b7280; margin-bottom: 16px;">Pilih tindakan untuk mengubah status pendaftaran siswa ini:</p>
                    <div class="action-buttons">
                        <button type="button" class="btn btn-success btn-accept" data-siswa-id="<?php echo e($siswa->id); ?>" data-siswa-name="<?php echo e($siswa->nama_lengkap); ?>">
                            <i class="fas fa-check-circle"></i> Terima
                        </button>
                        <button type="button" class="btn btn-danger btn-reject" data-siswa-id="<?php echo e($siswa->id); ?>" data-siswa-name="<?php echo e($siswa->nama_lengkap); ?>">
                            <i class="fas fa-times-circle"></i> Tolak
                        </button>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="info-card" style="border: 2px solid #e5e7eb; background: #f9fafb;">
                <div class="info-card-header">
                    <i class="fas fa-info-circle"></i> Status Sudah Diputuskan
                </div>
                <div class="info-card-body">
                    <p style="color: #6b7280;">Status pendaftaran siswa ini sudah diputuskan dan tidak dapat diubah lagi.</p>
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="info-card">
            <div class="info-card-body" style="text-align: center; padding: 40px;">
                <div style="color: #9ca3af; font-size: 40px; margin-bottom: 12px;">
                    <i class="fas fa-inbox"></i>
                </div>
                <p style="color: #6b7280;">Siswa ini belum memiliki data pendaftaran</p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Reset Biodata Section -->
    <div class="info-card" style="border: 2px dashed #ef4444; background: rgba(239, 68, 68, 0.02);">
        <div class="info-card-header" style="background: rgba(239, 68, 68, 0.1); border-bottom: 2px solid #ef4444;">
            <i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i> <span style="color: #ef4444;">Reset Data Biodata</span>
        </div>
        <div class="info-card-body">
            <p style="color: #6b7280; margin-bottom: 16px;">
                <strong>Perhatian:</strong> Reset biodata akan menghapus semua data biodata siswa ini dan membuat form biodata dapat diisi ulang. Tindakan ini tidak dapat dibatalkan.
            </p>
            <button type="button" class="btn btn-danger btn-reset-biodata" data-siswa-id="<?php echo e($siswa->id); ?>" data-siswa-name="<?php echo e($siswa->nama_lengkap); ?>">
                <i class="fas fa-redo"></i> Reset Biodata
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
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
                cancelButtonText: 'Batal'
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
                cancelButtonText: 'Batal'
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

    // Reset Biodata
    document.querySelectorAll('.btn-reset-biodata').forEach(btn => {
        btn.addEventListener('click', function() {
            const siswaId = this.dataset.siswaId;
            const siswaName = this.dataset.siswaName;

            Swal.fire({
                title: 'Reset Biodata?',
                html: `<strong>${siswaName}</strong><br><br>Semua data biodata akan dihapus dan form akan dapat diisi ulang. Tindakan ini tidak dapat dibatalkan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Reset Biodata',
                cancelButtonText: 'Batal',
                didOpen: (modal) => {
                    const confirmBtn = modal.querySelector('.swal2-confirm');
                    confirmBtn.style.backgroundColor = '#ef4444';
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/siswa/${siswaId}/reset-biodata`;
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

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppdb_denico_09\resources\views/admin/siswa/show.blade.php ENDPATH**/ ?>