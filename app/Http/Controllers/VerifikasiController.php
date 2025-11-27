<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index()
    {
        // Tampilkan halaman daftar berkas yang perlu diverifikasi
        return view('admin.verifikasi');
    }

    public function update($id)
    {
        // Contoh logika verifikasi sederhana
        // Nanti kamu bisa ganti sesuai struktur tabel di database
        // Misal ubah status siswa menjadi 'terverifikasi'
        
        return redirect()->route('admin.verifikasi')->with('success', 'Berkas berhasil diverifikasi!');
    }
}
