<!DOCTYPE html>
<html lang="id">

<head>
    <title><?php echo $__env->yieldContent('title'); ?> - PPDB SMK ANTARTIKA 1 SIDOARJO</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Aplikasi PPDB Online SMK Antartika 1 Sidoarjo memudahkan calon peserta didik untuk mendaftar secara digital, cepat, dan transparan.">
    <meta name="keywords" content="PPDB SMK Antartika 1, Pendaftaran Online, SMK Sidoarjo, Sekolah Kejuruan, PPDB 2025">
    <meta name="author" content="SMK Antartika 1 Sidoarjo">

    <link rel="icon" href="<?php echo e(asset('assets/images/my/logo-antrek-tp.png')); ?>" type="image/x-icon">

    <!-- CSS -->
    <link href="<?php echo e(asset('assets/css/plugins/animate.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/material.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>" id="main-style-link">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-preset.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/landing.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/welcome-new.css')); ?>">

    <style>
        .navbar {
            transition: background .2s ease-in-out;
        }
        .navbar.default {
            transition: background .2s ease-in-out;
        }

        .navbar-brand img {
            border-radius: 10px;
        }
    </style>
</head>

<body class="landing-page">
    <!-- Loader -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark top-nav-collapse default py-0">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img width="60" src="<?php echo e(asset('assets/images/my/logo-antrek-tp.png')); ?>" alt="Logo SMK Antartika 1">
                <span class="ms-2 fw-bold text-white">SMK ANTARTIKA 1 SIDOARJO</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01"
                aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item pe-1">
                        <a class="nav-link <?php echo e(request()->is('/') ? 'active' : ''); ?>" href="/">Beranda</a>
                    </li>
                    <li class="nav-item pe-1">
                        <a class="nav-link <?php echo e(request()->is('profil-sekolah') ? 'active' : ''); ?>" href="/profil-sekolah">Profil Sekolah</a>
                    </li>
                    <li class="nav-item pe-1">
                        <a class="nav-link <?php echo e(request()->is('dashboard') ? 'active' : ''); ?>" href="/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item pe-1">
                        <a class="nav-link <?php echo e(request()->is('kontak') ? 'active' : ''); ?>" href="/contact-us">Kontak</a>
                    </li>

                    <?php if(auth()->check()): ?>
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2" href="/myprofile">
                                <i class="ti ti-user-check me-1"></i> <?php echo e(auth()->user()->name); ?>

                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2" href="/login">
                                <i class="ti ti-login me-1"></i> Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten Halaman -->
    <?php echo $__env->yieldContent('content'); ?>

    <!-- Footer -->
    <footer class="footer bg-dark text-white py-4">
        <div class="top-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <img src="<?php echo e(asset('assets/images/my/logo-antrek-hitam.png')); ?>" alt="Logo SMK Antartika 1"
                            class="img-fluid mb-3" style="max-width: 150px;">
                        <p class="opacity-75">
                            SMK ANTARTIKA 1 SIDOARJO berkomitmen untuk mencetak lulusan yang berkarakter, berkompetensi,
                            dan siap menghadapi dunia kerja serta industri modern.
                        </p>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-sm-4">
                                <h5 class="text-white mb-4">Navigasi</h5>
                                <ul class="list-unstyled footer-link">
                                    <li><a href="/">Beranda</a></li>
                                    <li><a href="/profil-sekolah">Profil Sekolah</a></li>
                                    <li><a href="/dashboard">Dashboard</a></li>
                                    <li><a href="/contact-us">Kontak</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-4">
                                <h5 class="text-white mb-4">Alamat Sekolah</h5>
                                <ul class="list-unstyled footer-link">
                                    <li class="d-flex">
                                        <i class="ti ti-map-pin me-2 mt-1"></i>
                                        <span>Jl. Jalan Raya Siwalan Panji, Bedrek, Siwalanpanji, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61252</span>
                                    </li>
                                    <li class="d-flex">
                                        <i class="ti ti-mail me-2 mt-1"></i>
                                        <span>info@smkantartika1.sch.id</span>
                                    </li>
                                    <li class="d-flex">
                                        <i class="ti ti-phone me-2 mt-1"></i>
                                        <span>(031) 123-4567</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-4">
                                <h5 class="text-white mb-4">Tautan Penting</h5>
                                <ul class="list-unstyled footer-link">
                                    <li><a href="#">Kebijakan Privasi</a></li>
                                    <li><a href="#">Syarat & Ketentuan</a></li>
                                    <li><a href="#">Website Resmi Sekolah</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bottom-footer border-top border-light mt-3 pt-3">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="text-white mb-0">
                            © <?php echo e(date('Y')); ?> SMK ANTARTIKA 1 SIDOARJO. Semua hak dilindungi.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <ul class="list-inline footer-sos-link mb-0">
                            <li class="list-inline-item"><a href="#"><i class="ph-duotone ph-facebook-logo f-20"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="ph-duotone ph-instagram-logo f-20"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="ph-duotone ph-youtube-logo f-20"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JS -->
    <script src="<?php echo e(asset('assets/js/plugins/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/simplebar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/fonts/custom-font.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/pcoded.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/wow.min.js')); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <script>
        layout_change('light');
        change_box_container('false');
        layout_rtl_change('false');
        preset_change("preset-1");
        font_change("Public-Sans");

        let ost = 0;
        document.addEventListener('scroll', function() {
            let cOst = document.documentElement.scrollTop;
            if (cOst == 0) {
                document.querySelector(".navbar").classList.add("top-nav-collapse");
            } else if (cOst > ost) {
                document.querySelector(".navbar").classList.add("top-nav-collapse");
                document.querySelector(".navbar").classList.remove("default");
            } else {
                document.querySelector(".navbar").classList.add("default");
                document.querySelector(".navbar").classList.remove("top-nav-collapse");
            }
            ost = cOst;
        });

        new WOW().init();
    </script>
</body>
</html>
<?php /**PATH C:\aplikasi_ppdb_2\resources\views/layouts/landing.blade.php ENDPATH**/ ?>