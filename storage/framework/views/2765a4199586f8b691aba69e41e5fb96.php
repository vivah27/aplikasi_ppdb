

<?php $__env->startSection('page_title', 'Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="pagetitle">
  <h1>Form Pembayaran</h1>
</div>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Isi Data Pembayaran</h5>

      <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
      <?php endif; ?>
      <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
      <?php endif; ?>

      <form action="<?php echo e(route('user.pembayaran.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
          <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
          <input type="text" name="jenis_pembayaran" class="form-control" placeholder="Contoh: Uang Pendaftaran" required>
        </div>

        <div class="mb-3">
          <label for="jumlah" class="form-label">Jumlah Pembayaran</label>
          <input type="number" name="jumlah" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="metode_id" class="form-label">Metode Pembayaran</label>
          <select name="metode_id" class="form-control" required>
            <option value="">-- Pilih Metode --</option>
            <?php $__currentLoopData = $metode; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($m->id); ?>"><?php echo e($m->label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="bukti" class="form-label">Upload Bukti Pembayaran</label>
          <input type="file" name="bukti" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Kirim Pembayaran</button>
      </form>

      <?php if($pembayaran): ?>
        <hr>
        <h5 class="mt-4">Status Pembayaran Terakhir</h5>
        <ul>
          <li>Jenis: <?php echo e($pembayaran->jenis_pembayaran); ?></li>
          <li>Jumlah: Rp <?php echo e(number_format($pembayaran->jumlah, 0, ',', '.')); ?></li>
          <li>Metode: <?php echo e($pembayaran->metode->label ?? '-'); ?></li>
          <li>Status: <strong><?php echo e($pembayaran->status->label ?? 'Menunggu'); ?></strong></li>
          <li>Tanggal: <?php echo e(\Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y H:i')); ?></li>
        </ul>
        <?php if($pembayaran->bukti_path): ?>
          <a href="<?php echo e(asset('storage/' . $pembayaran->bukti_path)); ?>" target="_blank" class="btn btn-outline-info btn-sm">
            Lihat Bukti
          </a>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\aplikasi_ppdb\resources\views/user/pembayaran.blade.php ENDPATH**/ ?>