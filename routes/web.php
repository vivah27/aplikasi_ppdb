<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminSiswaController;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\VerifikasiDokumenController;
use App\Http\Controllers\JenisDokumenController;
use App\Http\Controllers\PeranController;
use App\Http\Controllers\UserPeranController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CetakDokumenController;

/*
|--------------------------------------------------------------------------
| Web Routes - PPDB SMK ANTARTIKA 1 SIDOARJO
|--------------------------------------------------------------------------
*/

// ============================
// HALAMAN UMUM (TANPA LOGIN)
// ============================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/contact-us', function () {
    return view('contact');
});

Route::get('/profil-sekolah', function () {
    return view('profil-sekolah');
});

// ============================
// ROUTE UNTUK USER BELUM LOGIN
// ============================
Route::middleware(['guest'])->group(function () {

    // Verifikasi Email / OTP
    Route::get('/verify-email', [AuthController::class, 'showVerifyForm'])->name('verify.form');
    Route::post('/verify-email', [AuthController::class, 'verify'])->name('verify.otp')->middleware('throttle:10,1');
    Route::get('/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp.get'); // GET untuk testing/manual
    Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp')->middleware('throttle:5,1');

    // Login & Register
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('throttle:5,1');

    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Social Login SSO
    Route::get('/auth/{provider}', [AuthController::class, 'redirect'])->name('sso.redirect');
    Route::get('/auth/{provider}/callback', [AuthController::class, 'callback'])->name('sso.callback');

    // Lupa Password
    Route::get('/forgot-password', [AuthController::class, 'showRequestForm'])->name('forgot_password.email_form');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot_password.send_link')->middleware('throttle:5,1');

    // Verifikasi OTP untuk Reset Password
    Route::get('/password-verify-otp/{token}', [AuthController::class, 'showVerifyResetForm'])->name('password.verify-form');
    Route::post('/password-verify-otp', [AuthController::class, 'verifyResetOtp'])->name('password.verify-otp')->middleware('throttle:5,1');

    // Reset Password (setelah OTP verified)
    Route::get('/password-reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password-reset', [AuthController::class, 'resetPassword'])->name('password.update')->middleware('throttle:5,1');
});

