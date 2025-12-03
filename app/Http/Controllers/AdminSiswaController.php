<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Pendaftaran;
use App\Models\Biodata;
use App\Models\StatusPendaftaran;
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
        $format = $request->get('format');

        // Build query for Siswa dengan pendaftaran
        $query = Siswa::with(['pengguna', 'pendaftaran' => function($q) use ($gelombang) {
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

        // Return JSON if requested
        if ($format === 'json') {
            return response()->json([
                'siswa' => $siswa->items()->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nama_lengkap' => $item->nama_lengkap,
                        'pengguna_id' => $item->pengguna_id,
                        'pengguna' => $item->pengguna,
                        'pendaftaran' => $item->pendaftaran->first(),
                    ];
                }),
            ]);
        }

        // Get list of gelombang for filter dropdown
        $gelombangList = Pendaftaran::select('gelombang')->distinct()->orderBy('gelombang')->pluck('gelombang');

        return view('admin.siswa.index', compact('siswa', 'gelombangList', 'gelombang', 'search'));
    }

    /**
     * Show student detail
     */
    public function show(Siswa $siswa)
    {
        // Load relationships
        $siswa->load(['pendaftaran' => function($q) {
            $q->latest()->limit(1);
        }, 'pendaftaran.statusPendaftaran', 'pendaftaran.jurusanPilihan1', 'pendaftaran.jurusanPilihan2']);
        
        $pendaftaran = $siswa->pendaftaran()->latest()->first();
        
        return view('admin.siswa.show', compact('siswa', 'pendaftaran'));
    }

    /**
     * Accept student registration
     */
    public function accept(Siswa $siswa)
    {
        try {
            // Get the latest pendaftaran
            $pendaftaran = $siswa->pendaftaran()->latest()->first();

            if (!$pendaftaran) {
                return redirect()->route('admin.siswa.index')->with('error', 'Pendaftaran tidak ditemukan');
            }

            // Get status 'DITERIMA' from database
            $statusDiterima = \App\Models\StatusPendaftaran::where('kode', 'diterima')->first();
            if (!$statusDiterima) {
                return redirect()->route('admin.siswa.index')->with('error', 'Status DITERIMA tidak ditemukan di database');
            }

            // Update status
            $pendaftaran->status_id = $statusDiterima->id;
            $pendaftaran->save();

            return redirect()->route('admin.siswa.index')->with('success', "{$siswa->nama_lengkap} berhasil diterima");
        } catch (\Exception $e) {
            return redirect()->route('admin.siswa.index')->with('error', 'Gagal memproses penerimaan: ' . $e->getMessage());
        }
    }

    /**
     * Reject student registration
     */
    public function reject(Siswa $siswa)
    {
        try {
            // Get the latest pendaftaran
            $pendaftaran = $siswa->pendaftaran()->latest()->first();

            if (!$pendaftaran) {
                return redirect()->route('admin.siswa.index')->with('error', 'Pendaftaran tidak ditemukan');
            }

            // Get status 'DITOLAK' from database
            $statusDitolak = \App\Models\StatusPendaftaran::where('kode', 'ditolak')->first();
            if (!$statusDitolak) {
                return redirect()->route('admin.siswa.index')->with('error', 'Status DITOLAK tidak ditemukan di database');
            }

            // Update status
            $pendaftaran->status_id = $statusDitolak->id;
            $pendaftaran->save();

            return redirect()->route('admin.siswa.index')->with('success', "{$siswa->nama_lengkap} berhasil ditolak");
        } catch (\Exception $e) {
            return redirect()->route('admin.siswa.index')->with('error', 'Gagal memproses penolakan: ' . $e->getMessage());
        }
    }

    /**
     * Reset student biodata
     */
    public function resetBiodata(Siswa $siswa)
    {
        try {
            // Get user's biodata
            $biodata = Biodata::where('user_id', $siswa->pengguna_id)->first();

            if ($biodata) {
                // Delete biodata
                $biodata->delete();
            }

            return redirect()->route('admin.siswa.show', $siswa->id)->with('success', "Biodata {$siswa->nama_lengkap} berhasil direset. Form biodata dapat diisi ulang.");
        } catch (\Exception $e) {
            return redirect()->route('admin.siswa.show', $siswa->id)->with('error', 'Gagal mereset biodata: ' . $e->getMessage());
        }
    }

}
