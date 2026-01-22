<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Mail\ResetPasswordMail;
use App\Mail\SendOtpMail;


use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;

class AuthController extends Controller
{



    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        // Validate the request data
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // akan bernilai true jika dicentang
        
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
        
        // Add captcha validation only if sitekey is set
        if (config('nocaptcha.sitekey')) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }
        
        $request->validate($rules);

        // Validasi email sudah diverifikasi (kecuali admin)
        $user = User::where('email', $credentials['email'])->first();
        if ($user && $user->role != 'admin' && !$user->is_verified) {
            session(['verify_email' => $user->email]);
            return back()->withErrors([
                'verify_email' => 'Email belum diverifikasi. Silahkan periksa email Anda untuk kode OTP.',
            ])->withInput($request->except('password'));
        }

        // Attempt to log the user in
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        // If authentication fails, redirect back with an error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',

        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role ?? 'user',
        ]);

        // Set session untuk email yang akan diverifikasi
        session(['verify_email' => $user->email]);
        return $this->sendOtp($user, true); // true: from register
    }

    public function sendOtp($user = null, $fromRegister = false)
    {
        if (!$user) {
            if (Auth::check()) {
                $user = Auth::user();
            } elseif (session('verify_email')) {
                $user = User::where('email', session('verify_email'))->firstOrFail();
            } else {
                return redirect()->route('login')->withErrors(['email' => 'Email tidak ditemukan.']);
            }
        }


        $setResendOtp = 60; // dalam ms / detik


        if (session('last_otp_sent') && abs((int)now()->diffInSeconds(session('last_otp_sent'))) <   $setResendOtp) {
            return back()->withErrors(['otp' => 'Tunggu ' .  $setResendOtp . ' detik sebelum mengirim ulang OTP.']);
        }

        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->otp_code = bcrypt($otp);
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        // Kirim email
        $subject = 'OTP Verifikasi Email';
        // Send OTP email directly
        try {
            Mail::to($user->email)->send(new SendOtpMail(
                $subject,
                $user->name,
                $otp,
                $user->otp_expires_at->format('d M Y H:i:s')
            ));
            // Log OTP untuk testing
            Log::info('OTP dikirim ke ' . $user->email . ': ' . $otp);
        } catch (\Exception $e) {
            // Log error jika email gagal dikirim
            Log::error('OTP email failed: ' . $e->getMessage());
        }

        session([
            'verify_email' => $user->email,
            'last_otp_sent' => now(),
        ]);

        // Jika dari register, tampilkan alert success dan countdown
        if ($fromRegister) {
            return redirect()->route('verify.form')->with('success', 'Kode OTP telah dikirim ke ' . $user->email);
        }
        // Jika dari resend, tampilkan alert success
        return back()->with('success', 'Kode OTP baru telah dikirim ke ' . $user->email);
    }




    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        // Ambil user dari session (bukan dari Auth, karena user belum login)
        $user = null;
        if (session('verify_email')) {
            $user = User::where('email', session('verify_email'))->first();
        }

        // Pastikan user ditemukan dan instance model
        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Data verifikasi tidak ditemukan.']);
        }

        // Sanitize OTP input - hapus semua whitespace dan karakter non-digit
        $otpInput = preg_replace('/[^0-9]/', '', $request->otp);
        
        // Validasi panjang OTP setelah sanitize
        if (strlen($otpInput) !== 6) {
            return back()->withErrors(['otp' => 'Kode OTP harus 6 digit.']);
        }

        // Cek OTP expired terlebih dahulu
        if (now()->gt($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kedaluwarsa. Silahkan minta kode baru.']);
        }

        // Cek OTP dengan Hash::check
        if (!Hash::check($otpInput, $user->otp_code)) {
            return back()->withErrors(['otp' => 'Kode OTP salah. Pastikan Anda memasukkan kode dengan benar.'])->withInput();
        }

        // Sukses verifikasi
        $user->is_verified = true;
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        // Hapus session verifikasi
        session()->forget(['verify_email', 'last_otp_sent']);

        return redirect()->route('login')->with('success', 'Email berhasil diverifikasi! Sekarang Anda bisa login.');
    }
    // Tampilkan form verifikasi email
    public function showVerifyForm()
    {
        // Jika sudah login, izinkan untuk verify dari dashboard
        if (Auth::check()) {
            $user = Auth::user();
            return $this->sendOtp($user, true);
        }

        // Jika belum login, maka harus ada session verify_email
        // Session ini di-set dari login method saat verifikasi ditolak
        if (!session('verify_email')) {
            return redirect()->route('register')->with('error', 'Silahkan lakukan registrasi terlebih dahulu');
        }

        // Tidak mengubah session apapun, hanya hitung cooldown dari session
        $cooldown = 0;
        $setResendOtp = 60;
        if (session('last_otp_sent')) {
            $diff = (int)now()->diffInSeconds(session('last_otp_sent'));
            $cooldown = abs($diff);
        }

        return view('auth.verify-email', [
            'cooldown' => $cooldown,
            'timeResendOtp' => $setResendOtp
        ]);
    }

    public function redirect($provider)
    {
        try {
            Log::info('SSO redirect initiated for provider: ' . $provider);
            Log::info('Current APP_URL: ' . config('app.url'));
            Log::info('Google Redirect URI: ' . config('services.google.redirect'));
            Log::info('APP_ENV: ' . config('app.env'));
            
            $driver = Socialite::driver($provider);
            
            // Set custom HTTP client without SSL verification for local dev
            if (config('app.env') === 'local') {
                $driver->setHttpClient($this->getSocialiteHttpClient());
            }
            
            // Redirect to provider
            return $driver->redirect();
        } catch (\Throwable $e) {
            Log::error('SSO redirect error for ' . $provider . ': ' . $e->getMessage());
            return redirect()->route('login')->withErrors([
                'sso' => 'Terjadi kesalahan saat redirect ke ' . ucfirst($provider),
            ]);
        }
    }

    public function callback($provider)
    {
        try {
            Log::info('SSO callback received for provider: ' . $provider);
            Log::info('Request URL: ' . request()->fullUrl());
            
            $driver = Socialite::driver($provider);
            
            // Set custom HTTP client without SSL verification for local dev
            if (config('app.env') === 'local') {
                $driver->setHttpClient($this->getSocialiteHttpClient());
            }
            
            // Ambil data user dari provider
            $socialUser = $driver->user();
            
            Log::info('Social user data retrieved: ' . $socialUser->getEmail());

            // Cek apakah user sudah ada
            $user = User::where('email', $socialUser->getEmail())->first();

            if (!$user) {
                // Create user baru
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => bcrypt(Str::random(24)), // random password
                    'role' => 'user',
                    'is_verified' => true, // SSO users are automatically verified
                ]);
                Log::info('New user created via SSO: ' . $user->email);
            }

            Log::info('User created/updated: ' . $user->email . ' with role: ' . $user->role);

            // Login ke aplikasi
            Auth::login($user, remember: true);

            // Redirect sesuai role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Berhasil login sebagai admin menggunakan ' . ucfirst($provider) . '!');
            }
            
            return redirect()->route('dashboard')->with('success', 'Berhasil login menggunakan ' . ucfirst($provider) . '!');
            
        } catch (\Throwable $e) {
            Log::error('SSO callback error for ' . $provider . ': ' . $e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->route('login')->withErrors([
                'sso' => 'Terjadi kesalahan saat login dengan ' . ucfirst($provider) . ': ' . $e->getMessage(),
            ]);
        }
    }

    private function getSocialiteHttpClient()
    {
        return new GuzzleClient([
            RequestOptions::VERIFY => false,
        ]);
    }


    // Form untuk request reset
    public function showRequestForm()
    {
        return view('auth.forgot-password.email');
    }

    // Kirim email reset
    public function sendResetLink(Request $request)
    {

        $request->validate(['email' => 'required|email']);

        // cek apakah email ada di db
        $user  = User::whereEmail($request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar dalam sistem kami']);
        }

        // Generate OTP code
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'otp_code' => Hash::make($otp),
                'otp_expires_at' => now()->addMinutes(10),
                'is_verified' => false,
                'created_at' => now()
            ]
        );

        // Send the reset password email with OTP directly
        try {
            Mail::to($request->email)->send(new ResetPasswordMail(
                $user->name,
                $otp,
                now()->addMinutes(10)->format('d M Y H:i:s'),
                $token,
                $request->email
            ));
        } catch (\Exception $e) {
            Log::error('Reset password email failed: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Gagal mengirim email. Silakan coba lagi.']);
        }

        return redirect()->route('login')->with('success', 'Kode verifikasi telah dikirim ke email Anda. Silakan cek email untuk melanjutkan reset password.');
    }

    // Form untuk reset password
    public function showResetForm($token)
    {
        $getEmail = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->firstOrFail();
        $user = User::whereEmail($getEmail->email)->firstOrFail();

        return view('auth.forgot-password.reset', compact('token', 'user'));
    }

    // Form untuk verifikasi OTP sebelum reset password
    public function showVerifyResetForm($token)
    {
        $reset = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->first();

        if (!$reset) {
            return redirect()->route('forgot_password.email_form')
                ->withErrors(['email' => 'Token tidak valid.']);
        }

        // Cek apakah sudah expired
        if (now()->gt($reset->otp_expires_at)) {
            DB::table('password_reset_tokens')->where('token', $token)->delete();
            return redirect()->route('forgot_password.email_form')
                ->withErrors(['email' => 'Kode verifikasi sudah kadaluarsa. Silakan request ulang.']);
        }

        $user = User::whereEmail($reset->email)->first();

        return view('auth.forgot-password.verify-otp', compact('token', 'user'));
    }

    // Verifikasi OTP untuk reset password
    public function verifyResetOtp(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'otp' => 'required|numeric|digits:6',
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withErrors(['otp' => 'Token tidak valid.']);
        }

        // Cek OTP expired
        if (now()->gt($reset->otp_expires_at)) {
            DB::table('password_reset_tokens')->where('token', $request->token)->delete();
            return redirect()->route('forgot_password.email_form')
                ->withErrors(['email' => 'Kode verifikasi sudah kadaluarsa. Silakan request ulang.']);
        }

        // Cek OTP code
        if (!Hash::check($request->otp, $reset->otp_code)) {
            return back()->withErrors(['otp' => 'Kode verifikasi salah.']);
        }

        // Update status verified
        DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->update(['is_verified' => true]);

        $user = User::whereEmail($reset->email)->first();

        return view('auth.forgot-password.reset', compact('request'))
            ->with('token', $request->token)
            ->with('user', $user)
            ->with('success', 'Kode verifikasi berhasil! Silakan buat password baru Anda.');
    }

    // Update password user
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return redirect()->route('forgot_password.email_form')
                ->withErrors(['email' => 'Token tidak valid.']);
        }

        // Cek apakah OTP sudah diverifikasi
        if (!$reset->is_verified) {
            return back()->withErrors(['email' => 'Silakan verifikasi kode OTP terlebih dahulu.']);
        }

        // Cek apakah token expired (lebih dari 10 menit)
        $createdAt = abs((int) now()->diffInMinutes($reset->created_at));
        if ($createdAt > 10) {
            DB::table('password_reset_tokens')->where('token', $request->token)->delete();
            return redirect()->route('forgot_password.email_form')
                ->withErrors(['email' => 'Token sudah kadaluarsa, silakan request ulang.']);
        }

        // Update password user
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Hapus token biar sekali pakai
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        
        // Set session with the registered email
        $request->session()->flash('registered_email', $request->email);
        
        return redirect('/login')->with('success', 'Password berhasil direset! Silahkan Login menggunakan password baru Anda.');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
