<?php $__env->startSection('title', 'Login - PPDB SMK Antartika 1 Sidoarjo'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-wrapper" style="min-height: 100dvh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #a8dadc 0%, #dda0dd 100%); position: relative; overflow: hidden;">
    <!-- Animated Background Elements -->
    <div style="position: absolute; width: 400px; height: 400px; background: rgba(255,255,255,0.05); border-radius: 50%; top: -100px; left: -100px;"></div>
    <div style="position: absolute; width: 300px; height: 300px; background: rgba(255,255,255,0.05); border-radius: 50%; bottom: -80px; right: -80px;"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5 col-xl-4">
                <div class="card border-0 overflow-hidden shadow-xl" style="border-radius: 24px; backdrop-filter: blur(10px);">
                    <!-- Card Header dengan gradient modern -->
                    <div style="background: linear-gradient(135deg, #a8dadc 0%, #dda0dd 100%); padding: 2.5rem 2rem; text-align: center; position: relative;">
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.05);"></div>
                        <div style="position: relative; z-index: 1;">
                            <!-- Logo Sekolah -->
                            <div style="margin-bottom: 1.5rem;">
                                <img src="<?php echo e(asset('assets/images/my/logo-antrek-tp.png')); ?>" alt="Logo SMK Antartika 1" style="width: 70px; height: 70px; object-fit: contain; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));">
                            </div>
                            <h2 class="text-white mb-2" style="font-weight: 700; font-size: 1.75rem;">Masuk</h2>
                            <p class="text-white" style="opacity: 0.85; margin: 0; font-size: 0.95rem;">Portal Pendaftaran PPDB 2025/2026</p>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-5">
                        <!-- Alert Messages -->
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: 1px solid #fee; background: rgba(239, 68, 68, 0.05);">
                                <i class="fas fa-exclamation-circle me-2" style="color: #ef4444;"></i>
                                <strong>Kesalahan Login:</strong>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div style="margin-top: 8px;"><?php echo e($error); ?></div>
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
                                        <a href="/verify-email" class="btn btn-sm text-white fw-bold w-100" style="background: linear-gradient(135deg, #a8dadc 0%, #dda0dd 100%); border-radius: 8px;">
                                            <i class="fas fa-envelope-open me-2"></i>Verifikasi Email Sekarang
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if(session('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: 1px solid #d1fae5; background: rgba(16, 185, 129, 0.05);">
                                <i class="fas fa-check-circle me-2" style="color: #10b981;"></i><?php echo e(session('success')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Login Form -->
                        <form method="POST" action="<?php echo e(route('login.post')); ?>">
                            <?php echo csrf_field(); ?>

                            <!-- Email Field -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-600 mb-2">
                                    <i class="fas fa-envelope me-2" style="color: #a8dadc;"></i>Email
                                </label>
                                <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="email" name="email" placeholder="Masukkan email Anda" 
                                       value="<?php echo e(session('registered_email')); ?>" autocomplete="email" required
                                       style="padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 0.95rem; transition: all 0.3s;">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger d-block mt-2"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Password Field -->
                            <div class="mb-4">
                                <label for="password" class="form-label fw-600 mb-2">
                                    <i class="fas fa-lock me-2" style="color: #a8dadc;"></i>Password
                                </label>
                                <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="password" name="password" placeholder="Masukkan password Anda" 
                                       <?php echo e(session('registered_email') ? 'autofocus' : ''); ?> required
                                       style="padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 0.95rem; transition: all 0.3s;">
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger d-block mt-2"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember" value="1" style="width: 18px; height: 18px;">
                                    <label class="form-check-label" for="remember" style="color: #6b7280; font-size: 0.95rem;">
                                        Ingat saya
                                    </label>
                                </div>
                                <a href="<?php echo e(route('forgot_password.email_form')); ?>" class="text-decoration-none fw-600" style="color: #a8dadc; font-size: 0.95rem;">
                                    Lupa password?
                                </a>
                            </div>

                            <!-- reCAPTCHA -->
                            <?php if(config('nocaptcha.sitekey')): ?>
                            <div class="mb-4">
                                <?php echo NoCaptcha::renderJs(); ?>

                                <?php echo NoCaptcha::display(); ?>

                                <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger d-block mt-2"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <?php endif; ?>

                            <!-- Submit Button -->
                            <button type="submit" class="btn w-100 fw-600 mb-4" style="padding: 12px; border-radius: 10px; background: linear-gradient(135deg, #a8dadc 0%, #dda0dd 100%); color: white; border: none; font-size: 1rem; transition: all 0.3s; cursor: pointer;">
                                <i class="fas fa-arrow-right me-2"></i>Masuk
                            </button>
                        </form>

                        <!-- Register Link -->
                        <div class="text-center pt-4" style="border-top: 1px solid #e5e7eb;">
                            <p class="mb-0" style="color: #6b7280;">
                                Belum punya akun?
                                <a href="/register" class="text-decoration-none fw-600" style="color: #a8dadc;">
                                    Daftar Sekarang
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="text-center mt-5">
                    <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-bottom: 8px;">
                        <i class="fas fa-shield-alt me-2"></i>Data Anda aman terlindungi
                    </p>
                    <p style="color: rgba(255,255,255,0.7); font-size: 0.9rem;">
                        © 2025 PPDB SMK Antartika 1 Sidoarjo
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control {
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #a8dadc !important;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }
    
    .form-check-input {
        cursor: pointer;
    }
    
    .form-check-input:checked {
        background-color: #a8dadc;
        border-color: #a8dadc;
    }
    
    button[type="submit"]:hover {
        background: linear-gradient(135deg, #dda0dd 0%, #a8dadc 100%) !important;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }
    
    .shadow-xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC_\aplikasi_ppdb\resources\views/auth/login.blade.php ENDPATH**/ ?>