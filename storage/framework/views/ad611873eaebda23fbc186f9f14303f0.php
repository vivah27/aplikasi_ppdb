

<?php $__env->startSection('page_title', 'Manajemen Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="h2 mb-1 text-dark fw-bold"><i class="ti ti-receipt-2 me-2"></i>Manajemen Pembayaran</h1>
            <p class="text-muted mb-0">Kelola dan verifikasi pembayaran dari siswa</p>
        </div>
        <a href="<?php echo e(route('admin.pembayaran.export')); ?>" class="btn btn-outline-success">
            <i class="ti ti-download me-2"></i>Export CSV
        </a>
    </div>

    <!-- Alert Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0" role="alert">
            <div class="d-flex align-items-center">
                <i class="ti ti-check-circle me-2 fs-5"></i>
                <div>
                    <strong>Sukses!</strong> <?php echo e(session('success')); ?>

                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0" role="alert">
            <div class="d-flex align-items-center">
                <i class="ti ti-alert-circle me-2 fs-5"></i>
                <div>
                    <strong>Error!</strong> <?php echo e(session('error')); ?>

                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Status Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4 col-sm-6">
            <div class="card border-0 h-100 shadow-sm hover-shadow transition">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 fs-sm">
                            <i class="ti ti-clock me-1"></i>Menunggu Verifikasi
                        </p>
                        <h3 class="mb-0 text-warning fw-bold"><?php echo e($statusSummary['Menunggu Verifikasi']); ?></h3>
                    </div>
                    <div class="text-warning" style="font-size: 2.5rem; opacity: 0.2;">
                        <i class="ti ti-hourglass-empty"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card border-0 h-100 shadow-sm hover-shadow transition">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 fs-sm">
                            <i class="ti ti-circle-check me-1"></i>Terverifikasi
                        </p>
                        <h3 class="mb-0 text-success fw-bold"><?php echo e($statusSummary['Terverifikasi']); ?></h3>
                    </div>
                    <div class="text-success" style="font-size: 2.5rem; opacity: 0.2;">
                        <i class="ti ti-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card border-0 h-100 shadow-sm hover-shadow transition">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 fs-sm">
                            <i class="ti ti-x me-1"></i>Ditolak
                        </p>
                        <h3 class="mb-0 text-danger fw-bold"><?php echo e($statusSummary['Ditolak']); ?></h3>
                    </div>
                    <div class="text-danger" style="font-size: 2.5rem; opacity: 0.2;">
                        <i class="ti ti-circle-x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="mb-0 fw-bold"><i class="ti ti-filter me-2"></i>Filter & Pencarian</h6>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.pembayaran.index')); ?>" method="GET" class="row g-3">
                <div class="col-md-2 col-sm-6">
                    <label class="form-label small fw-bold text-dark">Cari Nama/Metode</label>
                    <input type="text" name="search" class="form-control form-control-sm border-0 bg-light" 
                           placeholder="Ketik untuk mencari..." value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-2 col-sm-6">
                    <label class="form-label small fw-bold text-dark">Status</label>
                    <select name="status" class="form-select form-select-sm border-0 bg-light">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Verifikasi" <?php echo e(request('status') === 'Menunggu Verifikasi' ? 'selected' : ''); ?>>
                            Menunggu Verifikasi
                        </option>
                        <option value="Terverifikasi" <?php echo e(request('status') === 'Terverifikasi' ? 'selected' : ''); ?>>
                            Terverifikasi
                        </option>
                        <option value="Ditolak" <?php echo e(request('status') === 'Ditolak' ? 'selected' : ''); ?>>
                            Ditolak
                        </option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6">
                    <label class="form-label small fw-bold text-dark">Metode</label>
                    <select name="metode" class="form-select form-select-sm border-0 bg-light">
                        <option value="">Semua Metode</option>
                        <option value="Transfer Bank" <?php echo e(request('metode') === 'Transfer Bank' ? 'selected' : ''); ?>>
                            Transfer Bank
                        </option>
                        <option value="E-Wallet" <?php echo e(request('metode') === 'E-Wallet' ? 'selected' : ''); ?>>
                            E-Wallet
                        </option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6">
                    <label class="form-label small fw-bold text-dark">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control form-control-sm border-0 bg-light" 
                           value="<?php echo e(request('start_date')); ?>">
                </div>
                <div class="col-md-2 col-sm-6">
                    <label class="form-label small fw-bold text-dark">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control form-control-sm border-0 bg-light" 
                           value="<?php echo e(request('end_date')); ?>">
                </div>
                <div class="col-md-2 col-sm-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">
                        <i class="ti ti-search me-1"></i>Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Pembayaran Table -->
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover table-nowrap mb-0" id="pembayaranTable">
                <thead class="bg-light sticky-top">
                    <tr>
                        <th style="width: 3%; padding: 15px 10px;">
                            <input type="checkbox" id="selectAll" class="form-check-input cursor-pointer">
                        </th>
                        <th style="width: 4%; padding: 15px 10px;">ID</th>
                        <th style="width: 14%; padding: 15px 10px;">Nama Siswa</th>
                        <th style="width: 16%; padding: 15px 10px;">Pembayaran</th>
                        <th style="width: 10%; padding: 15px 10px;">Metode</th>
                        <th style="width: 12%; padding: 15px 10px;">Jumlah</th>
                        <th style="width: 12%; padding: 15px 10px;">Status</th>
                        <th style="width: 12%; padding: 15px 10px;">Tanggal</th>
                        <th style="width: 17%; padding: 15px 10px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $pembayarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pembayaran): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="pembayaran-row align-middle border-bottom" data-id="<?php echo e($pembayaran->id); ?>">
                            <td class="ps-3">
                                <input type="checkbox" class="form-check-input pembayaran-checkbox cursor-pointer" value="<?php echo e($pembayaran->id); ?>">
                            </td>
                            <td class="ps-2">
                                <span class="badge bg-secondary"><?php echo e($pembayaran->id); ?></span>
                            </td>
                            <td class="ps-2">
                                <?php if($pembayaran->pendaftaran && $pembayaran->pendaftaran->siswa): ?>
                                    <div class="fw-bold text-dark"><?php echo e($pembayaran->pendaftaran->siswa->nama_lengkap); ?></div>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="ps-2">
                                <div class="fw-500"><?php echo e($pembayaran->nama); ?></div>
                                <?php if($pembayaran->nama_bank): ?>
                                    <small class="text-muted d-block">
                                        <i class="ti ti-building-bank me-1"></i><?php echo e($pembayaran->nama_bank); ?>

                                    </small>
                                <?php elseif($pembayaran->jenis_ewallet): ?>
                                    <small class="text-muted d-block">
                                        <i class="ti ti-wallet me-1"></i><?php echo e($pembayaran->jenis_ewallet); ?>

                                    </small>
                                <?php endif; ?>
                            </td>
                            <td class="ps-2">
                                <span class="badge bg-light text-dark border border-light"><?php echo e($pembayaran->metode); ?></span>
                            </td>
                            <td class="ps-2">
                                <div class="fw-bold text-success">
                                    Rp <?php echo e(number_format($pembayaran->jumlah, 0, ',', '.')); ?>

                                </div>
                            </td>
                            <td class="ps-2">
                                <?php
                                    $statusConfig = match($pembayaran->status) {
                                        'Menunggu Verifikasi' => ['badge' => 'warning', 'icon' => 'ti-hourglass-empty'],
                                        'Terverifikasi' => ['badge' => 'success', 'icon' => 'ti-circle-check'],
                                        'Ditolak' => ['badge' => 'danger', 'icon' => 'ti-circle-x'],
                                        default => ['badge' => 'secondary', 'icon' => 'ti-help']
                                    };
                                ?>
                                <span class="badge bg-<?php echo e($statusConfig['badge']); ?>">
                                    <i class="ti <?php echo e($statusConfig['icon']); ?> me-1"></i><?php echo e($pembayaran->status); ?>

                                </span>
                            </td>
                            <td class="ps-2">
                                <div><?php echo e($pembayaran->created_at->format('d M Y')); ?></div>
                                <small class="text-muted"><?php echo e($pembayaran->created_at->format('H:i')); ?></small>
                            </td>
                            <td class="text-center ps-1">
                                <div class="d-flex gap-2 justify-content-center flex-wrap">
                                    <a href="<?php echo e(route('admin.pembayaran.show', $pembayaran->id)); ?>" 
                                       class="btn btn-info btn-sm" title="Lihat Detail" data-bs-toggle="tooltip">
                                        <i class="ti ti-eye me-1"></i>Lihat
                                    </a>
                                    <?php if($pembayaran->status === 'Menunggu Verifikasi'): ?>
                                        <a href="<?php echo e(route('admin.pembayaran.edit', $pembayaran->id)); ?>" 
                                           class="btn btn-primary btn-sm" title="Verifikasi" data-bs-toggle="tooltip">
                                            <i class="ti ti-edit me-1"></i>Verifikasi
                                        </a>
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-danger btn-sm btn-delete-pembayaran" 
                                            data-id="<?php echo e($pembayaran->id); ?>" title="Hapus" data-bs-toggle="tooltip">
                                        <i class="ti ti-trash me-1"></i>Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="ti ti-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                                    <p class="mt-3 mb-0 fw-bold">Tidak ada data pembayaran</p>
                                    <small>Pembayaran dari siswa akan tampil di sini</small>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Bulk Action Bar -->
        <div id="bulkActionBar" class="card-footer bg-light border-top py-3 d-none">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                <div>
                    <span id="selectedCount" class="fw-bold">0 item dipilih</span>
                </div>
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-success" id="bulkVerify">
                        <i class="ti ti-circle-check me-1"></i>Verifikasi
                    </button>
                    <button type="button" class="btn btn-danger" id="bulkReject">
                        <i class="ti ti-circle-x me-1"></i>Tolak
                    </button>
                    <button type="button" class="btn btn-secondary" id="bulkClear">
                        <i class="ti ti-x me-1"></i>Batal
                    </button>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <?php if($pembayarans->hasPages()): ?>
            <div class="card-footer bg-white border-top">
                <nav>
                    <?php echo e($pembayarans->links()); ?>

                </nav>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    :root {
        --primary: #0d6efd;
        --success: #198754;
        --danger: #dc3545;
        --warning: #ffc107;
        --info: #0dcaf0;
        --muted: #6c757d;
    }

    .hover-shadow {
        transition: all 0.3s ease;
    }

    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
        transform: translateY(-2px);
    }

    .pembayaran-row {
        transition: background-color 0.2s ease;
    }

    .pembayaran-row:hover {
        background-color: rgba(13, 110, 253, 0.03);
    }

    .pembayaran-row.selected {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        color: #495057;
    }

    .btn-group-sm .btn {
        padding: 0.35rem 0.5rem;
        font-size: 0.85rem;
    }

    /* Action buttons styling */
    .btn-sm {
        padding: 0.4rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        white-space: nowrap;
    }

    .btn-info, .btn-primary, .btn-danger {
        color: white;
        border: none;
    }

    .btn-info:hover, .btn-primary:hover, .btn-danger:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }

    /* Alert styling */
    .alert {
        border-radius: 0.5rem;
        padding: 1rem 1.25rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .table {
            font-size: 0.9rem;
        }

        .btn-group-sm {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .btn-group-sm .btn {
            border-radius: 0.25rem !important;
        }

        th[style*="width"] {
            width: auto !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });

    const selectAllCheckbox = document.getElementById('selectAll');
    const pembayaranCheckboxes = document.querySelectorAll('.pembayaran-checkbox');
    const bulkActionBar = document.getElementById('bulkActionBar');
    const selectedCountSpan = document.getElementById('selectedCount');
    const bulkVerifyBtn = document.getElementById('bulkVerify');
    const bulkRejectBtn = document.getElementById('bulkReject');
    const bulkClearBtn = document.getElementById('bulkClear');

    // Select all functionality
    selectAllCheckbox.addEventListener('change', function() {
        pembayaranCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActionBar();
    });

    // Individual checkbox change
    pembayaranCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkActionBar();
            updateSelectAllCheckbox();
        });
    });

    function updateBulkActionBar() {
        const selectedCount = document.querySelectorAll('.pembayaran-checkbox:checked').length;
        
        if (selectedCount > 0) {
            bulkActionBar.classList.remove('d-none');
            selectedCountSpan.textContent = `${selectedCount} item dipilih`;
            
            // Highlight selected rows
            document.querySelectorAll('.pembayaran-row').forEach(row => {
                const checkbox = row.querySelector('.pembayaran-checkbox');
                if (checkbox.checked) {
                    row.classList.add('selected');
                } else {
                    row.classList.remove('selected');
                }
            });
        } else {
            bulkActionBar.classList.add('d-none');
        }
    }

    function updateSelectAllCheckbox() {
        const allChecked = Array.from(pembayaranCheckboxes).every(cb => cb.checked);
        const someChecked = Array.from(pembayaranCheckboxes).some(cb => cb.checked);
        selectAllCheckbox.checked = allChecked;
        selectAllCheckbox.indeterminate = someChecked && !allChecked;
    }

    // Bulk action handlers
    bulkVerifyBtn.addEventListener('click', function() {
        performBulkAction('Terverifikasi');
    });

    bulkRejectBtn.addEventListener('click', function() {
        performBulkAction('Ditolak');
    });

    bulkClearBtn.addEventListener('click', function() {
        pembayaranCheckboxes.forEach(cb => cb.checked = false);
        selectAllCheckbox.checked = false;
        selectAllCheckbox.indeterminate = false;
        updateBulkActionBar();
    });

    function performBulkAction(status) {
        const ids = Array.from(document.querySelectorAll('.pembayaran-checkbox:checked')).map(cb => cb.value);
        
        if (ids.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Pilih minimal satu pembayaran',
                confirmButtonText: 'OK',
                confirmButtonColor: '#ffc107'
            });
            return;
        }

        Swal.fire({
            icon: 'question',
            title: 'Konfirmasi',
            text: `Anda yakin ingin mengubah status ${ids.length} pembayaran menjadi ${status}?`,
            showCancelButton: true,
            confirmButtonText: 'Ya, Ubah!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }

            fetch('<?php echo e(route("admin.pembayaran.bulk-update")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({
                    ids: ids,
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#198754'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc3545'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memproses',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545'
                });
            });
        });
    }

    // Delete pembayaran
    document.querySelectorAll('.btn-delete-pembayaran').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            
            Swal.fire({
                icon: 'warning',
                title: 'Konfirmasi Hapus',
                text: 'Anda yakin ingin menghapus pembayaran ini? Tindakan ini tidak dapat dibatalkan.',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }

                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    html: 'Menghapus pembayaran...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(`/admin/pembayaran/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Response:', response);
                    console.log('Response status:', response.status);
                    
                    if (response.status === 200) {
                        return response.json().then(data => {
                            return { ok: true, data: data };
                        });
                    } else if (response.status === 204) {
                        return { ok: true, data: { success: true, message: 'Pembayaran berhasil dihapus' } };
                    } else {
                        return response.json().then(data => {
                            return { ok: false, data: data };
                        });
                    }
                })
                .then(result => {
                    if (result.ok || (result.data && result.data.success)) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: result.data?.message || 'Pembayaran berhasil dihapus',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#198754'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        throw new Error(result.data?.message || 'Gagal menghapus pembayaran');
                    }
                })
                .catch(error => {
                    console.error('Delete Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Gagal menghapus pembayaran. Silakan coba lagi.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc3545'
                    });
                });
            });
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppdb_denico_09\resources\views/admin/pembayaran/index.blade.php ENDPATH**/ ?>