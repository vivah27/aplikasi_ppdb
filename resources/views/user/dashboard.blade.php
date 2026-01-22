@extends('layouts.master')

@section('page_title', 'Dashboard Siswa')

@section('content')
<div style="max-width: 100%;">
    <!-- Welcome Section -->
    <div style="background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); padding: 40px 30px; border-radius: 12px; margin-bottom: 30px; color: white; box-shadow: 0 10px 25px rgba(79, 70, 229, 0.2);">
        <h2 style="margin: 0 0 10px 0; font-size: 28px; font-weight: 700;">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
        <p style="margin: 0; font-size: 14px; opacity: 0.9;">Kelola proses pendaftaran Anda di satu tempat</p>
    </div>

    <!-- Alerts -->
    @if (!$user->is_verified)
        <div style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #f59e0b; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-exclamation-triangle" style="color: #f59e0b; font-size: 20px;"></i>
                <div>
                    <strong style="color: #f59e0b;">Akun Belum Terverifikasi</strong>
                    <p style="margin: 3px 0 0 0; font-size: 13px; color: #f59e0b;">Silakan verifikasi akun Anda sebelum melanjutkan</p>
                </div>
            </div>
            <a href="{{ route('verify.form') }}" style="padding: 10px 20px; background: #f59e0b; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; white-space: nowrap;">Verifikasi Sekarang</a>
        </div>
    @endif

    @if (session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-check-circle" style="color: #10b981; font-size: 18px;"></i>
            <div>
                <strong style="color: #10b981;">Berhasil!</strong>
                <p style="margin: 3px 0 0 0; font-size: 14px; color: #10b981;">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Hasil Seleksi Alert -->
    @if($pendaftaran && $pendaftaran->statusPendaftaran)
        @php
            $status = $pendaftaran->statusPendaftaran->label;
        @endphp
        @if($status === 'Diterima')
            <div style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-trophy" style="color: #10b981; font-size: 24px;"></i>
                <div>
                    <strong style="color: #10b981;">Selamat! Anda Diterima! 🎉</strong>
                    <p style="margin: 3px 0 0 0; font-size: 14px; color: #10b981;">Anda telah berhasil lolos seleksi PPDB SMK Antartika 1 Sidoarjo. Silakan lanjutkan ke tahap daftar ulang.</p>
                </div>
            </div>
        @elseif($status === 'Ditolak')
            <div style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid #ef4444; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-heart-broken" style="color: #ef4444; font-size: 24px;"></i>
                <div>
                    <strong style="color: #ef4444;">Maaf, Anda Belum Diterima</strong>
                    <p style="margin: 3px 0 0 0; font-size: 14px; color: #ef4444;">Terima kasih telah mengikuti proses PPDB. Tetap semangat dan sukses di masa depan!</p>
                </div>
            </div>
        @endif
    @endif

    <!-- Quick Actions Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <!-- Card 1: Formulir -->
        <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s; border-left: 4px solid #4f46e5;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.15)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)'">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
                <i class="fas fa-file-alt" style="font-size: 32px; color: #4f46e5; opacity: 0.2;"></i>
                <span style="display: inline-block; padding: 6px 12px; background: rgba(79, 70, 229, 0.15); color: #4f46e5; border-radius: 6px; font-size: 12px; font-weight: 600;">Form</span>
            </div>
            <h5 style="margin: 0 0 8px 0; color: #1f2937; font-weight: 700;">Formulir Pendaftaran</h5>
            <p style="margin: 0 0 20px 0; color: #6b7280; font-size: 14px;">Lengkapi data pribadi, sekolah asal, dan pilihan jurusan Anda</p>
            <a href="{{ route('formulir.index') }}" style="display: inline-block; padding: 10px 16px; background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; transition: all 0.3s;">
                <i class="fas fa-arrow-right" style="margin-right: 6px;"></i>Isi Formulir
            </a>
        </div>

        <!-- Card 2: Status -->
        <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s; border-left: 4px solid #10b981;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.15)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)'">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
                <i class="fas fa-info-circle" style="font-size: 32px; color: #10b981; opacity: 0.2;"></i>
                <span style="display: inline-block; padding: 6px 12px; background: rgba(16, 185, 129, 0.15); color: #10b981; border-radius: 6px; font-size: 12px; font-weight: 600;">Status</span>
            </div>
            <h5 style="margin: 0 0 8px 0; color: #1f2937; font-weight: 700;">Status Pendaftaran</h5>
            @php
                $statusLabel = $pendaftaran && $pendaftaran->statusPendaftaran ? $pendaftaran->statusPendaftaran->label : 'Belum Ada';
                $statusColor = match($statusLabel) {
                    'Diterima' => '#10b981',
                    'Ditolak' => '#ef4444',
                    'Menunggu' => '#f59e0b',
                    default => '#6b7280'
                };
                $statusIcon = match($statusLabel) {
                    'Diterima' => 'fas fa-check-circle',
                    'Ditolak' => 'fas fa-times-circle',
                    'Menunggu' => 'fas fa-clock',
                    default => 'fas fa-question-circle'
                };
            @endphp
            @if($pendaftaran && $pendaftaran->statusPendaftaran)
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                    <i class="{{ $statusIcon }}" style="font-size: 24px; color: {{ $statusColor }};"></i>
                    <span style="font-size: 18px; font-weight: 600; color: {{ $statusColor }};">{{ $statusLabel }}</span>
                </div>
                @if($statusLabel === 'Diterima')
                    <p style="margin: 0 0 20px 0; color: #6b7280; font-size: 14px;">Selamat! Anda telah diterima. Silakan lanjutkan ke tahap berikutnya.</p>
                @elseif($statusLabel === 'Ditolak')
                    <p style="margin: 0 0 20px 0; color: #6b7280; font-size: 14px;">Maaf, Anda belum diterima pada periode ini. Tetap semangat!</p>
                @else
                    <p style="margin: 0 0 20px 0; color: #6b7280; font-size: 14px;">Hasil seleksi sedang diproses. Pantau terus perkembangannya.</p>
                @endif
            @else
                <p style="margin: 0 0 20px 0; color: #6b7280; font-size: 14px;">Pantau status kelulusan dan hasil seleksi PPDB Anda secara real-time</p>
            @endif
            <a href="{{ route('user.status') }}" style="display: inline-block; padding: 10px 16px; background: linear-gradient(135deg, #10b981 0%, #34d399 100%); color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; transition: all 0.3s;">
                <i class="fas fa-arrow-right" style="margin-right: 6px;"></i>Lihat Detail Status
            </a>
        </div>

        <!-- Card 3: (removed) Dokumen - per request removed from user dashboard -->

        <!-- Card 4: Kartu Ujian -->
        <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s; border-left: 4px solid #0ea5e9;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.15)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)'">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
                <i class="fas fa-id-card" style="font-size: 32px; color: #0ea5e9; opacity: 0.2;"></i>
                <span style="display: inline-block; padding: 6px 12px; background: rgba(14, 165, 233, 0.15); color: #0ea5e9; border-radius: 6px; font-size: 12px; font-weight: 600;">Cetak</span>
            </div>
            <h5 style="margin: 0 0 8px 0; color: #1f2937; font-weight: 700;">Cetak Kartu Ujian</h5>
            <p style="margin: 0 0 20px 0; color: #6b7280; font-size: 14px;">Unduh atau cetak kartu ujian untuk mengikuti tahap seleksi berikutnya</p>
            @php
                $pendaftaranUser = \App\Models\Pendaftaran::whereHas('siswa', function($q) { 
                    $q->where('pengguna_id', Auth::id()); 
                })->with('pembayaran.statusPembayaran')->first();
            @endphp
            @if($pendaftaranUser && $pendaftaranUser->pembayaran && $pendaftaranUser->pembayaran->statusPembayaran->nama === 'LUNAS')
                <a href="{{ route('cetak.kartu', ['pendaftaranId' => $pendaftaranUser->id]) }}" style="display: inline-block; padding: 10px 16px; background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%); color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; transition: all 0.3s;">
                    <i class="fas fa-arrow-right" style="margin-right: 6px;"></i>Cetak Sekarang
                </a>
            @else
                <button style="display: inline-block; padding: 10px 16px; background: #ccc; color: #666; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; border: none; cursor: not-allowed;" disabled>
                    <i class="fas fa-lock" style="margin-right: 6px;"></i>Tunggu Pembayaran
                </button>
            @endif
        </div>

        <!-- Card 5: Pembayaran -->
        <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s; border-left: 4px solid #8b5cf6;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.15)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)'">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
                <i class="fas fa-credit-card" style="font-size: 32px; color: #8b5cf6; opacity: 0.2;"></i>
                <span style="display: inline-block; padding: 6px 12px; background: rgba(139, 92, 246, 0.15); color: #8b5cf6; border-radius: 6px; font-size: 12px; font-weight: 600;">Bayar</span>
            </div>
            <h5 style="margin: 0 0 8px 0; color: #1f2937; font-weight: 700;">Pembayaran</h5>
            <p style="margin: 0 0 20px 0; color: #6b7280; font-size: 14px;">Kelola pembayaran biaya pendaftaran atau daftar ulang</p>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('user.pembayaran.index') }}" style="display: inline-block; padding: 10px 16px; background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%); color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; transition: all 0.3s;">
                    <i class="fas fa-arrow-right" style="margin-right: 6px;"></i>Lihat Pembayaran
                </a>
                @if(isset($hasVerifiedPayment) && $hasVerifiedPayment)
                <a href="{{ route('cetak.kuitansi.index') }}" style="display: inline-block; padding: 10px 16px; background: linear-gradient(135deg, #10b981 0%, #34d399 100%); color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; transition: all 0.3s;">
                    <i class="fas fa-print" style="margin-right: 6px;"></i>Cetak Kuitansi
                </a>
                @endif
            </div>
        </div>

        <!-- Card 6: Profil -->
        <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s; border-left: 4px solid #ec4899;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.15)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)'">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
                <i class="fas fa-user-circle" style="font-size: 32px; color: #ec4899; opacity: 0.2;"></i>
                <span style="display: inline-block; padding: 6px 12px; background: rgba(236, 72, 153, 0.15); color: #ec4899; border-radius: 6px; font-size: 12px; font-weight: 600;">Profil</span>
            </div>
            <h5 style="margin: 0 0 8px 0; color: #1f2937; font-weight: 700;">Profil Saya</h5>
            <p style="margin: 0 0 20px 0; color: #6b7280; font-size: 14px;">Lihat dan ubah data profil akun Anda kapan saja</p>
            <a href="{{ route('profil.index') }}" style="display: inline-block; padding: 10px 16px; background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%); color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; transition: all 0.3s;">
                <i class="fas fa-arrow-right" style="margin-right: 6px;"></i>Lihat Profil
            </a>
        </div>
    </div>

    <!-- Info Section -->
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <div style="display: flex; align-items: flex-start; gap: 15px;">
            <i class="fas fa-lightbulb" style="font-size: 24px; color: #f59e0b; margin-top: 5px;"></i>
            <div>
                <h5 style="margin: 0 0 8px 0; color: #1f2937; font-weight: 700;">Informasi Penting</h5>
                <p style="margin: 0; color: #6b7280; font-size: 14px;">Pastikan Anda telah melengkapi semua berkas pendaftaran, termasuk data pribadi, biodata, dan dokumen pendukung. Seluruh proses pendaftaran harus diselesaikan sebelum batas waktu yang ditentukan. Untuk bantuan lebih lanjut, silakan hubungi panitia PPDB.</p>
            </div>
        </div>
    </div>
</div>

<style>
    a:hover {
        opacity: 0.9;
    }
</style>
@endsection
