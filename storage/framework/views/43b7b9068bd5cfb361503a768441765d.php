<?php $__env->startSection('page_title', 'Upload Dokumen Baru'); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width: 700px; margin: 0 auto;">
    <!-- Header -->
    <div style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <h4 style="margin: 0; color: #1f2937; font-weight: 700;">Upload Dokumen Baru</h4>
        <p style="margin: 8px 0 0 0; color: #6b7280; font-size: 14px;">Pilih jenis dokumen dan upload file Anda</p>
    </div>

    <!-- Check if all documents are uploaded -->
    <?php if(count($allJenisDokumen) == 0): ?>
        <div style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid #ef4444; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-exclamation-circle" style="font-size: 20px; color: #ef4444;"></i>
                <div>
                    <strong style="color: #ef4444; display: block; margin-bottom: 5px;">Tidak Ada Jenis Dokumen</strong>
                    <p style="margin: 0; color: #dc2626; font-size: 14px;">Belum ada jenis dokumen yang tersedia. Silakan hubungi admin.</p>
                </div>
            </div>
        </div>
        <div style="text-align: center; padding: 20px;">
            <a href="<?php echo e(route('user.dokumen')); ?>" style="padding: 12px 24px; background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s;">
                <i class="fas fa-arrow-left"></i>Kembali ke Daftar Dokumen
            </a>
        </div>
    <?php elseif(count($jenisDokumen) == 0): ?>
        <div style="background: rgba(34, 197, 94, 0.1); border-left: 4px solid #22c55e; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-check-circle" style="font-size: 20px; color: #22c55e;"></i>
                <div>
                    <strong style="color: #22c55e; display: block; margin-bottom: 5px;">Semua Dokumen Sudah Diupload</strong>
                    <p style="margin: 0; color: #16a34a; font-size: 14px;">Anda telah mengupload semua jenis dokumen yang tersedia. Setiap jenis dokumen hanya dapat diupload 1 kali saja.</p>
                </div>
            </div>
        </div>
        <div style="text-align: center; padding: 20px;">
            <a href="<?php echo e(route('user.dokumen')); ?>" style="padding: 12px 24px; background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s;">
                <i class="fas fa-arrow-left"></i>Kembali ke Daftar Dokumen
            </a>
        </div>
    <?php else: ?>
        <!-- Errors -->
        <?php if($errors->any()): ?>
            <div style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid #ef4444; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <strong style="color: #ef4444;">Validasi Gagal!</strong>
                <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li style="color: #ef4444; font-size: 14px;"><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Form Card -->
        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <form action="<?php echo e(route('user.dokumen.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <!-- Jenis Dokumen -->
                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 10px; color: #1f2937; font-weight: 600; font-size: 14px;">
                        Jenis Dokumen <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="jenis_dokumen_id" style="width: 100%; padding: 12px; border: 1px solid <?php echo e($errors->has('jenis_dokumen_id') ? '#ef4444' : '#e5e7eb'); ?>; border-radius: 8px; font-size: 14px; background: white; cursor: pointer; transition: all 0.3s;" onchange="updateJenisInfo()" id="jenis_dokumen_id" required>
                        <option value="">-- Pilih Jenis Dokumen --</option>
                        <?php $__currentLoopData = $jenisDokumen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($jenis->id); ?>" data-deskripsi="<?php echo e($jenis->deskripsi); ?>" data-wajib="<?php echo e($jenis->wajib); ?>">
                                <?php echo e($jenis->nama); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php if($errors->has('jenis_dokumen_id')): ?>
                        <p style="margin: 8px 0 0 0; color: #ef4444; font-size: 13px;"><?php echo e($errors->first('jenis_dokumen_id')); ?></p>
                    <?php endif; ?>
                    <div id="jenisInfo" style="margin-top: 12px; padding: 12px; background: #f3f4f6; border-radius: 8px; display: none;">
                        <p style="margin: 0; color: #6b7280; font-size: 13px;"><span id="jenisDeskripsi"></span></p>
                        <div id="wajibBadge" style="margin-top: 8px; display: none;">
                            <span style="display: inline-block; padding: 4px 10px; background: rgba(239, 68, 68, 0.15); color: #ef4444; border-radius: 6px; font-size: 12px; font-weight: 600;">Dokumen Wajib</span>
                        </div>
                    </div>
                </div>

                <!-- File Input -->
                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 10px; color: #1f2937; font-weight: 600; font-size: 14px;">
                        File Dokumen <span style="color: #ef4444;">*</span>
                    </label>
                    <div style="position: relative;">
                        <input type="file" name="file" id="file" accept=".pdf,.jpg,.jpeg,.png" required style="display: none;">
                        <div style="padding: 30px; border: 2px dashed <?php echo e($errors->has('file') ? '#ef4444' : '#d1d5db'); ?>; border-radius: 8px; text-align: center; cursor: pointer; background: <?php echo e($errors->has('file') ? 'rgba(239, 68, 68, 0.05)' : '#f9fafb'); ?>; transition: all 0.3s;" id="dropZone">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 32px; color: #4f46e5; margin-bottom: 12px; display: block;"></i>
                            <p style="margin: 0 0 5px 0; color: #1f2937; font-weight: 600;">Drag & Drop file di sini</p>
                            <p style="margin: 0; color: #6b7280; font-size: 13px;">atau klik untuk memilih file</p>
                        </div>
                    </div>
                    <p style="margin: 10px 0 0 0; color: #6b7280; font-size: 12px;">
                        <i class="fas fa-info-circle"></i>
                        Format: PDF, JPG, JPEG, PNG | Maksimal: 5MB
                    </p>
                    <?php if($errors->has('file')): ?>
                        <p style="margin: 8px 0 0 0; color: #ef4444; font-size: 13px;"><?php echo e($errors->first('file')); ?></p>
                    <?php endif; ?>
                </div>

                <!-- File Preview -->
                <div id="previewContainer" style="margin-bottom: 25px; display: none;">
                    <label style="display: block; margin-bottom: 10px; color: #1f2937; font-weight: 600; font-size: 14px;">Preview File</label>
                    <div style="padding: 15px; border: 1px solid #e5e7eb; border-radius: 8px; background: #f9fafb;">
                        <img id="filePreview" style="max-width: 100%; max-height: 300px; border-radius: 8px;">
                    </div>
                </div>

                <!-- Buttons -->
                <div style="display: flex; gap: 12px; justify-content: space-between;">
                    <a href="<?php echo e(route('user.dokumen')); ?>" style="padding: 12px 24px; background: #f3f4f6; color: #1f2937; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s;">
                        <i class="fas fa-arrow-left"></i>Kembali
                    </a>
                    <button type="submit" style="padding: 12px 24px; background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s;">
                        <i class="fas fa-cloud-upload-alt"></i>Upload Dokumen
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<script>
    // Update jenis dokumen info
    function updateJenisInfo() {
        const select = document.getElementById('jenis_dokumen_id');
        const option = select.options[select.selectedIndex];
        const deskripsi = option.getAttribute('data-deskripsi');
        const wajib = option.getAttribute('data-wajib');
        const infoDiv = document.getElementById('jenisInfo');
        
        if (option.value) {
            document.getElementById('jenisDeskripsi').textContent = deskripsi;
            document.getElementById('wajibBadge').style.display = wajib == 1 ? 'block' : 'none';
            infoDiv.style.display = 'block';
        } else {
            infoDiv.style.display = 'none';
        }
    }

    // Drag and drop
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('file');
    const previewContainer = document.getElementById('previewContainer');
    const filePreview = document.getElementById('filePreview');

    dropZone.addEventListener('click', () => fileInput.click());

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.style.borderColor = '#4f46e5';
        dropZone.style.background = 'rgba(79, 70, 229, 0.05)';
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.style.borderColor = '#d1d5db';
        dropZone.style.background = '#f9fafb';
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.style.borderColor = '#d1d5db';
        dropZone.style.background = '#f9fafb';
        const files = e.dataTransfer.files;
        fileInput.files = files;
        updatePreview(files[0]);
    });

    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            updatePreview(e.target.files[0]);
        }
    });

    function updatePreview(file) {
        if (file && file.type.match('image.*')) {
            const reader = new FileReader();
            reader.onload = function(event) {
                filePreview.src = event.target.result;
                previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    }
</script>

<style>
    a:hover, button:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppdb_denico_09\resources\views/user/dokumen/create.blade.php ENDPATH**/ ?>