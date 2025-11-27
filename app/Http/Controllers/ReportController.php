<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Siswa;
use App\Models\Dokumen;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Show report page
     */
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalPendaftaran = Pendaftaran::count();
        $totalDokumen = Dokumen::count();

        return view('admin.reports.index', compact('totalSiswa', 'totalPendaftaran', 'totalDokumen'));
    }

    /**
     * Export pendaftaran data to CSV
     */
    public function exportPendaftaran()
    {
        $pendaftarans = Pendaftaran::with('siswa', 'statusPendaftaran', 'jurusanPilihan1', 'jurusanPilihan2')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="pendaftaran_' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($pendaftarans) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['No. Pendaftaran', 'Nama Siswa', 'Email', 'No. HP', 'Asal Sekolah', 'Jurusan Pilihan 1', 'Jurusan Pilihan 2', 'Status', 'Tanggal Pendaftaran']);

            // Data
            foreach ($pendaftarans as $p) {
                fputcsv($file, [
                    $p->nomor_pendaftaran,
                    $p->siswa?->nama_lengkap,
                    $p->siswa?->email,
                    $p->siswa?->no_hp,
                    $p->siswa?->asal_sekolah,
                    $p->jurusanPilihan1?->nama,
                    $p->jurusanPilihan2?->nama,
                    $p->statusPendaftaran?->label,
                    $p->created_at->format('d-m-Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export dokumen data to CSV
     */
    public function exportDokumen()
    {
        $dokumens = Dokumen::with('siswa', 'jenisDokumen', 'statusVerifikasi')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="dokumen_' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($dokumens) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['Nama Siswa', 'Jenis Dokumen', 'Status Verifikasi', 'Tanggal Upload', 'Tanggal Update']);

            // Data
            foreach ($dokumens as $d) {
                fputcsv($file, [
                    $d->siswa?->nama_lengkap,
                    $d->jenisDokumen?->nama,
                    $d->statusVerifikasi?->label,
                    $d->created_at->format('d-m-Y H:i'),
                    $d->updated_at->format('d-m-Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export activity log to CSV
     */
    public function exportActivityLog()
    {
        $activities = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="activity_log_' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($activities) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['Nama User', 'Aksi', 'Deskripsi', 'IP Address', 'Waktu']);

            // Data
            foreach ($activities as $a) {
                fputcsv($file, [
                    $a->user?->name,
                    $a->action,
                    $a->description,
                    $a->ip_address,
                    $a->created_at->format('d-m-Y H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show statistics summary
     */
    public function statistics()
    {
        $pendaftaranPerStatus = DB::table('pendaftarans')
            ->leftJoin('status_pendaftarans', 'pendaftarans.status_id', '=', 'status_pendaftarans.id')
            ->select('status_pendaftarans.label', DB::raw('count(*) as total'))
            ->groupBy('status_pendaftarans.label')
            ->get();

        $dokumenPerStatus = DB::table('dokumens')
            ->join('status_verifikasis', 'dokumens.status_verifikasi_id', '=', 'status_verifikasis.id')
            ->select('status_verifikasis.label', DB::raw('count(*) as total'))
            ->groupBy('status_verifikasis.label')
            ->get();

        $siswaPerJurusan = DB::table('pendaftarans')
            ->leftJoin('jurusans', 'pendaftarans.jurusan_pilihan_1', '=', 'jurusans.id')
            ->select('jurusans.nama', DB::raw('count(*) as total'))
            ->whereNotNull('jurusans.id')
            ->groupBy('jurusans.nama')
            ->get();

        return view('admin.reports.statistics', compact('pendaftaranPerStatus', 'dokumenPerStatus', 'siswaPerJurusan'));
    }
}
