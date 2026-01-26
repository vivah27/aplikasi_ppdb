<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container-fluid h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-6 px-4 px-lg-5 py-5">
                    <h1 class="hero-title mb-4">Selamat Datang di <span class="text-primary">PPDB SMK Antartika 1</span></h1>
                    <p class="hero-subtitle mb-4">Platform pendaftaran online yang modern, aman, dan transparan untuk calon siswa baru SMK Antartika 1 Sidoarjo.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="<?php echo e(url('/login')); ?>" class="btn btn-primary btn-lg fw-bold px-5">
                            <i class="fas fa-sign-in-alt me-2"></i>Login / Daftar
                        </a>
                        <a href="<?php echo e(route('pengumuman.index')); ?>" class="btn btn-success btn-lg fw-bold px-5">
                            <i class="fas fa-bullhorn me-2"></i>Cek Hasil Seleksi
                        </a>
                        <a href="#fitur" class="btn btn-outline-primary btn-lg fw-bold px-5">
                            <i class="fas fa-arrow-down me-2"></i>Pelajari Lebih Lanjut
                        </a>
                    </div>
                    <div class="mt-5 pt-3">
                        <div class="row g-4">
                            <div class="col-6">
                                <div class="stat-box">
                                    <h3 class="stat-number">2.500+</h3>
                                    <p class="stat-text">Alumni Sukses</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-box">
                                    <h3 class="stat-number">12+</h3>
                                    <p class="stat-text">Jurusan Unggulan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center px-4">
                    <div class="hero-image-box">
                        <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" class="hero-svg">
                            <!-- Background Circle -->
                            <circle cx="200" cy="200" r="180" fill="#f0f4ff" opacity="0.5"/>
                            <circle cx="200" cy="200" r="150" fill="none" stroke="#667eea" stroke-width="2" opacity="0.3"/>
                            
                            <!-- Laptop/Computer -->
                            <rect x="80" y="140" width="240" height="160" rx="15" fill="#667eea" opacity="0.1" stroke="#667eea" stroke-width="2"/>
                            <rect x="90" y="150" width="220" height="120" fill="white" stroke="#667eea" stroke-width="2" rx="10"/>
                            
                            <!-- Screen Content -->
                            <rect x="100" y="160" width="200" height="35" fill="#667eea" opacity="0.7" rx="5"/>
                            <rect x="100" y="205" width="60" height="15" fill="#667eea" opacity="0.5" rx="3"/>
                            <rect x="170" y="205" width="60" height="15" fill="#667eea" opacity="0.5" rx="3"/>
                            
                            <!-- Stand -->
                            <rect x="175" y="280" width="50" height="50" fill="#667eea" opacity="0.2" stroke="#667eea" stroke-width="1.5" rx="5"/>
                            
                            <!-- Checkmark -->
                            <circle cx="320" cy="120" r="25" fill="#10b981" opacity="0.9"/>
                            <path d="M 315 120 L 320 128 L 330 115" stroke="white" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                            
                            <!-- Decorative elements -->
                            <circle cx="60" cy="80" r="15" fill="#f59e0b" opacity="0.6"/>
                            <circle cx="340" cy="300" r="20" fill="#10b981" opacity="0.5"/>
                            <rect x="30" y="250" width="30" height="30" fill="#667eea" opacity="0.4" rx="5"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="features-section py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title mb-3">Keunggulan Sistem Kami</h2>
                <p class="section-subtitle">Teknologi terdepan untuk pengalaman pendaftaran terbaik</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon bg-primary-light">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <h5 class="feature-title">Mudah & Cepat</h5>
                        <p class="feature-text">Daftar dari rumah hanya dalam beberapa menit tanpa ribet dan antri</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon bg-success-light">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5 class="feature-title">Aman & Terpercaya</h5>
                        <p class="feature-text">Data Anda dilindungi dengan enkripsi tingkat enterprise</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon bg-warning-light">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h5 class="feature-title">Transparan</h5>
                        <p class="feature-text">Pantau status pendaftaran secara real-time kapan saja</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Steps Section -->
    <section class="steps-section py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title mb-3">Proses Pendaftaran</h2>
                <p class="section-subtitle">Hanya 4 langkah mudah untuk mendaftar</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h5 class="step-title">Daftar Akun</h5>
                        <p class="step-text">Buat akun baru dengan email dan password yang aman</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <h5 class="step-title">Isi Data Diri</h5>
                        <p class="step-text">Lengkapi informasi pribadi dan pilih jurusan yang diminati</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <h5 class="step-title">Upload Dokumen</h5>
                        <p class="step-text">Upload ijazah, KTP, dan dokumen pendukung lainnya</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-number">4</div>
                        <h5 class="step-title">Tunggu Hasil</h5>
                        <p class="step-text">Pantau status dan lihat pengumuman hasil seleksi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stat-card-large">
                        <div class="stat-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h4>2.500+</h4>
                        <p>Alumni Tersebar di Berbagai Industri</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-large">
                        <div class="stat-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h4>30+</h4>
                        <p>Mitra Industri & Perusahaan</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-large">
                        <div class="stat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>99%</h4>
                        <p>Placement Rate Lulusan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="testimonial-section py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title mb-3">Apa Kata Mereka</h2>
                <p class="section-subtitle">Testimoni dari alumni dan siswa kami</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="stars mb-3">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"Pendaftaran sangat mudah dan cepat! Sistemnya user-friendly dan data saya langsung terverifikasi."</p>
                        <div class="testimonial-author">
                            <strong>Rizky Ahmad</strong>
                            <small>Alumni RPL 2024</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="stars mb-3">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"Sebagai orang tua, saya senang bisa memantau status anak saya secara real-time melalui platform ini."</p>
                        <div class="testimonial-author">
                            <strong>Siti Nurhaliza</strong>
                            <small>Orang Tua Siswa TKJ</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="stars mb-3">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"Fasilitas sekolah lengkap dan pembelajaran praktik langsung mempersiapkan kami untuk industri."</p>
                        <div class="testimonial-author">
                            <strong>Anisa Putri</strong>
                            <small>Siswa TBSM 2025</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="cta-title mb-3">Siap Memulai Pendaftaran?</h2>
                    <p class="cta-text">Jangan tunda lagi, daftarkan diri Anda sekarang dan raih masa depan cemerlang bersama SMK Antartika 1.</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <a href="<?php echo e(url('/login')); ?>" class="btn btn-primary btn-lg fw-bold px-5">
                        Daftar Sekarang <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.landing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC_\aplikasi_ppdb\resources\views/welcome.blade.php ENDPATH**/ ?>