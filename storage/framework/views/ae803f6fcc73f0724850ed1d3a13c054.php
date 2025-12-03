<?php $__env->startSection('title', 'Verify Email'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card my-5">
        <?php if(session('verify_email')): ?>
            <div class="card-body">
                <div class="mb-4">
                    <h3 class="mb-2"><b>📧 Verifikasi Email Anda</b></h3>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ✅ <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            ℹ️ Kami telah mengirimkan kode verifikasi (OTP) ke <strong><?php echo e(session('verify_email')); ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                            <i class="fas fa-times-circle me-2"></i>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div><?php echo e($error); ?></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <p class="text-muted mt-3" style="font-size: 14px;">
                        <strong>Instruksi:</strong> Masukkan 6 digit kode OTP yang telah kami kirimkan ke email Anda. Kode ini berlaku selama 5 menit.
                    </p>
                </div>

                
                <form action="<?php echo e(route('verify.otp')); ?>" method="POST" id="verifyForm">
                    <?php echo csrf_field(); ?>
                    <div class="mb-4">
                        <label class="form-label"><strong>Masukkan Kode OTP (6 digit)</strong></label>
                        <div class="row text-center">
                            <?php for($i = 0; $i < 6; $i++): ?>
                                <div class="col">
                                    <input type="text" maxlength="1" class="form-control form-control-lg text-center otp-input"
                                        style="font-size:24px; font-weight: bold; letter-spacing: 5px;" name="otp[]" required>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-check"></i> Verifikasi Email
                        </button>
                    </div>
                </form>

                
                <div class="alert alert-light mt-4 border" role="alert">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <p class="mb-0" style="font-size:13px;">
                            <strong>Tidak menerima kode OTP?</strong> Cek folder SPAM atau minta kode baru
                        </p>
                        <form action="<?php echo e(route('send.otp')); ?>" method="POST" id="resendForm" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <button style="font-size:13px;" type="submit" id="resendBtn" class="btn btn-sm btn-outline-primary"
                                disabled>
                                🔄 Kirim Ulang (<span id="timer"></span>s)
                            </button>
                        </form>
                    </div>
                </div>

                
                <div class="alert alert-light" style="border-left: 4px solid #4f46e5;">
                    <strong style="color: #4f46e5;">💡 Informasi Penting:</strong>
                    <ul style="margin: 10px 0 0 0; padding-left: 20px; font-size: 13px;">
                        <li>Kode OTP hanya berlaku <strong>5 menit</strong></li>
                        <li>Tunggu <strong>60 detik</strong> sebelum meminta kode baru</li>
                        <li>Jangan bagikan kode OTP kepada siapa pun</li>
                        <li>Kode hanya bisa digunakan <strong>1 kali</strong></li>
                    </ul>
                </div>
            </div>
        <?php else: ?>
            <div class="card-body text-center py-5">
                <div style="font-size: 48px; margin-bottom: 15px;">📧</div>
                <h4 class="mb-2"><b>Belum ada verifikasi pending</b></h4>
                <p class="text-muted mb-4">Halaman ini adalah untuk memverifikasi email Anda. Silahkan lakukan pendaftaran terlebih dahulu.</p>
                
                <div class="d-grid gap-2">
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-plus"></i> Daftar Akun Baru
                    </a>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-sign-in-alt"></i> Kembali ke Login
                    </a>
                </div>

                
                <div class="alert alert-info mt-4" role="alert">
                    <strong>Sudah punya akun tapi belum verifikasi?</strong><br>
                    <small>Hubungi admin atau <a href="<?php echo e(route('send.otp.get')); ?>" class="btn btn-link btn-sm p-0">klik di sini untuk kirim ulang OTP</a></small>
                </div>
            </div>
        <?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts_content'); ?>
    
    <?php if(session('verify_email')): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // -------------------
                // 1. Handle Input OTP
                // -------------------
                const inputs = document.querySelectorAll(".otp-input");
                inputs.forEach((input, index) => {
                    input.addEventListener("input", (e) => {
                        e.target.value = e.target.value.replace(/[^0-9]/g, "");

                        if (e.target.value.length === 1 && index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        }
                    });

                    input.addEventListener("keydown", (e) => {
                        if (e.key === "Backspace" && !e.target.value && index > 0) {
                            inputs[index - 1].focus();
                        }
                    });

                    input.addEventListener("paste", (e) => {
                        e.preventDefault();
                        const pasteData = (e.clipboardData || window.clipboardData).getData("text");
                        const digits = pasteData.replace(/[^0-9]/g, "").split("");

                        digits.forEach((digit, i) => {
                            if (i < inputs.length) {
                                inputs[i].value = digit;
                            }
                        });

                        const filledIndex = Math.min(digits.length, inputs.length) - 1;
                        if (filledIndex >= 0) inputs[filledIndex].focus();
                    });
                });

                // Gabungkan OTP sebelum submit
                document.getElementById("verifyForm").addEventListener("submit", function(e) {
                    e.preventDefault();
                    
                    // Gabung semua input OTP tanpa spasi
                    let otpValue = "";
                    inputs.forEach(input => {
                        otpValue += (input.value || "").trim();
                    });
                    
                    // Validasi ada 6 digit
                    if (otpValue.length !== 6) {
                        alert("Silahkan masukkan 6 digit kode OTP");
                        return false;
                    }
                    
                    // Tambah hidden input untuk OTP
                    let hiddenInput = document.createElement("input");
                    hiddenInput.type = "hidden";
                    hiddenInput.name = "otp";
                    hiddenInput.value = otpValue;
                    this.appendChild(hiddenInput);
                    
                    // Submit form
                    this.submit();
                });

                // -------------------
                // 2. Countdown Timer
                // -------------------
                let resendBtn = document.getElementById("resendBtn");
                let timerSpan = document.getElementById("timer");

                let endTime = localStorage.getItem("otp_end_time");
                let setResendOtp = <?php echo e($timeResendOtp); ?>;
                let timer = <?php echo e($cooldown); ?> < setResendOtp ? setResendOtp : 0;

                if (!endTime) {
                    endTime = Date.now() + (timer * 1000);
                    localStorage.setItem("otp_end_time", endTime);
                } else {
                    endTime = parseInt(endTime);
                }

                let countdown = setInterval(() => {
                    let remaining = Math.floor((endTime - Date.now()) / 1000);

                    if (remaining <= 0) {
                        clearInterval(countdown);
                        resendBtn.disabled = false;
                        resendBtn.innerHTML = '🔄 Kirim Ulang';
                        localStorage.removeItem("otp_end_time");
                    } else {
                        timerSpan.textContent = remaining;
                        resendBtn.disabled = true;
                        resendBtn.innerHTML = `🔄 Kirim Ulang (<span id="timer">${remaining}</span>s)`;
                    }
                }, 1000);

                // -------------------
                // 3. Reset Timer saat Resend
                // -------------------
                document.getElementById("resendForm").addEventListener("submit", function() {
                    let newEndTime = Date.now() + (setResendOtp * 1000);
                    localStorage.setItem("otp_end_time", newEndTime);
                });
            });
        </script>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppdb_denico_09\resources\views/auth/verify-email.blade.php ENDPATH**/ ?>