<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Pendaftaran;
use App\Models\BerkasCetak;
use App\Models\JenisBerkas;
use App\Models\Jurusan;

class CetakDokumenController extends Controller
{
    /**
     * Display list of kuitansi that can be printed
     */
    public function kuitansiIndex()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login');
            }

            // Get pendaftaran
            $pendaftaran = Pendaftaran::whereHas('siswa', function ($query) use ($user) {
                $query->where('pengguna_id', $user->id);
            })->with(['siswa', 'pembayaran.statusPembayaran'])
            ->first();

            if (!$pendaftaran) {
                return redirect()->route('formulir.index')
                    ->with('warning', 'Daftarkan diri Anda terlebih dahulu');
            }

            // Get pembayaran yang sudah terverifikasi
            $pembayaranTerverifikasi = $pendaftaran->pembayaran()
                ->where(function($query) {
                    $query->where('status', 'Terverifikasi')
                          ->orWhere('status', 'LUNAS')
                          ->orWhereHas('statusPembayaran', function($q) {
                              $q->whereIn('nama', ['LUNAS', 'Terverifikasi']);
                          });
                })
                ->with('metodePembayaran')
                ->get();

            return view('cetak.kuitansi', compact('pendaftaran', 'pembayaranTerverifikasi'));
        } catch (\Exception $e) {
            Log::error('Error in CetakDokumenController@kuitansiIndex: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the main cetak dokumen page
     */
    public function index()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login');
            }

            // Get pendaftaran
            $pendaftaran = Pendaftaran::whereHas('siswa', function ($query) use ($user) {
                $query->where('pengguna_id', $user->id);
            })->with(['siswa', 'pembayaran.statusPembayaran'])
            ->first();

            // Get berkas cetak history
            $berkasCetak = BerkasCetak::where('user_id', $user->id)
                ->with('jenisBerkas')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('cetak.index', compact('pendaftaran', 'berkasCetak'));
        } catch (\Exception $e) {
            Log::error('Error in CetakDokumenController@index: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Generate formulir PDF
     */
    public function generateFormulir($pendaftaranId)
    {
        try {
            $user = Auth::user();
            $pendaftaran = Pendaftaran::with(['siswa', 'jurusanPilihan1', 'jurusanPilihan2', 'statusPendaftaran'])
                ->findOrFail($pendaftaranId);

            // Check authorization
            if ($pendaftaran->siswa->pengguna_id != $user->id && $user->role != 'admin') {
                abort(403, 'Unauthorized');
            }

            $data = [
                'jurusan1' => $pendaftaran->jurusanPilihan1,
                'jurusan2' => $pendaftaran->jurusanPilihan2,
            ];

            // Save to database
            $jenisBerkas = JenisBerkas::where('nama', 'FORMULIR')->first();
            if ($jenisBerkas) {
                BerkasCetak::create([
                    'pendaftaran_id' => $pendaftaran->id,
                    'jenis_berkas_id' => $jenisBerkas->id,
                    'path' => 'cetak/formulir-' . $pendaftaran->id . '-' . time() . '.html',
                    'meta' => json_encode(['nama' => $pendaftaran->siswa->nama_lengkap]),
                    'dibuat_oleh' => $user->id,
                ]);
                
                Log::info('Formulir generated for pendaftaran ' . $pendaftaran->id);
            }

            // Return HTML view (printable)
            return view('cetak.formulir-template', $data)
                ->render();
        } catch (\Exception $e) {
            Log::error('Error generating formulir: ' . $e->getMessage(), ['pendaftaran_id' => $pendaftaranId]);
            return redirect()->back()->withErrors(['error' => 'Gagal membuat formulir: ' . $e->getMessage()]);
        }
    }

    /**
     * Generate surat penerimaan
     *
     * Syarat: Status DITERIMA dan Pembayaran LUNAS/TERVERIFIKASI
     */
    public function generateSuratPenerimaan($pendaftaranId)
    {
        try {
            $user = Auth::user();
            $pendaftaran = Pendaftaran::with(['siswa', 'jurusanPilihan1', 'statusPendaftaran', 'pembayaran'])
                ->findOrFail($pendaftaranId);

            // Check authorization
            if ($pendaftaran->siswa->pengguna_id != $user->id && $user->role != 'admin') {
                abort(403, 'Unauthorized');
            }

            // Check if status DITERIMA
            if (!$pendaftaran->statusPendaftaran || strtoupper($pendaftaran->statusPendaftaran->label) !== 'DITERIMA') {
                $statusName = $pendaftaran->statusPendaftaran ? $pendaftaran->statusPendaftaran->label : 'BELUM DIVERIFIKASI';
                return back()->withErrors(['error' => 'Hanya dapat dicetak untuk status DITERIMA. Status saat ini: ' . $statusName]);
            }

            // Check if jurusan sudah dipilih
            if (!$pendaftaran->jurusanPilihan1) {
                return back()->withErrors(['error' => 'Pilihan jurusan belum dipilih']);
            }

            // Check if pembayaran sudah terverifikasi dan lunas
            $pembayaran = $pendaftaran->pembayaran;
            
            if (!$pembayaran) {
                return back()->withErrors(['error' => 'Pembayaran belum dibuat']);
            }

            // Check status pembayaran - admin verifikasi set status = "Terverifikasi"
            if (!$pembayaran->isTerverifikasi()) {
                $currentStatus = $pembayaran->status ?? 'MENUNGGU VERIFIKASI';
                return back()->withErrors(['error' => 'Pembayaran belum terverifikasi oleh admin. Status: ' . strtoupper(trim($currentStatus))]);
            }

            $data = [
                'pendaftaran' => $pendaftaran,
                'siswa' => $pendaftaran->siswa,
                'jurusan' => $pendaftaran->jurusanPilihan1,
                'tanggal' => now()->format('d F Y'),
            ];

            // Save to database
            $jenisBerkas = JenisBerkas::where('nama', 'SURAT_PENERIMAAN')->first();
            if ($jenisBerkas) {
                BerkasCetak::create([
                    'pendaftaran_id' => $pendaftaran->id,
                    'jenis_berkas_id' => $jenisBerkas->id,
                    'path' => 'cetak/surat-' . $pendaftaran->id . '-' . time() . '.html',
                    'meta' => json_encode(['jurusan' => $pendaftaran->jurusanPilihan1->nama]),
                    'dibuat_oleh' => $user->id,
                ]);
                
                Log::info('Surat Penerimaan generated for pendaftaran ' . $pendaftaran->id);
            }

            // Return HTML view (printable)
            return view('cetak.surat-penerimaan-template', $data)
                ->render();
        } catch (\Exception $e) {
            Log::error('Error generating surat penerimaan: ' . $e->getMessage(), ['pendaftaran_id' => $pendaftaranId]);
            return redirect()->back()->withErrors(['error' => 'Gagal membuat surat penerimaan: ' . $e->getMessage()]);
        }
    }

    /**
     * Generate kuitansi pembayaran
     * 
     * Syarat: Pembayaran LUNAS/TERVERIFIKASI oleh admin
     */
    public function generateKuitansi($pembayaranId)
    {
        try {
            $user = Auth::user();
            $pembayaran = \App\Models\Pembayaran::with(['pendaftaran.siswa', 'metodePembayaran', 'statusPembayaran'])
                ->findOrFail($pembayaranId);

            // Check authorization
            if ($pembayaran->pendaftaran->siswa->pengguna_id != $user->id && $user->role != 'admin') {
                abort(403, 'Unauthorized');
            }

            // Check if pembayaran sudah terverifikasi dan lunas
            if (!$pembayaran->isTerverifikasi()) {
                $currentStatus = $pembayaran->status ?? 'MENUNGGU VERIFIKASI';
                return back()->withErrors(['error' => 'Kuitansi hanya tersedia untuk pembayaran yang terverifikasi. Status: ' . strtoupper(trim($currentStatus))]);
            }

            $data = [
                'pembayaran' => $pembayaran,
                'siswa' => $pembayaran->pendaftaran->siswa,
                'tanggal' => now()->format('d F Y'),
            ];

            // Save to database
            $jenisBerkas = JenisBerkas::where('nama', 'KUITANSI')->first();
            if ($jenisBerkas) {
                BerkasCetak::create([
                    'pendaftaran_id' => $pembayaran->pendaftaran_id,
                    'jenis_berkas_id' => $jenisBerkas->id,
                    'path' => 'cetak/kuitansi-' . $pembayaran->id . '-' . time() . '.html',
                    'meta' => json_encode(['jumlah' => $pembayaran->jumlah]),
                    'dibuat_oleh' => $user->id,
                ]);
                
                Log::info('Kuitansi generated for pembayaran ' . $pembayaran->id);
            }

            // Return HTML view (printable)
            return view('cetak.kuitansi-template', $data)
                ->render();
        } catch (\Exception $e) {
            Log::error('Error generating kuitansi PDF: ' . $e->getMessage(), ['pembayaran_id' => $pembayaranId]);
            return redirect()->back()->withErrors(['error' => 'Gagal membuat kuitansi: ' . $e->getMessage()]);
        }
    }

    /**
     * Download existing berkas
     */
    public function download($id)
    {
        try {
            $user = Auth::user();
            $berkas = BerkasCetak::with('pendaftaran.siswa')->findOrFail($id);

            // Check authorization
            if ($berkas->pendaftaran->siswa->pengguna_id != $user->id && $user->role != 'admin') {
                abort(403, 'Unauthorized');
            }

            $filePath = storage_path('app/' . $berkas->path);
            if (!file_exists($filePath)) {
                Log::warning('File not found: ' . $filePath);
                return redirect()->back()->withErrors(['error' => 'File tidak ditemukan']);
            }

            Log::info('File downloaded: ' . $berkas->path);
            return response()->download($filePath);
        } catch (\Exception $e) {
            Log::error('Error downloading file: ' . $e->getMessage(), ['berkas_id' => $id]);
            return redirect()->back()->withErrors(['error' => 'Gagal mengunduh file: ' . $e->getMessage()]);
        }
    }
}
