<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Pendaftaran;
use App\Models\Siswa;
use App\Models\StatusPendaftaran;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jurusans = \App\Models\Jurusan::all();
        
        // Get siswa data
        $siswa = Siswa::where('pengguna_id', $user->id)->first();
        $pendaftaran = $siswa ? Pendaftaran::where('siswa_id', $siswa->id)
            ->with(['statusPendaftaran', 'jurusanPilihan1', 'jurusanPilihan2'])
            ->first() : null;
        
        // Get statistics based on user role (support both role attribute and peran relationship)
        $isAdmin = (isset($user->role) && $user->role === 'admin');

        if ($isAdmin) {
            $statsData = [
                'total_siswa' => Siswa::count(),
                'diterima' => Pendaftaran::whereHas('statusPendaftaran', function($q) {
                    $q->where('label', 'Diterima');
                })->count(),
                'menunggu' => Pendaftaran::whereHas('statusPendaftaran', function($q) {
                    $q->where('label', 'Menunggu');
                })->count(),
                'ditolak' => Pendaftaran::whereHas('statusPendaftaran', function($q) {
                    $q->where('label', 'Ditolak');
                })->count(),
            ];
            
            $recentDocuments = Dokumen::with('jenisDokumen', 'statusVerifikasi')
                ->latest()
                ->limit(5)
                ->get();
            
            return view('dashboard', compact('jurusans', 'pendaftaran', 'statsData', 'recentDocuments'));
        }
        else {
            // User dashboard (safe null checks using optional())
            $statsData = [
                'total_siswa' => $siswa ? 1 : 0,
                'diterima' => ($pendaftaran && optional($pendaftaran->statusPendaftaran)->label === 'Diterima') ? 1 : 0,
                'menunggu' => ($pendaftaran && optional($pendaftaran->statusPendaftaran)->label === 'Menunggu') ? 1 : 0,
                'ditolak' => ($pendaftaran && optional($pendaftaran->statusPendaftaran)->label === 'Ditolak') ? 1 : 0,
            ];

            $recentDocuments = $siswa ? Dokumen::where('siswa_id', $siswa->id)
                ->with('jenisDokumen', 'statusVerifikasi')
                ->latest()
                ->limit(5)
                ->get() : collect();

            // Check if user has verified payment
            $hasVerifiedPayment = false;
            if ($pendaftaran) {
                $pembayaran = Pembayaran::where('pendaftaran_id', $pendaftaran->id)->first();
                $hasVerifiedPayment = $pembayaran && $pembayaran->isTerverifikasi();
            }

            return view('dashboard', compact('jurusans', 'pendaftaran', 'statsData', 'recentDocuments', 'hasVerifiedPayment'));
        }
    }
}
