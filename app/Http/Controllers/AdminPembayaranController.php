<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPembayaranController extends Controller
{
    /**
     * Daftar semua pembayaran dengan filter
     */
    public function index(Request $request)
    {
        $query = Pembayaran::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by metode
        if ($request->filled('metode')) {
            $query->where('metode', $request->metode);
        }

        // Search by nama or metode
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('metode', 'like', "%$search%")
                  ->orWhere('nama_bank', 'like', "%$search%")
                  ->orWhere('jenis_ewallet', 'like', "%$search%");
            });
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        // Get pembayaran dengan pagination
        $pembayarans = $query->with('pendaftaran.siswa')
                             ->orderBy('created_at', 'desc')
                             ->paginate(20)
                             ->appends($request->query());

        // Get status summary
        $statusSummary = [
            'Menunggu Verifikasi' => Pembayaran::where('status', 'Menunggu Verifikasi')->count(),
            'Terverifikasi' => Pembayaran::where('status', 'Terverifikasi')->count(),
            'Ditolak' => Pembayaran::where('status', 'Ditolak')->count(),
        ];

        // Get metode pembayaran summary
        $metodeSummary = Pembayaran::select('metode', DB::raw('COUNT(*) as total'))
                                   ->groupBy('metode')
                                   ->get();

        return view('admin.pembayaran.index', compact('pembayarans', 'statusSummary', 'metodeSummary'));
    }

    /**
     * Detail pembayaran
     */
    public function show(Pembayaran $pembayaran)
    {
        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    /**
     * Form verifikasi pembayaran
     */
    public function edit(Pembayaran $pembayaran)
    {
        return view('admin.pembayaran.edit', compact('pembayaran'));
    }

    /**
     * Update status pembayaran (verifikasi)
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'status' => 'required|in:Terverifikasi,Ditolak',
            'catatan' => 'nullable|string|max:500',
        ]);

        try {
            $pembayaran->update([
                'status' => $request->status,
                'catatan' => $request->catatan ?? $pembayaran->catatan,
            ]);

            $statusLabel = $request->status === 'Terverifikasi' ? 'Diterima' : 'Ditolak';
            
            return redirect()->route('admin.pembayaran.index')
                           ->with('success', "Pembayaran berhasil di-{$statusLabel}");
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal memperbarui status pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Verify pembayaran (quick action)
     */
    public function verify(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'status' => 'required|in:Terverifikasi,Ditolak',
        ]);

        try {
            $pembayaran->update(['status' => $request->status]);
            
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diverifikasi',
                'status' => $pembayaran->status,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memverifikasi pembayaran: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete pembayaran
     */
    public function destroy(Pembayaran $pembayaran)
    {
        try {
            // Hapus file bukti jika ada
            if ($pembayaran->bukti) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($pembayaran->bukti);
            }
            
            $pembayaran->delete();
            
            // Return JSON jika request adalah AJAX
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pembayaran berhasil dihapus'
                ], 200);
            }
            
            return redirect()->route('admin.pembayaran.index')
                           ->with('success', 'Pembayaran berhasil dihapus');
        } catch (\Exception $e) {
            // Return JSON jika request adalah AJAX
            if (request()->expectsJson()) {
                \Log::error('Delete Pembayaran Error: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus pembayaran: ' . $e->getMessage()
                ], 500);
            }
            
            \Log::error('Delete Pembayaran Error: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Gagal menghapus pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Export pembayaran ke CSV
     */
    public function export(Request $request)
    {
        $query = Pembayaran::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pembayarans = $query->get();

        $csv = "ID,Nama,Metode,Jumlah,Status,Nama Bank,Nomor Rekening,Atas Nama Rekening,Jenis E-Wallet,Nomor E-Wallet,Tanggal Upload\n";
        foreach ($pembayarans as $p) {
            $namaBank = $p->nama_bank ?? '';
            $nomorRekening = $p->nomor_rekening ?? '';
            $atasNamaRekening = $p->atas_nama_rekening ?? '';
            $jenisEwallet = $p->jenis_ewallet ?? '';
            $nomorEwallet = $p->nomor_ewallet ?? '';
            
            $csv .= "\"{$p->id}\",\"{$p->nama}\",\"{$p->metode}\",{$p->jumlah},\"{$p->status}\",\"{$namaBank}\",\"{$nomorRekening}\",\"{$atasNamaRekening}\",\"{$jenisEwallet}\",\"{$nomorEwallet}\",\"{$p->created_at->format('d-m-Y H:i')}\"\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="pembayaran_' . date('Y-m-d') . '.csv"');
    }

    /**
     * Bulk update status pembayaran
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:pembayaran,id',
            'status' => 'required|in:Terverifikasi,Ditolak',
        ]);

        try {
            Pembayaran::whereIn('id', $request->ids)->update([
                'status' => $request->status,
            ]);

            $count = count($request->ids);
            return response()->json([
                'success' => true,
                'message' => "{$count} pembayaran berhasil diperbarui status menjadi {$request->status}",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get statistic pembayaran
     */
    public function getStatistics()
    {
        return response()->json([
            'total' => Pembayaran::count(),
            'menunggu' => Pembayaran::where('status', 'Menunggu Verifikasi')->count(),
            'terverifikasi' => Pembayaran::where('status', 'Terverifikasi')->count(),
            'ditolak' => Pembayaran::where('status', 'Ditolak')->count(),
            'total_jumlah' => Pembayaran::sum('jumlah'),
            'total_terverifikasi' => Pembayaran::where('status', 'Terverifikasi')->sum('jumlah'),
        ]);
    }
}
