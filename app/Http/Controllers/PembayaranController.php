<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\MetodePembayaran;
use App\Models\StatusPembayaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PembayaranController extends Controller
{
    public function index()
    {
        $pendaftaran = Pendaftaran::whereHas('siswa', function ($q) {
            $q->where('pengguna_id', Auth::id());
        })->first();

        $pembayaran = null;
        if ($pendaftaran) {
            $pembayaran = Pembayaran::where('pendaftaran_id', $pendaftaran->id)->latest()->first();
        }

        $metode = MetodePembayaran::all();
        $status = StatusPembayaran::all();

        return view('user.pembayaran', compact('pendaftaran', 'pembayaran', 'metode', 'status'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_pembayaran' => 'required|string|max:100',
            'jumlah' => 'required|numeric|min:0',
            'metode_id' => 'required|integer',
            'bukti' => 'nullable|mimes:jpg,png,pdf|max:2048',
        ]);

        $pendaftaran = Pendaftaran::whereHas('siswa', function ($q) {
            $q->where('pengguna_id', Auth::id());
        })->first();

        if (!$pendaftaran) {
            return redirect()->back()->with('error', 'Anda belum mengisi formulir pendaftaran.');
        }

        // Get default status (Menunggu or similar)
        $defaultStatus = StatusPembayaran::where('nama', 'MENUNGGU')->orWhere('nama', 'Menunggu')->first();
        $statusId = $defaultStatus ? $defaultStatus->id : 1;

        $data = [
            'pendaftaran_id' => $pendaftaran->id,
            'metode_pembayaran_id' => $request->metode_id,
            'status_pembayaran_id' => $statusId,
            'jumlah' => $request->jumlah,
            'tanggal_bayar' => Carbon::now(),
            'keterangan' => $request->keterangan ?? null,
        ];

        if ($request->hasFile('bukti')) {
            $data['bukti_pembayaran'] = $request->file('bukti')->store('uploads/bukti', 'public');
        }

        Pembayaran::create($data);

        return redirect()->back()->with('success', 'Pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }
}
