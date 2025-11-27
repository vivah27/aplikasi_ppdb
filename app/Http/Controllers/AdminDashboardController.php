<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Pendaftaran;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Verifikasi;
use App\Models\JenisDokumen;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // === STAT CARDS DATA ===
        $totalSiswa = Siswa::count();
        $totalPendaftaran = Pendaftaran::count();
        $totalDokumen = Dokumen::count();
        $totalVerifikasi = Verifikasi::count();

        // Status Pendaftaran breakdown
        $statusStats = DB::table('pendaftarans')
            ->leftJoin('status_pendaftarans', 'pendaftarans.status_id', '=', 'status_pendaftarans.id')
            ->select('status_pendaftarans.label', DB::raw('count(*) as total'))
            ->groupBy('status_pendaftarans.label')
            ->get();

        $diterima = $statusStats->where('label', 'Diterima')->first()?->total ?? 0;
        $menunggu = $statusStats->where('label', 'Menunggu')->first()?->total ?? 0;
        $ditolak = $statusStats->where('label', 'Ditolak')->first()?->total ?? 0;

        // Dokumen Status breakdown
        $dokumenStatus = DB::table('dokumens')
            ->leftJoin('status_verifikasis', 'dokumens.status_verifikasi_id', '=', 'status_verifikasis.id')
            ->select('status_verifikasis.label', DB::raw('count(*) as total'))
            ->groupBy('status_verifikasis.label')
            ->get();

        $dokumenTerverifikasi = $dokumenStatus->where('label', 'Terverifikasi')->first()?->total ?? 0;
        $dokumenTertunda = $dokumenStatus->where('label', 'Menunggu Verifikasi')->first()?->total ?? 0;
        $dokumenDitolak = $dokumenStatus->where('label', 'Ditolak')->first()?->total ?? 0;

        // Recent activities
        $recentVerifications = Verifikasi::with('pendaftaran.siswa', 'status', 'admin')
            ->latest()
            ->limit(10)
            ->get();

        $recentRegistrations = Pendaftaran::with('siswa', 'statusPendaftaran')
            ->latest()
            ->limit(5)
            ->get();

        $recentDocuments = Dokumen::with('jenisDokumen', 'siswa', 'statusVerifikasi')
            ->latest()
            ->limit(8)
            ->get();

        // Popular majors
        $popularMajors = DB::table('pendaftarans')
            ->join('jurusans', 'pendaftarans.jurusan_pilihan_1', '=', 'jurusans.id')
            ->select('jurusans.nama_jurusan as nama', DB::raw('count(*) as total'))
            ->groupBy('jurusans.nama_jurusan')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Documents per type
        $dokumenPerJenis = DB::table('dokumens')
            ->join('jenis_dokumens', 'dokumens.jenis_dokumen_id', '=', 'jenis_dokumens.id')
            ->select('jenis_dokumens.nama', DB::raw('count(*) as total'))
            ->groupBy('jenis_dokumens.nama')
            ->get();

        // Verification rate
        $verificationRate = $totalDokumen > 0 ? round(($dokumenTerverifikasi / $totalDokumen) * 100, 2) : 0;

        // Monthly registration trend (last 6 months)
        $monthlyRegistrations = DB::table('pendaftarans')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('count(*) as total')
            )
            ->whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)')
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('YEAR(created_at), MONTH(created_at)')
            ->get();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalPendaftaran',
            'totalDokumen',
            'totalVerifikasi',
            'diterima',
            'menunggu',
            'ditolak',
            'dokumenTerverifikasi',
            'dokumenTertunda',
            'dokumenDitolak',
            'verificationRate',
            'recentVerifications',
            'recentRegistrations',
            'recentDocuments',
            'popularMajors',
            'dokumenPerJenis',
            'monthlyRegistrations'
        ));
    }
}
