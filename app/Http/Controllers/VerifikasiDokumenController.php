<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Pendaftaran;
use App\Models\StatusVerifikasi;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VerifikasiDokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Group dokumen per siswa
        $siswa = \App\Models\Siswa::with(['dokumen' => function($query) {
            $query->with('jenisDokumen', 'statusVerifikasi');
        }])
        ->whereHas('dokumen')
        ->paginate(15);
        
        return view('admin.verifikasi.index', compact('siswa'));
    }

    /**
     * Quickly accept (verify) a document with one click.
     */
    public function acceptDokumen(Dokumen $dokumen)
    {
        $user = Auth::user();

        // Ensure the 'verified' status exists (create fallback if missing)
        $status = StatusVerifikasi::firstOrCreate(
            ['kode' => 'verified'],
            ['label' => 'Terverifikasi']
        );

        $dokumen->update([
            'status_verifikasi_id' => $status->id,
            'diperbarui_oleh' => $user->id,
        ]);

        if ($dokumen->siswa && $dokumen->siswa->pendaftaran()->exists()) {
            $pendaftaran = $dokumen->siswa->pendaftaran()->first();

            Verifikasi::create([
                'pendaftaran_id' => $pendaftaran->id,
                'admin_id' => $user->id,
                'tipe' => 'dokumen',
                'catatan' => 'Diverifikasi (quick action)',
                'status_id' => $status->id,
                'tanggal_verifikasi' => now(),
            ]);
        }

        // Always return JSON for consistency (AJAX + form requests)
        return response()->json(['success' => true, 'message' => 'Dokumen berhasil diverifikasi'], 200);
    }

    /**
     * Quickly reject a document with one click.
     */
    public function rejectDokumen(Request $request, Dokumen $dokumen)
    {
        $user = Auth::user();

        // Ensure the 'rejected' status exists (create fallback if missing)
        $status = StatusVerifikasi::firstOrCreate(
            ['kode' => 'rejected'],
            ['label' => 'Ditolak']
        );

        $dokumen->update([
            'status_verifikasi_id' => $status->id,
            'catatan' => $request->input('catatan', 'Ditolak (quick action)'),
            'diperbarui_oleh' => $user->id,
        ]);

        if ($dokumen->siswa && $dokumen->siswa->pendaftaran()->exists()) {
            $pendaftaran = $dokumen->siswa->pendaftaran()->first();

            Verifikasi::create([
                'pendaftaran_id' => $pendaftaran->id,
                'admin_id' => $user->id,
                'tipe' => 'dokumen',
                'catatan' => $request->input('catatan', 'Ditolak (quick action)'),
                'status_id' => $status->id,
                'tanggal_verifikasi' => now(),
            ]);
        }

        // Always return JSON for consistency (AJAX + form requests)
        return response()->json(['success' => true, 'message' => 'Dokumen berhasil ditolak'], 200);
    }

    /**
     * Show the form for verifying a document.
     */
    public function edit(Dokumen $dokumen)
    {
        $statusVerifikasi = StatusVerifikasi::all();
        return view('admin.verifikasi.edit', compact('dokumen', 'statusVerifikasi'));
    }

    /**
     * Show all documents for a specific student
     */
    public function showSiswa(\App\Models\Siswa $siswa)
    {
        $dokumen = $siswa->dokumen()->with('jenisDokumen', 'statusVerifikasi')->get();
        $statusVerifikasi = StatusVerifikasi::all();
        
        return view('admin.verifikasi.siswa', compact('siswa', 'dokumen', 'statusVerifikasi'));
    }

    /**
     * Preview dokumen (support PDF dan image)
     */
    public function preview(Dokumen $dokumen)
    {
        // Check authorization - only admin can preview
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Get file from private storage
        if (! Storage::disk('local')->exists($dokumen->path)) {
            abort(404, 'File tidak ditemukan');
        }

        $filePath = Storage::disk('local')->path($dokumen->path);
        
        // Get mime type using finfo_file
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath) ?: 'application/octet-stream';
        finfo_close($finfo);

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"',
        ]);
    }

    /**
     * Update verification status.
     */
    public function update(Request $request, Dokumen $dokumen)
    {
        $validated = $request->validate([
            'status_verifikasi_id' => 'required|exists:status_verifikasis,id',
            'catatan' => 'nullable|string',
        ]);

        $user = Auth::user();
        
        $dokumen->update([
            'status_verifikasi_id' => $validated['status_verifikasi_id'],
            'catatan' => $validated['catatan'],
            'diperbarui_oleh' => $user->id,
        ]);

        // Record verification activity
        if ($dokumen->siswa && $dokumen->siswa->pendaftaran()->exists()) {
            $pendaftaran = $dokumen->siswa->pendaftaran()->first();
            
            Verifikasi::create([
                'pendaftaran_id' => $pendaftaran->id,
                'admin_id' => $user->id,
                'tipe' => 'dokumen',
                'catatan' => $validated['catatan'],
                'status_id' => $validated['status_verifikasi_id'],
                'tanggal_verifikasi' => now(),
            ]);
        }

        return redirect()->route('admin.verifikasi')
            ->with('success', 'Verifikasi dokumen berhasil disimpan');
    }

    /**
     * Accept (approve) registration.
     */
    public function acceptRegistration(Pendaftaran $pendaftaran)
    {
        $user = Auth::user();

        // Ensure the StatusPendaftaran 'diterima' exists (create fallback if missing)
        $status = \App\Models\StatusPendaftaran::firstOrCreate(
            ['kode' => 'diterima'],
            ['label' => 'Diterima']
        );

        $pendaftaran->update([
            'status_id' => $status->id,
            'diperbarui_oleh' => $user->id,
        ]);

        // Record verification activity
        Verifikasi::create([
            'pendaftaran_id' => $pendaftaran->id,
            'admin_id' => $user->id,
            'tipe' => 'pendaftaran',
            'catatan' => 'Siswa diterima dan dapat melanjutkan ke pembayaran',
            'status_id' => $status->id,
            'tanggal_verifikasi' => now(),
        ]);

        return back()->with('success', 'Siswa berhasil diterima');
    }

    /**
     * Reject (decline) registration.
     */
    public function rejectRegistration(Request $request, Pendaftaran $pendaftaran)
    {
        $validated = $request->validate([
            'catatan' => 'nullable|string',
        ]);

        $user = Auth::user();

        // Ensure the StatusPendaftaran 'ditolak' exists (create fallback if missing)
        $status = \App\Models\StatusPendaftaran::firstOrCreate(
            ['kode' => 'ditolak'],
            ['label' => 'Ditolak']
        );

        $pendaftaran->update([
            'status_id' => $status->id,
            'diperbarui_oleh' => $user->id,
        ]);

        // Record verification activity
        Verifikasi::create([
            'pendaftaran_id' => $pendaftaran->id,
            'admin_id' => $user->id,
            'tipe' => 'pendaftaran',
            'catatan' => $validated['catatan'] ?? 'Siswa ditolak oleh admin',
            'status_id' => $status->id,
            'tanggal_verifikasi' => now(),
        ]);

        return back()->with('success', 'Siswa berhasil ditolak');
    }
}
