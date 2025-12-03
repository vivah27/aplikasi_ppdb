<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Jurusan;
use App\Models\Siswa;
use App\Models\Gelombang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FormulirController extends Controller
{
    /**
     * Generate nomor pendaftaran unik
     * Format: PPDB-YYYY-XXXXX (PPDB-2025-00001, PPDB-2025-00002, dll)
     */
    private function generateNomorPendaftaran()
    {
        $tahunAjaran = date('Y');
        $prefix = 'PPDB-' . $tahunAjaran . '-';
        
        // Cari nomor terakhir yang sudah ada
        $lastPendaftaran = Pendaftaran::where('nomor_pendaftaran', 'like', $prefix . '%')
            ->latest('id')
            ->first();
        
        if ($lastPendaftaran) {
            // Extract angka terakhir dan tambah 1
            $lastNumber = (int) substr($lastPendaftaran->nomor_pendaftaran, -5);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        // Generate nomor dengan format 5 digit (00001, 00002, dst)
        return $prefix . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }
    
    public function index()
    {
        // Ambil jurusan yang aktif dan urut berdasarkan nama
        $jurusans = Jurusan::where('is_active', true)
                           ->orderBy('kode_jurusan')
                           ->get();
        
        // Ambil gelombang yang aktif
        $gelombangAktif = Gelombang::where('is_active', true)->first();
        
        if (!$gelombangAktif) {
            // Jika tidak ada gelombang aktif, gunakan gelombang pertama sebagai default
            $gelombangAktif = Gelombang::orderBy('nomor_gelombang')->first();
        }
        
        $siswa = Siswa::where('pengguna_id', Auth::id())->first();
        $pendaftaran = Pendaftaran::where('siswa_id', optional($siswa)->id)->first();
        
        // Cek apakah formulir sudah diisi (pendaftaran sudah ada)
        $isSubmitted = $pendaftaran ? true : false;

        return view('user.formulir', compact('jurusans', 'siswa', 'pendaftaran', 'gelombangAktif', 'isSubmitted'));
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
            // Auto-create siswa jika belum ada
            $siswa = Siswa::create([
                'pengguna_id' => Auth::id(),
                'nama_lengkap' => Auth::user()->name,
                'nisn' => '',
                'nik' => '',
            ]);
        }

        $pendaftaran = Pendaftaran::where('siswa_id', $siswa->id)->first();
        
        // Ambil gelombang yang aktif
        $gelombangAktif = Gelombang::where('is_active', true)->first();
        if (!$gelombangAktif) {
            $gelombangAktif = Gelombang::orderBy('nomor_gelombang')->first();
        }
        
        // Gunakan nomor gelombang yang aktif
        $gelombang = $gelombangAktif ? $gelombangAktif->nomor_gelombang : 1;
        
        // Generate nomor pendaftaran jika belum ada
        $nomorPendaftaran = $pendaftaran?->nomor_pendaftaran ?? $this->generateNomorPendaftaran();

        Pendaftaran::updateOrCreate(
            ['siswa_id' => $siswa->id],
            [
                'nomor_pendaftaran' => $nomorPendaftaran,
                'tahun_ajaran' => $request->tahun_ajaran,
                'jalur_pendaftaran' => $request->jalur_pendaftaran,
                'gelombang' => $gelombang,
                'harga_gelombang' => $gelombangAktif->harga ?? 0,
                'jenis_pembayaran' => $gelombangAktif->jenis_pembayaran ?? 'Uang Pendaftaran',
                'tujuan_rekening' => $gelombangAktif->tujuan_rekening ?? null,
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