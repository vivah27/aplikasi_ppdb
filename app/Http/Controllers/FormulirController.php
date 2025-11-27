<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Jurusan;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FormulirController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::all();
        $siswa = Siswa::where('pengguna_id', Auth::id())->first();
        $pendaftaran = Pendaftaran::where('siswa_id', optional($siswa)->id)->first();

        return view('user.formulir', compact('jurusans', 'siswa', 'pendaftaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required',
            'jalur_pendaftaran' => 'required',
            'jurusan_pilihan' => 'required|integer',
            'rata_nilai' => 'required|numeric|min:0|max:100',
        ]);

        $siswa = Siswa::where('pengguna_id', Auth::id())->first();

        if (!$siswa) {
            return redirect()->back()->with('error', 'Data biodata siswa belum diisi.');
        }

        $pendaftaran = Pendaftaran::where('siswa_id', $siswa->id)->first();
        
        // Get current gelombang or default to 1
        $gelombang = $pendaftaran?->gelombang ?? 1;

        Pendaftaran::updateOrCreate(
            ['siswa_id' => $siswa->id],
            [
                'tahun_ajaran' => $request->tahun_ajaran,
                'jalur_pendaftaran' => $request->jalur_pendaftaran,
                'gelombang' => $gelombang,
                'jurusan_pilihan_1' => $request->jurusan_pilihan,
                'jurusan_pilihan_2' => null,
                'rata_nilai' => $request->rata_nilai,
                'tanggal_daftar' => Carbon::now(),
                'status_id' => 2, // Default status: "Menunggu" (id 2)
                'dibuat_oleh' => Auth::id(),
                'diperbarui_oleh' => Auth::id(),
            ]
        );

        return redirect()->back()->with('success', 'Formulir pendaftaran berhasil disimpan!');
    }
}