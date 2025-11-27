<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\JenisDokumen;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Models\DokumenAccessLog;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // Get or create siswa record
        $siswa = Siswa::firstOrCreate(
            ['pengguna_id' => $user->id],
            ['nama_lengkap' => $user->name, 'email' => $user->email]
        );
        
        $dokumen = Dokumen::where('siswa_id', $siswa->id)
            ->with('jenisDokumen', 'statusVerifikasi')
            ->paginate(10);
        
        // Get all jenis dokumen for filters
        $jenisDokumen = JenisDokumen::all();
        
        return view('user.dokumen.index', compact('dokumen', 'siswa', 'jenisDokumen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        
        // Get or create siswa record
        $siswa = Siswa::firstOrCreate(
            ['pengguna_id' => $user->id],
            ['nama_lengkap' => $user->name, 'email' => $user->email]
        );
        
        // Get all jenis dokumen
        $allJenisDokumen = JenisDokumen::all();
        
        // Get jenis dokumen that already have been uploaded by this siswa
        $uploadedJenisDokumenIds = Dokumen::where('siswa_id', $siswa->id)
            ->pluck('jenis_dokumen_id')
            ->toArray();
        
        // Filter to only show jenis dokumen that haven't been uploaded yet
        $jenisDokumen = $allJenisDokumen->filter(function($item) use ($uploadedJenisDokumenIds) {
            return !in_array($item->id, $uploadedJenisDokumenIds);
        })->values();
        
        return view('user.dokumen.create', compact('jenisDokumen', 'allJenisDokumen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_dokumen_id' => 'required|exists:jenis_dokumens,id',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
        ]);

        $user = Auth::user();
        $siswa = Siswa::where('pengguna_id', $user->id)->firstOrFail();

        // Check if this jenis dokumen has already been uploaded by this siswa
        $existingDokumen = Dokumen::where('siswa_id', $siswa->id)
            ->where('jenis_dokumen_id', $validated['jenis_dokumen_id'])
            ->first();
        
        if ($existingDokumen) {
            return back()->withErrors(['jenis_dokumen_id' => 'Dokumen jenis ini sudah pernah diupload. Anda hanya dapat mengupload setiap jenis dokumen 1 kali saja.']);
        }

        $file = $request->file('file');

        // Additional hardening checks beyond the basic validator:
        $allowedExt = ['pdf', 'jpg', 'jpeg', 'png'];
        $allowedMime = ['application/pdf', 'image/jpeg', 'image/png'];

        $originalName = $file->getClientOriginalName();
        $ext = strtolower($file->getClientOriginalExtension() ?? '');

        // Reject suspicious double-extension uploads like "file.php.pdf"
        if (preg_match('/\.[^\.]+\.[^\.]+$/', $originalName)) {
            return back()->withErrors(['file' => 'Nama file mengandung ekstensi ganda yang tidak diperbolehkan.']);
        }

        if (!in_array($ext, $allowedExt)) {
            return back()->withErrors(['file' => 'Jenis file tidak diperbolehkan. Gunakan: pdf, jpg, jpeg, png.']);
        }

        $mime = $file->getMimeType();
        if (!in_array($mime, $allowedMime)) {
            return back()->withErrors(['file' => 'Tipe file tidak valid atau tidak dikenali.']);
        }

        // Map MIME to expected extensions and allow similar variants
        $mimeMap = [
            'application/pdf' => ['pdf'],
            'image/jpeg' => ['jpg', 'jpeg'],
            'image/png' => ['png'],
        ];

        $expectedExts = $mimeMap[$mime] ?? [];
        if (!in_array($ext, $expectedExts)) {
            return back()->withErrors(['file' => 'Ekstensi file tidak cocok dengan tipe konten.']);
        }

        // Store uploads in private disk (local) to avoid direct public exposure.
        // Path will be like: dokumen/{siswa_id}/filename.ext
        $path = $file->store('dokumen/' . $siswa->id, 'local');

        Dokumen::create([
            'siswa_id' => $siswa->id,
            'jenis_dokumen_id' => $validated['jenis_dokumen_id'],
            'path' => $path,
            'dibuat_oleh' => $user->id,
        ]);

        return redirect()->route('user.dokumen')
            ->with('success', 'Dokumen berhasil diunggah');
    }

    /**
     * Download the specified resource.
     */
    public function download(Dokumen $dokumen)
    {
        // Check authorization
        $user = Auth::user();
        $siswa = Siswa::where('pengguna_id', $user->id)->firstOrFail();

        if ($dokumen->siswa_id !== $siswa->id) {
            abort(403, 'Unauthorized');
        }

        // Log access attempt
        DokumenAccessLog::create([
            'dokumen_id' => $dokumen->id,
            'pengguna_id' => $user->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'method' => request()->method(),
        ]);

        // Prefer private storage (local). If not found there, fall back to public disk
        if (Storage::disk('local')->exists($dokumen->path)) {
            $full = Storage::disk('local')->path($dokumen->path);
            return response()->download($full, basename($dokumen->path));
        }

        if (Storage::disk('public')->exists($dokumen->path)) {
            $full = Storage::disk('public')->path($dokumen->path);
            return response()->download($full, basename($dokumen->path));
        }

        return back()->with('error', 'File tidak ditemukan atau sudah dihapus');
    }

    /**
     * Generate a signed, temporary download URL for admin sharing.
     * URL valid for X minutes, configurable via query or default 60 minutes.
     */
    public function signedUrl(Request $request, Dokumen $dokumen)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403);
        }

        $minutes = (int) $request->query('minutes', 60);

        $url = URL::signedRoute('dokumen.signed.download', ['dokumen' => $dokumen->id], now()->addMinutes($minutes));

        return response()->json(['url' => $url, 'expires_in_minutes' => $minutes]);
    }

    /**
     * Handle signed download route.
     */
    public function signedDownload(Request $request, Dokumen $dokumen)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Invalid or expired link');
        }

        // Log access (anonymous or unauthenticated possible)
        DokumenAccessLog::create([
            'dokumen_id' => $dokumen->id,
            'pengguna_id' => Auth::check() ? Auth::id() : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'method' => request()->method(),
        ]);

        if (Storage::disk('local')->exists($dokumen->path)) {
            $full = Storage::disk('local')->path($dokumen->path);
            return response()->download($full, basename($dokumen->path));
        }

        if (Storage::disk('public')->exists($dokumen->path)) {
            $full = Storage::disk('public')->path($dokumen->path);
            return response()->download($full, basename($dokumen->path));
        }

        abort(404, 'File not found');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokumen $dokumen)
    {
        $user = Auth::user();
        $siswa = Siswa::where('pengguna_id', $user->id)->firstOrFail();

        if ($dokumen->siswa_id !== $siswa->id) {
            abort(403, 'Unauthorized');
        }

        // Delete from whichever disk contains the file
        if (Storage::disk('local')->exists($dokumen->path)) {
            Storage::disk('local')->delete($dokumen->path);
        } elseif (Storage::disk('public')->exists($dokumen->path)) {
            Storage::disk('public')->delete($dokumen->path);
        }

        $dokumen->delete();

        return redirect()->route('user.dokumen')
            ->with('success', 'Dokumen berhasil dihapus');
    }
}
