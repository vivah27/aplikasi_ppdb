<?php $__env->startSection('title', 'Login - PPDB SMK Antartika 1 Sidoarjo'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100dvh; display: flex; align-items: center;">
    <div class="row w-100 justify-content-center">
        <div class="col-md-8 col-lg-5 col-xl-4">
            <div class="card shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
                <!-- Card Header dengan gradient -->
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 2rem; text-align: center;">
                    <h2 class="text-white mb-2" style="font-weight: 700;">
                        <i class="fas fa-sign-in-alt me-2"></i>Masuk
                    </h2>
                    <p class="text-white-50 mb-0">Portal Pendaftaran PPDB 2025/2026</p>
                </div>

                <!-- Card Body -->
                <div class="card-body p-4">
                    <!-- Alert Messages -->
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Kesalahan Login:</strong>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div><?php echo e($error); ?></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            <?php if($errors->has('verify_email')): ?>
                                <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid rgba(0,0,0,0.1);">
                                    <p class="mb-3"><strong>📧 Bagaimana cara verifikasi?</strong></p>
                                    <ol style="font-size: 13px; margin-bottom: 15px; padding-left: 20px;">
                                        <li>Buka email yang Anda terima dari sistem</li>
                                        <li>Copy kode OTP (6 digit) dari email</li>
                                        <li>Klik tombol di bawah untuk verifikasi</li>
                                        <li>Masukkan kode OTP dan selesaikan verifikasi</li>
                                    </ol>
                                    <a href="/verify-email" class="btn btn-sm btn-light text-danger fw-bold w-100">
                                        <i class="fas fa-envelope-open me-2"></i>Verifikasi Email Sekarang
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Login Form -->
                    <form method="POST" action="<?php echo e(route('login.post')); ?>">
                        <?php echo csrf_field(); ?>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-600">
                                <i class="fas fa-envelope me-2 text-primary"></i>Email
                            </label>
                            <input type="email" class="form-control form-control-lg <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="email" name="email" placeholder="Masukkan email Anda" 
                                   value="<?php echo e(session('registered_email')); ?>" autocomplete="email" required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-600">
                                <i class="fas fa-lock me-2 text-primary"></i>Password
                            </label>
                            <input type="password" class="form-control form-control-lg <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="password" name="password" placeholder="Masukkan password Anda" 
                                   <?php echo e(session('registered_email') ? 'autofocus' : ''); ?> required>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember" value="1">
                                <label class="form-check-label text-muted" for="remember">
                                    Ingat saya
                                </label>
                            </div>
                            <a href="<?php echo e(route('forgot_password.email_form')); ?>" class="text-decoration-none" style="font-size: 0.875rem;">
                                Lupa password?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-600 mb-3">
                            <i class="fas fa-arrow-right me-2"></i>Masuk
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="position-relative my-4">
                        <hr>
                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-2 text-muted small">
                            atau masuk dengan
                        </span>
                    </div>

                    <!-- SSO Login -->
                    <?php echo $__env->make('auth.sso', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                    <!-- Register Link -->
                    <div class="text-center pt-3 border-top">
                        <p class="mb-0 text-muted">
                            Belum punya akun?
                            <a href="/register" class="text-decoration-none fw-600 text-primary">
                                Daftar Sekarang
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="text-center mt-4">
                <p class="text-muted small mb-2">
                    <i class="fas fa-shield-alt me-1"></i>Data Anda aman terlindungi
                </p>
                <p class="text-muted small">
                    © 2025 PPDB SMK Antartika 1 Sidoarjo
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #5568d3 0%, #6a3a95 100%);
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(102, 126, 234, 0.4);
    }
    
    .text-white-50 {
        color: rgba(255, 255, 255, 0.7);
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\aplikasi_ppdb\resources\views/auth/login.blade.php ENDPATH**/ ?>