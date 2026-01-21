<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BiodataController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $biodata = Biodata::where('user_id', $user->id)->first();
        $siswa = Siswa::where('pengguna_id', $user->id)->first();
        
        // Check if user has filled the form (formulir pendaftaran)
        $pendaftaran = \App\Models\Pendaftaran::where('siswa_id', optional($siswa)->id)->first();
        
        $formulirBelumDiisi = !$pendaftaran;
        
        // Check jika biodata sudah lengkap (sudah submit sebelumnya)
        $isSubmitted = $biodata && (
            !empty($biodata->nama_lengkap) || 
            !empty($biodata->nisn) || 
            !empty($biodata->nik)
        );
        
        return view('user.biodata', compact('biodata', 'siswa', 'isSubmitted', 'formulirBelumDiisi'));
    }

    public function store(Request $request)
    {
        // Validasi berdasarkan pilihan jenis pendamping
        $jenisPendamping = $request->input('jenis_pendamping', 'ortu');
        
        // Cek apakah biodata sudah ada untuk user ini
        $existingBiodata = Biodata::where('user_id', Auth::id())->first();
        
        $baseRules = [
            'nama_lengkap' => 'required',
            'nisn' => $existingBiodata 
                ? 'required|unique:biodatas,nisn,' . $existingBiodata->id 
                : 'required|unique:biodatas,nisn',
            'nik' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required|numeric|regex:/^[0-9]{10,13}$/',
            'no_hp_wali' => 'required|numeric|regex:/^[0-9]{10,13}$/',
            'asal_sekolah' => [
                'required',
                'regex:/^[\p{L}0-9\s]+$/u',
                'max:255'
            ],
            'tahun_lulus' => 'required|numeric|digits:4',
            'npsn' => 'nullable|numeric',
            'foto' => $existingBiodata && $existingBiodata->foto
                ? 'nullable|image|max:2048'  // Opsional jika sudah ada foto
                : 'required|image|max:2048', // Wajib jika belum ada foto
            'jenis_pendamping' => 'required|in:ortu,wali',
        ];

        $customMessages = [
            'nisn.unique' => 'NISN sudah terdaftar di sistem.',
            'no_hp.numeric' => 'No. HP siswa hanya boleh berisi angka.',
            'no_hp.regex' => 'No. HP siswa harus berisi 10-13 digit angka.',
            'no_hp_wali.numeric' => 'No. HP orang tua/wali hanya boleh berisi angka.',
            'no_hp_wali.regex' => 'No. HP orang tua/wali harus berisi 10-13 digit angka.',
            'tahun_lulus.digits' => 'Tahun lulus harus berisi 4 digit angka (contoh: 2025).',
            'npsn.numeric' => 'NPSN sekolah hanya boleh berisi angka.',
            'asal_sekolah.regex' => 'Nama sekolah hanya boleh berisi huruf, angka, dan spasi.',
            'asal_sekolah.max' => 'Nama sekolah maksimal 255 karakter.',
        ];

        // Validasi conditional berdasarkan jenis pendamping
        if ($jenisPendamping === 'ortu') {
            $baseRules['nama_ayah'] = 'required';
            $baseRules['pekerjaan_ayah'] = 'required';
            $baseRules['nama_ibu'] = 'required';
            $baseRules['pekerjaan_ibu'] = 'required';
            $baseRules['nama_wali'] = 'nullable';
        } else {
            // Wali
            $baseRules['nama_wali'] = 'required';
            $baseRules['nama_ayah'] = 'nullable';
            $baseRules['pekerjaan_ayah'] = 'nullable';
            $baseRules['nama_ibu'] = 'nullable';
            $baseRules['pekerjaan_ibu'] = 'nullable';
        }

        $validated = $request->validate($baseRules, $customMessages);

        // UPLOAD FOTO - dengan error handling yang lebih baik
        if ($request->hasFile('foto')) {
            try {
                $file = $request->file('foto');
                $validated['foto'] = $file->store('foto_siswa', 'public');
                \Log::info('Biodata Foto Upload Success', [
                    'user_id' => Auth::id(),
                    'filename' => $validated['foto'],
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                ]);
            } catch (\Exception $e) {
                \Log::error('Biodata Foto Upload Failed', [
                    'user_id' => Auth::id(),
                    'error' => $e->getMessage(),
                ]);
                throw $e;
            }
        } else {
            // Jika tidak ada file, log warning
            \Log::warning('Biodata Foto Not Provided', [
                'user_id' => Auth::id(),
                'request_files' => $request->files->keys(),
            ]);
        }

        $validated['user_id'] = Auth::id();

        // PENTING: Clear field yang tidak digunakan SEBELUM save ke database
        // Ini memastikan field yang tidak dipilih benar-benar tidak tersimpan
        if ($jenisPendamping === 'ortu') {
            // Jika pilih orang tua, pastikan wali fields benar-benar kosong
            $validated['nama_wali'] = null;
            
            // PENTING: Validasi ketat - pastikan orang tua fields tidak kosong
            if (empty($validated['nama_ayah']) || empty($validated['pekerjaan_ayah']) ||
                empty($validated['nama_ibu']) || empty($validated['pekerjaan_ibu'])) {
                return redirect()->back()
                    ->with('error', 'Data Orang Tua tidak lengkap. Harap isi semua field.')
                    ->withInput();
            }
        } else {
            // Jika pilih wali, pastikan ortu fields benar-benar kosong
            $validated['nama_ayah'] = null;
            $validated['pekerjaan_ayah'] = null;
            $validated['nama_ibu'] = null;
            $validated['pekerjaan_ibu'] = null;
            
            // PENTING: Validasi ketat - pastikan wali fields tidak kosong
            if (empty($validated['nama_wali'])) {
                return redirect()->back()
                    ->with('error', 'Data Wali tidak lengkap. Harap isi semua field.')
                    ->withInput();
            }
        }

        // Simpan ke tabel biodata dengan data yang sudah dibersihkan
        $biodata = Biodata::updateOrCreate(
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
        
        // ✅ PENTING: Sinkronkan foto dari biodata SETIAP KALI ADA UPDATE
        // Jika ada foto baru yang diupload
        if (isset($validated['foto']) && $validated['foto']) {
            $siswa->foto = $validated['foto'];
        }
        // Jika tidak ada foto baru tapi biodata sudah punya foto, gunakan yang ada di biodata
        elseif ($biodata->foto) {
            $siswa->foto = $biodata->foto;
        }
        
        $siswa->save();

        // ✅ Arahkan ke halaman profil (bukan pembayaran)
        return redirect()->route('profil.index')
                 ->with('success', 'Data biodata siswa berhasil disimpan!');
    }
}
