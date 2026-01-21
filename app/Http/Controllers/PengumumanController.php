<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Siswa;

class PengumumanController extends Controller
{
    public function index()
    {
        return view('pengumuman.index');
    }

    public function cari(Request $request)
    {
        $request->validate([
            'nomor_pendaftaran' => 'required|string|max:50',
        ]);

        $nomorPendaftaran = $request->nomor_pendaftaran;

        // Cari pendaftaran berdasarkan nomor pendaftaran
        $pendaftaran = Pendaftaran::where('nomor_pendaftaran', $nomorPendaftaran)->first();

        if (!$pendaftaran) {
            return back()->with('error', 'Nomor pendaftaran tidak ditemukan.');
        }

        $siswa = $pendaftaran->siswa;
        $status = $pendaftaran->statusPendaftaran;

        return view('pengumuman.hasil', compact('pendaftaran', 'siswa', 'status'));
    }
}
