<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Pendaftaran;
use App\Models\BerkasCetak;
use App\Models\JenisBerkas;

class CetakDokumenController extends Controller
{
    /**
     * Display list of documents to print
     */
    public function index()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login');
            }

            // Get pendaftaran - with better relationship loading
            $pendaftaran = Pendaftaran::whereHas('siswa', function ($query) use ($user) {
                $query->where('pengguna_id', $user->id);
            })->with(['siswa', 'pembayaran.statusPembayaran', 'statusPendaftaran'])
            ->first();

            if (!$pendaftaran) {
                Log::warning('No pendaftaran found for user: ' . $user->id);
                return redirect()->route('formulir.index')
                    ->with('warning', 'Daftarkan diri Anda terlebih dahulu');
            }

            $berkasCetak = BerkasCetak::where('pendaftaran_id', $pendaftaran->id)
                ->with('jenisBerkas')
                ->latest()
                ->paginate(10);

            return view('cetak.index', compact('pendaftaran', 'berkasCetak'));
        } catch (\Exception $e) {
            Log::error('Error in CetakDokumenController@index: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
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
                'pendaftaran' => $pendaftaran,
                'siswa' => $pendaftaran->siswa,
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
     * Generate kartu peserta
     */
    public function generateKartuPeserta($pendaftaranId)
    {
        try {
            $user = Auth::user();
            $pendaftaran = Pendaftaran::with(['siswa', 'jurusanPilihan1', 'statusPendaftaran', 'pembayaran.statusPembayaran'])
                ->findOrFail($pendaftaranId);

            // Check authorization
            if ($pendaftaran->siswa->pengguna_id != $user->id && $user->role != 'admin') {
                abort(403, 'Unauthorized');
            }

            // Check if pembayaran sudah lunas
            $pembayaran = $pendaftaran->pembayaran()->with('statusPembayaran')->first();
            if (!$pembayaran || $pembayaran->statusPembayaran->nama != 'LUNAS') {
                return back()->withErrors(['error' => 'Pembayaran belum lunas']);
            }

            $data = [
                'pendaftaran' => $pendaftaran,
                'siswa' => $pendaftaran->siswa,
                'jurusan' => $pendaftaran->jurusanPilihan1,
                'barcode' => 'PPDB-' . $pendaftaran->id . '-' . $pendaftaran->tahun_ajaran,
            ];

            // Save to database
            $jenisBerkas = JenisBerkas::where('nama', 'KARTU_PESERTA')->first();
            if ($jenisBerkas) {
                BerkasCetak::create([
                    'pendaftaran_id' => $pendaftaran->id,
                    'jenis_berkas_id' => $jenisBerkas->id,
                    'path' => 'cetak/kartu-' . $pendaftaran->id . '-' . time() . '.html',
                    'meta' => json_encode(['barcode' => $data['barcode']]),
                    'dibuat_oleh' => $user->id,
                ]);
                
                Log::info('Kartu Peserta generated for pendaftaran ' . $pendaftaran->id);
            }

            // Return HTML view (printable)
            return view('cetak.kartu-peserta-template', $data)
                ->render();
        } catch (\Exception $e) {
            Log::error('Error generating kartu peserta: ' . $e->getMessage(), ['pendaftaran_id' => $pendaftaranId]);
            return redirect()->back()->withErrors(['error' => 'Gagal membuat kartu peserta: ' . $e->getMessage()]);
        }
    }

    /**
     * Generate surat penerimaan (hanya untuk diterima)
     */
    public function generateSuratPenerimaan($pendaftaranId)
    {
        try {
            $user = Auth::user();
            $pendaftaran = Pendaftaran::with(['siswa', 'jurusanPilihan1', 'statusPendaftaran'])
                ->findOrFail($pendaftaranId);

            // Check authorization
            if ($pendaftaran->siswa->pengguna_id != $user->id && $user->role != 'admin') {
                abort(403, 'Unauthorized');
            }

            // Check if status DITERIMA
            if ($pendaftaran->statusPendaftaran->nama != 'DITERIMA') {
                return back()->withErrors(['error' => 'Hanya dapat dicetak untuk status DITERIMA']);
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
     */
    public function generateKuitansi($pembayaranId)
    {
        try {
            $user = Auth::user();
            $pembayaran = \App\Models\Pembayaran::with(['pendaftaran.siswa', 'statusPembayaran', 'metode'])
                ->findOrFail($pembayaranId);

            // Check authorization
            if ($pembayaran->pendaftaran->siswa->pengguna_id != $user->id && $user->role != 'admin') {
                abort(403, 'Unauthorized');
            }

            // Check if LUNAS
            if ($pembayaran->statusPembayaran->nama != 'LUNAS') {
                return back()->withErrors(['error' => 'Kuitansi hanya tersedia untuk pembayaran yang lunas']);
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
