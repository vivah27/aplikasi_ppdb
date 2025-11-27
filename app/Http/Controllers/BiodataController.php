<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BiodataController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $biodata = Biodata::where('user_id', $user->id)->first();
        $siswa = Siswa::where('pengguna_id', $user->id)->first();
        
        return view('user.biodata', compact('biodata', 'siswa'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required',
            'nisn' => 'required',
            'nik' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'nama_ayah' => 'required',
            'pekerjaan_ayah' => 'required',
            'nama_ibu' => 'required',
            'pekerjaan_ibu' => 'required',
            'no_hp_wali' => 'required',
            'asal_sekolah' => 'required',
            'tahun_lulus' => 'required',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto_siswa', 'public');
        }

        $validated['user_id'] = Auth::id();

        // Simpan ke tabel biodata
        Biodata::updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        // Sinkronisasi ke tabel siswa
        $user = Auth::user();
        $siswa = Siswa::where('pengguna_id', $user->id)->first();
        
        if (!$siswa) {
            $siswa = new Siswa();
            $siswa->pengguna_id = $user->id;
        }

        // Map data biodata ke siswa
        $siswa->nama_lengkap = $validated['nama_lengkap'];
        $siswa->nisn = $validated['nisn'];
        $siswa->nik = $validated['nik'];
        $siswa->tempat_lahir = $validated['tempat_lahir'];
        $siswa->tanggal_lahir = $validated['tanggal_lahir'];
        
        // Convert jenis kelamin ke format singkat
        $jk = $validated['jenis_kelamin'];
        $siswa->jenis_kelamin = ($jk === 'Laki-laki' ? 'L' : ($jk === 'Perempuan' ? 'P' : $jk));
        
        $siswa->alamat = $validated['alamat'];
        $siswa->no_telepon = $validated['no_hp'];
        $siswa->asal_sekolah = $validated['asal_sekolah'];
        
        $siswa->save();

        // ✅ Arahkan ke halaman profil (bukan pembayaran)
        return redirect()->route('profil.index')
                 ->with('success', 'Data biodata siswa berhasil disimpan!');
    }
}
