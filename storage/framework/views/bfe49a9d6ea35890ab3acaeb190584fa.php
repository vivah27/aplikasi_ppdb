<?php $__env->startSection('title', 'Register - PPDB SMK Antartika 1 Sidoarjo'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-wrapper" style="min-height: 100dvh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #a8dadc 0%, #dda0dd 100%); position: relative; overflow: hidden;">
    <!-- Animated Background Elements -->
    <div style="position: absolute; width: 400px; height: 400px; background: rgba(255,255,255,0.05); border-radius: 50%; top: -100px; right: -100px;"></div>
    <div style="position: absolute; width: 300px; height: 300px; background: rgba(255,255,255,0.05); border-radius: 50%; bottom: -80px; left: -80px;"></div>

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
                            <h2 class="text-white mb-2" style="font-weight: 700; font-size: 1.75rem;">Daftar Akun</h2>
                            <p class="text-white" style="opacity: 0.85; margin: 0; font-size: 0.95rem;">Portal Pendaftaran PPDB 2025/2026</p>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-5">
                        <!-- Alert Messages -->
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: 1px solid #fee; background: rgba(239, 68, 68, 0.05);">
                                <i class="fas fa-exclamation-circle me-2" style="color: #ef4444;"></i>
                                <strong>Kesalahan Pendaftaran:</strong>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div style="margin-top: 8px;"><?php echo e($error); ?></div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Register Form -->
                        <form action="<?php echo e(route('register')); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            <!-- Nama Lengkap -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-600 mb-2">
                                    <i class="fas fa-user me-2" style="color: #a8dadc;"></i>Nama Lengkap
                                </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="name" name="name" placeholder="Masukkan nama lengkap" 
                                       value="<?php echo e(old('name')); ?>" required autocomplete="name"
                                       style="padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 0.95rem; transition: all 0.3s;">
                                <?php $__errorArgs = ['name'];
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

                            <!-- Email Address -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-600 mb-2">
                                    <i class="fas fa-envelope me-2" style="color: #a8dadc;"></i>Email Address
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
                                       value="<?php echo e(old('email')); ?>" required autocomplete="email"
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

                            <!-- Password -->
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
                                       id="password" name="password" placeholder="Buat password yang kuat" 
                                       required autocomplete="new-password"
                                       style="padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 0.95rem; transition: all 0.3s;">
                                <small style="color: #9ca3af; display: block; margin-top: 8px;">
                                    <i class="fas fa-info-circle me-1"></i>Minimal 8 karakter, gunakan kombinasi huruf dan angka
                                </small>
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

                            <!-- Password Confirmation -->
                            <div class="mb-5">
                                <label for="password_confirmation" class="form-label fw-600 mb-2">
                                    <i class="fas fa-check-circle me-2" style="color: #a8dadc;"></i>Konfirmasi Password
                                </label>
                                <input type="password" class="form-control <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="password_confirmation" name="password_confirmation" placeholder="Ketik ulang password" 
                                       required autocomplete="new-password"
                                       style="padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 0.95rem; transition: all 0.3s;">
                                <?php $__errorArgs = ['password_confirmation'];
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

                            <!-- Terms & Conditions -->
                            <div class="form-check mb-5">
                                <input class="form-check-input" type="checkbox" id="agree" required style="width: 18px; height: 18px;">
                                <label class="form-check-label" for="agree" style="color: #6b7280; font-size: 0.9rem;">
                                    Saya setuju dengan <a href="#" class="text-decoration-none fw-600" style="color: #a8dadc;">Terms of Service</a> dan <a href="#" class="text-decoration-none fw-600" style="color: #a8dadc;">Privacy Policy</a>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn w-100 fw-600 mb-4" style="padding: 12px; border-radius: 10px; background: linear-gradient(135deg, #a8dadc 0%, #dda0dd 100%); color: white; border: none; font-size: 1rem; transition: all 0.3s; cursor: pointer;">
                                <i class="fas fa-user-plus me-2"></i>Buat Akun
                            </button>
                        </form>

                        <!-- Login Link -->
                        <div class="text-center pt-4" style="border-top: 1px solid #e5e7eb;">
                            <p class="mb-0" style="color: #6b7280;">
                                Sudah punya akun?
                                <a href="/login" class="text-decoration-none fw-600" style="color: #a8dadc;">
                                    Masuk di Sini
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

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC_\aplikasi_ppdb\resources\views/auth/register.blade.php ENDPATH**/ ?>