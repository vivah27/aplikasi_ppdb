<?php

namespace App\Http\Controllers;

use App\Models\Gelombang;
use Illuminate\Http\Request;

class HargaGelombangController extends Controller
{
    public function index()
    {
        // Redirect ke gelombang.index karena sekarang semua harga diatur di sana
        return redirect()->route('admin.gelombang.index');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'harga' => 'required|array',
            'harga.*' => 'required|numeric|min:0',
            'jenis_pembayaran' => 'required|array',
            'jenis_pembayaran.*' => 'required|string|max:100',
            'tujuan_rekening' => 'nullable|array',
            'tujuan_rekening.*' => 'nullable|string|max:500',
        ]);

        try {
            // Update harga, jenis pembayaran, dan tujuan rekening untuk setiap gelombang
            foreach ($validated['harga'] as $id => $harga) {
                Gelombang::where('id', $id)->update([
                    'harga' => $harga,
                    'jenis_pembayaran' => $validated['jenis_pembayaran'][$id] ?? 'Uang Pendaftaran',
                    'tujuan_rekening' => $validated['tujuan_rekening'][$id] ?? null,
                ]);
            }

            return redirect()->route('admin.harga-gelombang.index')
                ->with('success', 'Data gelombang berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
