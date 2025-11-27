<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>Reset Password</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f7f7f7;
                padding: 20px;
                margin: 0;
            }

            .container {
                background-color: #ffffff;
                padding: 30px;
                border-radius: 8px;
                max-width: 600px;
                margin: auto;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                border: 1px solid #e9e9e9;
            }

            .header {
                background-color: #2c3e50;
                color: #ffffff;
                padding: 15px;
                text-align: center;
                font-size: 22px;
                border-radius: 5px 5px 0 0;
                margin: -30px -30px 20px -30px;
                /* Extends header to the container edges */
            }

            .content p {
                line-height: 1.6;
                color: #555555;
            }

            .button-container {
                text-align: center;
                /* Centers the button */
                margin: 30px 0;
            }

            .button-container a {
                color: white
            }

            .btn {
                display: inline-block;
                padding: 12px 25px;
                background-color: #2c3e50;
                /* Changed to header color */
                color: #ffffff;
                text-decoration: none;
                border-radius: 5px;
                font-size: 16px;
            }

            .footer {
                margin-top: 30px;
                font-size: 12px;
                color: #888888;
                text-align: center;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="header">
                Reset Password
            </div>
            <div class="content">
                <p>Halo <b>{{ $name }}</b>,</p>
                <p>Anda telah meminta untuk mereset password akun Anda. Berikut adalah kode verifikasi Anda:</p>
            </div>
            <div style="text-align: center; background-color: #f5f5f5; padding: 20px; border-radius: 5px; margin: 20px 0;">
                <h3 style="color: #2c3e50; letter-spacing: 5px; font-size: 24px; margin: 0;">{{ $otp }}</h3>
                <p style="color: #888888; font-size: 12px; margin-top: 10px;">Kode berlaku selama 10 menit</p>
            </div>
            <div class="button-container">
                <a href="{{ route('password.verify-form', ['token' => $token]) }}" class="btn">
                    Masukkan Kode Verifikasi
                </a>
            </div>
            <div class="content">
                <p><strong>Langkah Selanjutnya:</strong></p>
                <ol>
                    <li>Klik tombol di atas atau buka link berikut: <a href="{{ route('password.verify-form', ['token' => $token]) }}" style="color: #2c3e50;">{{ route('password.verify-form', ['token' => $token]) }}</a></li>
                    <li>Masukkan kode verifikasi: <strong>{{ $otp }}</strong></li>
                    <li>Buat password baru Anda</li>
                </ol>
                <p>Kode ini berlaku sampai <b>{{ $expireAt }}</b>. Jika sudah lewat, Anda harus membuat permintaan ulang.</p>
                <p style="color: #c0392b;"><strong>⚠️ Penting:</strong> Jika Anda tidak pernah meminta proses ini, abaikan email ini dan password Anda tetap aman.</p>
            </div>
            <div class="footer">
                &copy; {{ date('Y') }} Aplikasi PPDB SMK
            </div>
        </div>
    </body>

</html>