// ============================
// ROUTE UNTUK USER SUDAH LOGIN
// ============================
Route::middleware(['auth', 'web'])->group(function () {

    // Dashboard utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Change password (logged-in user)
    Route::get('/password/change', [ProfileController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/password/change', [ProfileController::class, 'changePassword'])->name('password.change.post');

    // Profil
    Route::get('/myprofile', [ProfileController::class, 'index'])->name('profil.index');
    Route::get('/myprofile/edit', [ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/myprofile/update', [ProfileController::class, 'update'])->name('profil.update');

    /*
    |--------------------------------------------------------------------------
    | ROUTE USER (ROLE: user)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['cekRole:user'])->group(function () {

        // === BIODATA ===
        Route::get('/biodata', [BiodataController::class, 'index'])->name('biodata.index');
        Route::post('/biodata', [BiodataController::class, 'store'])->name('biodata.store');

        // === FORMULIR ===
        Route::get('/formulir', [FormulirController::class, 'index'])->name('formulir.index');
        Route::post('/user/formulir', [FormulirController::class, 'store'])->name('user.formulir.store');

        // === STATUS PENDAFTARAN ===
        Route::get('/status', fn() => view('user.status'))->name('status.index');
        Route::get('/user/status', fn() => view('user.status'))->name('user.status');

        // === DOKUMEN / CETAK KARTU ===
        Route::get('/dokumen', [DokumenController::class, 'index'])->name('user.dokumen');
        Route::get('/dokumen/create', [DokumenController::class, 'create'])->name('user.dokumen.create');
        Route::post('/dokumen', [DokumenController::class, 'store'])->name('user.dokumen.store');
        Route::get('/dokumen/{dokumen}', [DokumenController::class, 'show'])->name('user.dokumen.show');
        Route::get('/dokumen/{dokumen}/download', [DokumenController::class, 'download'])->name('user.dokumen.download')->middleware('throttle:30,1');
        Route::delete('/dokumen/{dokumen}', [DokumenController::class, 'destroy'])->name('user.dokumen.destroy');

        // === CETAK DOKUMEN ===
        Route::prefix('cetak')->as('cetak.')->group(function () {
            Route::get('/', [CetakDokumenController::class, 'index'])->name('index');
            Route::get('/formulir/{pendaftaranId}', [CetakDokumenController::class, 'generateFormulir'])->name('formulir');
            Route::get('/kartu/{pendaftaranId}', [CetakDokumenController::class, 'generateKartuPeserta'])->name('kartu');
            Route::get('/surat/{pendaftaranId}', [CetakDokumenController::class, 'generateSuratPenerimaan'])->name('surat');
            Route::get('/kuitansi/{pembayaranId}', [CetakDokumenController::class, 'generateKuitansi'])->name('kuitansi');
            Route::get('/download/{id}', [CetakDokumenController::class, 'download'])->name('download');
        });

        // === DAFTAR ULANG ===
        Route::get('/daftar-ulang', fn() => view('user.daftar_ulang'))->name('user.daftar_ulang');
        
        Route::prefix('pembayaran')->as('user.pembayaran.')->group(function () {

            Route::get('/', [PembayaranController::class, 'index'])->name('index');
            Route::get('/create', [PembayaranController::class, 'create'])->name('create');
            Route::post('/', [PembayaranController::class, 'store'])->name('store');
            Route::get('/{id}', [PembayaranController::class, 'show'])->name('show');
            Route::put('/{id}', [PembayaranController::class, 'update'])->name('update');
            Route::delete('/{id}', [PembayaranController::class, 'destroy'])->name('destroy');

        });
        /*
        |--------------------------------------------------------------------------
        | ROUTE PEMBAYARAN - FIX 100%
        |--------------------------------------------------------------------------
        */
        

    });

    /*
    |--------------------------------------------------------------------------
    | ROUTE ADMIN (ROLE: admin)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['cekRole:admin'])->group(function () {
        // === ADMIN DASHBOARD ===
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        // Signed URL generation for dokumen (admin)
        Route::post('/admin/dokumen/{dokumen}/signed-url', [DokumenController::class, 'signedUrl'])->name('admin.dokumen.signed_url');
        
        // === ADMIN SISWA ===
        Route::get('/admin/siswa', [AdminSiswaController::class, 'index'])->name('admin.siswa.index');
        
        Route::get('/admin/verifikasi', [VerifikasiDokumenController::class, 'index'])->name('admin.verifikasi');
        Route::get('/admin/verifikasi/{dokumen}/preview', [VerifikasiDokumenController::class, 'preview'])->name('admin.verifikasi.preview');
        Route::get('/admin/verifikasi/{dokumen}/edit', [VerifikasiDokumenController::class, 'edit'])->name('admin.verifikasi.edit');
        Route::put('/admin/verifikasi/{dokumen}', [VerifikasiDokumenController::class, 'update'])->name('admin.verifikasi.update');
        Route::post('/admin/verifikasi/{dokumen}/accept', [VerifikasiDokumenController::class, 'acceptDokumen'])->name('admin.verifikasi.accept');
        Route::post('/admin/verifikasi/{dokumen}/reject', [VerifikasiDokumenController::class, 'rejectDokumen'])->name('admin.verifikasi.reject');
        
        // === VERIFIKASI PENDAFTARAN (ACCEPT/REJECT) ===
        Route::post('/admin/pendaftaran/{pendaftaran}/accept', [VerifikasiDokumenController::class, 'acceptRegistration'])->name('admin.pendaftaran.accept');
        Route::post('/admin/pendaftaran/{pendaftaran}/reject', [VerifikasiDokumenController::class, 'rejectRegistration'])->name('admin.pendaftaran.reject');

        // === MANAJEMEN JENIS DOKUMEN ===
        Route::resource('admin/jenis-dokumen', JenisDokumenController::class, [
            'names' => [
                'index' => 'admin.jenis-dokumen.index',
                'create' => 'admin.jenis-dokumen.create',
                'store' => 'admin.jenis-dokumen.store',
                'show' => 'admin.jenis-dokumen.show',
                'edit' => 'admin.jenis-dokumen.edit',
                'update' => 'admin.jenis-dokumen.update',
                'destroy' => 'admin.jenis-dokumen.destroy',
            ],
            'parameters' => [
                'jenis-dokumen' => 'jenisDokumen'
            ]
        ])->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        // === MANAJEMEN PERAN ===
        Route::resource('admin/peran', PeranController::class, [
            'names' => [
                'index' => 'admin.peran.index',
                'create' => 'admin.peran.create',
                'store' => 'admin.peran.store',
                'show' => 'admin.peran.show',
                'edit' => 'admin.peran.edit',
                'update' => 'admin.peran.update',
                'destroy' => 'admin.peran.destroy',
            ]
        ]);

        // === MANAJEMEN PERAN USER ===
        Route::post('/admin/users/{user}/peran/attach', [UserPeranController::class, 'attach'])->name('user.peran.attach');
        Route::post('/admin/users/{user}/peran/detach', [UserPeranController::class, 'detach'])->name('user.peran.detach');

        // === LAPORAN & REPORT ===
        Route::prefix('admin/reports')->as('admin.reports.')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('index');
            Route::get('/statistics', [ReportController::class, 'statistics'])->name('statistics');
            Route::get('/export/pendaftaran', [ReportController::class, 'exportPendaftaran'])->name('export.pendaftaran');
            Route::get('/export/dokumen', [ReportController::class, 'exportDokumen'])->name('export.dokumen');
            Route::get('/export/activity-log', [ReportController::class, 'exportActivityLog'])->name('export.activity-log');
        });
    });

// Public route for signed dokumen download (uses URL signature)
Route::get('/dokumen/signed/{dokumen}/download', [DokumenController::class, 'signedDownload'])->name('dokumen.signed.download');

});

