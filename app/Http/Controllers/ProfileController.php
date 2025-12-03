<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Biodata;
use App\Models\Pendaftaran;
use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $siswa = Siswa::where('pengguna_id', $user->id)->first();
        $biodata = Biodata::where('user_id', $user->id)->first();
        
        // ✅ Sinkronkan foto dari biodata ke siswa jika ada perbedaan
        // Ini memastikan bahwa foto di siswa selalu up-to-date dengan biodata
        if ($biodata && $biodata->foto) {
            if (!$siswa) {
                // Jika belum ada siswa, buat yang baru
                $siswa = new Siswa();
                $siswa->pengguna_id = $user->id;
                $siswa->foto = $biodata->foto;
                $siswa->save();
            } elseif ($siswa->foto !== $biodata->foto) {
                // Jika foto berbeda, update foto siswa dengan foto biodata
                $siswa->foto = $biodata->foto;
                $siswa->save();
            }
        }
        
        // Debug logging
        Log::info('ProfileController@index', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'siswa_found' => $siswa ? true : false,
            'biodata_found' => $biodata ? true : false,
            'biodata_foto' => $biodata ? $biodata->foto : null,
            'siswa_foto' => $siswa ? $siswa->foto : null,
        ]);
        
        $pendaftaran = null;
        if ($siswa) {
            $pendaftaran = $siswa->pendaftaran()->first();
        }

        $jurusans = Jurusan::all();

        return view('myprofile', compact('user', 'siswa', 'biodata', 'pendaftaran', 'jurusans'));
    }

    /**
     * Show change password form for authenticated user.
     */
    public function showChangePasswordForm()
    {
        return view('auth.change_password');
    }

    /**
     * Handle change password request for authenticated user.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak cocok'])->withInput();
        }

        User::where('id', $user->id)->update([
            'password' => Hash::make($request->input('password'))
        ]);

        return redirect()->route('profil.index')->with('success', 'Password berhasil diperbarui');
    }

    /**
     * Show edit profile form.
     */
    public function edit()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $siswa = Siswa::where('pengguna_id', $user->id)->first();
        $biodata = Biodata::where('user_id', $user->id)->first();
        $jurusans = Jurusan::all();

        return view('profil.edit', compact('user', 'siswa', 'biodata', 'jurusans'));
    }

    /**
     * Update profile data.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'nama_lengkap' => 'nullable|string|max:255',
            'nisn' => 'nullable|string|max:20',
            'nik' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan,L,P',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'asal_sekolah' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
        ]);

        // Get or create siswa record
        $siswa = Siswa::where('pengguna_id', $user->id)->first();
        
        if (!$siswa) {
            $siswa = new Siswa();
            $siswa->pengguna_id = $user->id;
        }

        // Update siswa data
        if ($request->has('nama_lengkap')) {
            $siswa->nama_lengkap = $request->input('nama_lengkap');
        }
        if ($request->has('nisn')) {
            $siswa->nisn = $request->input('nisn');
        }
        if ($request->has('nik')) {
            $siswa->nik = $request->input('nik');
        }
        if ($request->has('tempat_lahir')) {
            $siswa->tempat_lahir = $request->input('tempat_lahir');
        }
        if ($request->has('tanggal_lahir')) {
            $siswa->tanggal_lahir = $request->input('tanggal_lahir');
        }
        if ($request->has('jenis_kelamin')) {
            $jk = $request->input('jenis_kelamin');
            // Convert Laki-laki/Perempuan to L/P if needed
            $jk = $jk === 'Laki-laki' ? 'L' : ($jk === 'Perempuan' ? 'P' : $jk);
            $siswa->jenis_kelamin = $jk;
        }
        if ($request->has('no_telepon')) {
            $siswa->no_telepon = $request->input('no_telepon');
        }
        if ($request->has('alamat')) {
            $siswa->alamat = $request->input('alamat');
        }
        if ($request->has('asal_sekolah')) {
            $siswa->asal_sekolah = $request->input('asal_sekolah');
        }
        if ($request->has('bio')) {
            $siswa->bio = $request->input('bio');
        }
        
        $siswa->save();

        return redirect()->route('profil.index')->with('success', 'Profil berhasil diperbarui');
    }
}
