<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSiswaController extends Controller
{
    /**
     * Display listing of siswa with filters
     */
    public function index(Request $request)
    {
        $gelombang = $request->get('gelombang');
        $search = $request->get('search');

        // Build query for Siswa dengan pendaftaran
        $query = Siswa::with(['pendaftaran' => function($q) use ($gelombang) {
                    // Load only latest or filtered pendaftaran
                    $q->orderByDesc('created_at');
                    if ($gelombang) {
                        $q->where('gelombang', $gelombang);
                    }
                }, 'pendaftaran.statusPendaftaran', 'pendaftaran.jurusanPilihan1'])
                ->whereHas('pendaftaran', function($q) use ($gelombang) {
                    // Filter siswa yang punya pendaftaran
                    if ($gelombang) {
                        $q->where('gelombang', $gelombang);
                    }
                });

        // Search by siswa name or NISN
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $siswa = $query->orderByDesc('created_at')->paginate(15);

        // Get list of gelombang for filter dropdown
        $gelombangList = Pendaftaran::select('gelombang')->distinct()->orderBy('gelombang')->pluck('gelombang');

        return view('admin.siswa.index', compact('siswa', 'gelombangList', 'gelombang', 'search'));
    }
}
