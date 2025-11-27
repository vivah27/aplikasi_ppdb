@extends('layouts.landing')

@section('title', 'Profil Sekolah - SMK Antartika 1 Sidoarjo')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="fas fa-school me-2 text-primary"></i>Profil Sekolah
                </h1>
                <p class="lead text-muted">SMK Antartika 1 Sidoarjo</p>
            </div>

            <!-- Info Cards -->
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-building text-primary me-2"></i>Tentang Kami
                            </h5>
                            <p class="card-text">
                                SMK Antartika 1 Sidoarjo adalah sekolah menengah kejuruan yang berfokus pada pendidikan berkualitas tinggi dengan standar nasional dan internasional.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>Lokasi
                            </h5>
                            <p class="card-text">
                                Jl. Antartika, Sidoarjo, Jawa Timur, Indonesia
                            </p>
                            <small class="text-muted">Kode Pos: 61212</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Misi dan Visi -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-eye me-2"></i>Visi dan Misi
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Visi</h6>
                    <p>Menjadi sekolah menengah kejuruan yang unggul dalam menghasilkan lulusan yang kompeten, berakhlak mulia, dan siap bersaing di era digital.</p>

                    <h6 class="fw-bold mt-4 mb-3">Misi</h6>
                    <ul>
                        <li>Menyelenggarakan pendidikan berbasis kompetensi yang relevan dengan kebutuhan industri</li>
                        <li>Mengembangkan karakter peserta didik melalui pembinaan akhlak dan budi pekerti</li>
                        <li>Memberikan pengalaman praktik langsung melalui pembelajaran berbasis proyek</li>
                        <li>Mempersiapkan peserta didik untuk melanjutkan pendidikan atau memasuki dunia kerja</li>
                    </ul>
                </div>
            </div>

            <!-- Program Studi -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>Program Studi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold">Teknik Elektronika</h6>
                                    <small class="text-muted">3 Tahun</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold">Teknik Mesin</h6>
                                    <small class="text-muted">3 Tahun</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold">Teknik Otomotif</h6>
                                    <small class="text-muted">3 Tahun</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold">Administrasi Perkantoran</h6>
                                    <small class="text-muted">3 Tahun</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fasilitas -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-tools me-2"></i>Fasilitas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-laptop text-primary me-3"></i>
                                <span>Laboratorium Komputer Modern</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-cog text-primary me-3"></i>
                                <span>Bengkel Mesin Lengkap</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-book text-primary me-3"></i>
                                <span>Perpustakaan Digital</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-users text-primary me-3"></i>
                                <span>Ruang Kelas Interaktif</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-futbol text-primary me-3"></i>
                                <span>Lapangan Olahraga</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-cutlery text-primary me-3"></i>
                                <span>Kantin dan Kafeteria</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kontak -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-phone me-2"></i>Informasi Kontak
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Telepon:</strong><br>
                                (031) 8943456
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Email:</strong><br>
                                info@smkantartika1.sch.id
                            </p>
                        </div>
                        <div class="col-12">
                            <p class="mb-2">
                                <strong>Alamat:</strong><br>
                                Jl. Antartika, Sidoarjo, Jawa Timur 61212
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Button -->
            <div class="text-center mb-5">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .display-4 {
        font-weight: 700;
        color: #2c3e50;
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
    }

    .card-header {
        border-bottom: 0 !important;
    }
</style>
@endsection
