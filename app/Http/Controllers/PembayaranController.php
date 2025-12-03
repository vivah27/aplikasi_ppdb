<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\Gelombang;
use App\Models\MetodePembayaran;
use App\Models\StatusPembayaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PembayaranController extends Controller
{
    public function index()
    {
        $pendaftaran = Pendaftaran::whereHas('siswa', function ($q) {
            $q->where('pengguna_id', Auth::id());
        })->first();

        // Fetch harga dari Gelombang model (realtime), bukan dari Pendaftaran
        if ($pendaftaran) {
            $gelombangData = Gelombang::where('nomor_gelombang', $pendaftaran->gelombang)->first();
            if ($gelombangData) {
                // Update Pendaftaran dengan harga terbaru dari Gelombang
                $pendaftaran->update([
                    'harga_gelombang' => $gelombangData->harga,
                    'jenis_pembayaran' => $gelombangData->jenis_pembayaran,
                    'tujuan_rekening' => $gelombangData->tujuan_rekening,
                ]);
            }
        }

        $pembayaran = null;
        // Cari pembayaran tanpa filter pendaftaran_id karena field tidak ada
        if ($pendaftaran) {
            $pembayaran = Pembayaran::latest()->first();
        }

        $metode = MetodePembayaran::all();
        $status = StatusPembayaran::all();

        return view('user.pembayaran', compact('pendaftaran', 'pembayaran', 'metode', 'status'));
    }

    /**
     * API: Dapatkan harga gelombang
     */
    public function getHargaGelombang($gelombang)
    {
        try {
            // Ambil harga gelombang dari model Gelombang
            $gelombangData = Gelombang::where('nomor_gelombang', $gelombang)->first();

            if (!$gelombangData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gelombang tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'harga' => $gelombangData->harga ?? 0,
                'jenis_pembayaran' => $gelombangData->jenis_pembayaran ?? 'Uang Pendaftaran',
                'tujuan_rekening' => $gelombangData->tujuan_rekening ?? null,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        $pendaftaran = Pendaftaran::whereHas('siswa', function ($q) {
            $q->where('pengguna_id', Auth::id());
        })->first();

        if (!$pendaftaran) {
            return redirect()->route('formulir.index')->with('error', 'Anda belum mengisi formulir pendaftaran.');
        }

        $metode = MetodePembayaran::all();
        $status = StatusPembayaran::all();

        return view('user.pembayaran.create', compact('pendaftaran', 'metode', 'status'));
    }

    public function store(Request $request)
    {
        // Validasi berdasarkan metode pembayaran
        $metodeId = $request->metode_id;
        $metode = MetodePembayaran::findOrFail($metodeId);
        $kodeMetode = $metode->kode;
        
        // Rules dasar
        $baseRules = [
            'metode_id' => 'required|exists:metode_pembayarans,id',
            'bukti' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'keterangan' => 'nullable|string|max:500',
        ];
        
        // Rules tambahan berdasarkan metode
        if ($kodeMetode === 'transfer_bank') {
            $baseRules['nama_bank'] = 'required|string|max:100';
            $baseRules['nomor_rekening'] = 'required|numeric|regex:/^[0-9]{8,20}$/';
            $baseRules['atas_nama_rekening'] = 'required|string|max:100';
        } elseif ($kodeMetode === 'e_wallet') {
            $baseRules['jenis_ewallet'] = 'required|string|max:50';
            $baseRules['nomor_ewallet'] = 'required|numeric|regex:/^[0-9]{8,15}$/';
        }
        
        $validatedData = $request->validate($baseRules, [
            'nama_bank.required' => 'Nama bank harus diisi',
            'nomor_rekening.required' => 'Nomor rekening harus diisi',
            'nomor_rekening.numeric' => 'Nomor rekening hanya boleh berisi angka',
            'nomor_rekening.regex' => 'Nomor rekening harus berisi 8-20 digit angka',
            'atas_nama_rekening.required' => 'Nama pemilik rekening harus diisi',
            'jenis_ewallet.required' => 'Jenis e-wallet harus diisi',
            'nomor_ewallet.required' => 'Nomor e-wallet harus diisi',
            'nomor_ewallet.numeric' => 'Nomor e-wallet hanya boleh berisi angka',
            'nomor_ewallet.regex' => 'Nomor e-wallet harus berisi 8-15 digit angka',
        ]);

        $pendaftaran = Pendaftaran::whereHas('siswa', function ($q) {
            $q->where('pengguna_id', Auth::id());
        })->first();

        if (!$pendaftaran) {
            return redirect()->back()->with('error', 'Anda belum mengisi formulir pendaftaran.');
        }

        // Validasi bahwa harga_gelombang sudah diatur oleh admin
        if (!$pendaftaran->harga_gelombang || $pendaftaran->harga_gelombang <= 0) {
            return redirect()->back()->with('error', 'Harga gelombang belum ditentukan admin. Hubungi admin untuk mengatur harga.');
        }

        $metodeNama = $metode->label ?? $metode->nama ?? 'Transfer Bank';

        // Persiapkan data untuk disimpan
        $data = [
            'pendaftaran_id' => $pendaftaran->id,
            'metode_pembayaran_id' => $metodeId,
            'nama' => 'Pembayaran Pendaftaran - ' . $pendaftaran->id,
            'metode' => $metodeNama,
            'jumlah' => $pendaftaran->harga_gelombang,
            'status' => 'Menunggu Verifikasi',
            'catatan' => $request->keterangan ?? null,
            'tanggal_bayar' => Carbon::now(),
        ];
        
        // Tambahkan detail transfer/ewallet sesuai metode
        if ($kodeMetode === 'transfer_bank') {
            $data['nama_bank'] = $request->nama_bank;
            $data['nomor_rekening'] = $request->nomor_rekening;
            $data['atas_nama_rekening'] = $request->atas_nama_rekening;
        } elseif ($kodeMetode === 'e_wallet') {
            $data['jenis_ewallet'] = $request->jenis_ewallet;
            $data['nomor_ewallet'] = $request->nomor_ewallet;
        }

        // Handle file upload
        if ($request->hasFile('bukti')) {
            try {
                $data['bukti'] = $request->file('bukti')->store('uploads/bukti', 'public');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengupload file. Silakan coba lagi.');
            }
        }

        try {
            Pembayaran::create($data);
            return redirect()->route('user.pembayaran.index')->with('success', 'Pembayaran berhasil dikirim. Menunggu verifikasi admin.');
        } catch (\Exception $e) {
            Log::error('Pembayaran Error: ' . $e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
            Log::error('Pembayaran Data: ' . json_encode($data));
            return redirect()->back()->with('error', 'Gagal menyimpan pembayaran. Error: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail pembayaran
     */
    public function show($id)
    {
        try {
            $pembayaran = Pembayaran::findOrFail($id);
            
            // Check authorization - user hanya bisa lihat pembayaran milik mereka
            $pendaftaran = $pembayaran->pendaftaran;
            if (!$pendaftaran || !$pendaftaran->siswa || $pendaftaran->siswa->pengguna_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pembayaran ini.');
            }

            $metode = MetodePembayaran::all();
            $status = StatusPembayaran::all();

            return view('user.pembayaran.show', compact('pembayaran', 'metode', 'status'));
        } catch (\Exception $e) {
            Log::error('Pembayaran Show Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Pembayaran tidak ditemukan.');
        }
    }

    /**
     * Update pembayaran (hanya jika masih menunggu verifikasi)
     */
    public function update(Request $request, $id)
    {
        try {
            $pembayaran = Pembayaran::findOrFail($id);
            
            // Check authorization
            $pendaftaran = $pembayaran->pendaftaran;
            if (!$pendaftaran || !$pendaftaran->siswa || $pendaftaran->siswa->pengguna_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pembayaran ini.');
            }

            // Cek apakah pembayaran masih dalam status menunggu verifikasi
            if ($pembayaran->status !== 'Menunggu Verifikasi' && 
                (!$pembayaran->statusPembayaran || strtoupper($pembayaran->statusPembayaran->nama) !== 'MENUNGGU_VERIFIKASI')) {
                return redirect()->back()->with('error', 'Hanya pembayaran yang menunggu verifikasi yang dapat diperbarui.');
            }

            // Validasi input
            $validatedData = $request->validate([
                'bukti' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
                'keterangan' => 'nullable|string|max:500',
            ]);

            // Update data
            if ($request->hasFile('bukti')) {
                // Hapus file lama jika ada
                if ($pembayaran->bukti) {
                    Storage::disk('public')->delete($pembayaran->bukti);
                }
                $pembayaran->bukti = $request->file('bukti')->store('uploads/bukti', 'public');
            }

            if ($request->filled('keterangan')) {
                $pembayaran->catatan = $request->keterangan;
            }

            $pembayaran->save();

            return redirect()->back()->with('success', 'Pembayaran berhasil diperbarui. Menunggu verifikasi admin.');
        } catch (\Exception $e) {
            Log::error('Pembayaran Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui pembayaran. Silakan coba lagi.');
        }
    }

    /**
     * Hapus pembayaran (hanya jika masih menunggu verifikasi)
     */
    public function destroy($id)
    {
        try {
            $pembayaran = Pembayaran::findOrFail($id);
            
            // Check authorization
            $pendaftaran = $pembayaran->pendaftaran;
            if (!$pendaftaran || !$pendaftaran->siswa || $pendaftaran->siswa->pengguna_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pembayaran ini.');
            }

            // Cek apakah pembayaran masih dalam status menunggu verifikasi
            if ($pembayaran->status !== 'Menunggu Verifikasi' && 
                (!$pembayaran->statusPembayaran || strtoupper($pembayaran->statusPembayaran->nama) !== 'MENUNGGU_VERIFIKASI')) {
                return redirect()->back()->with('error', 'Hanya pembayaran yang menunggu verifikasi yang dapat dihapus.');
            }

            // Hapus file bukti jika ada
            if ($pembayaran->bukti) {
                Storage::disk('public')->delete($pembayaran->bukti);
            }

            $pembayaran->delete();

            return redirect()->back()->with('success', 'Pembayaran berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Pembayaran Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus pembayaran. Silakan coba lagi.');
        }
    }
}
