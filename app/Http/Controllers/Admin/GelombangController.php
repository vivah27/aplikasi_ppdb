<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gelombang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GelombangController extends Controller
{
    public function index()
    {
        $gelombang = Gelombang::orderBy('nomor_gelombang')->get();
        return view('admin.gelombang.index', compact('gelombang'));
    }

    public function create()
    {
        return view('admin.gelombang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_gelombang' => 'required|string|max:50',
            'nomor_gelombang' => 'required|integer|unique:gelombang,nomor_gelombang',
            'tanggal_buka' => 'required|date_format:Y-m-d\TH:i',
            'tanggal_tutup' => 'required|date_format:Y-m-d\TH:i|after:tanggal_buka',
            'harga' => 'nullable|numeric|min:0',
            'jenis_pembayaran' => 'nullable|string|max:100',
            'tujuan_rekening' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Gelombang::create($validated);

        return redirect()->route('admin.gelombang.index')->with('success', 'Gelombang berhasil ditambahkan');
    }

    public function edit(Gelombang $gelombang)
    {
        return view('admin.gelombang.edit', compact('gelombang'));
    }

    public function update(Request $request, Gelombang $gelombang)
    {
        $validated = $request->validate([
            'nama_gelombang' => 'required|string|max:50',
            'nomor_gelombang' => 'required|integer|unique:gelombang,nomor_gelombang,' . $gelombang->id,
            'tanggal_buka' => 'required|date_format:Y-m-d\TH:i',
            'tanggal_tutup' => 'required|date_format:Y-m-d\TH:i|after:tanggal_buka',
            'harga' => 'nullable|numeric|min:0',
            'jenis_pembayaran' => 'nullable|string|max:100',
            'tujuan_rekening' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $gelombang->update($validated);

        return redirect()->route('admin.gelombang.index')->with('success', 'Gelombang berhasil diperbarui');
    }

    public function show(Gelombang $gelombang)
    {
        $pendaftaran = $gelombang->pendaftarans()->with('siswa', 'pengguna', 'jurusan')->paginate(20);
        return view('admin.gelombang.show', compact('gelombang', 'pendaftaran'));
    }

    public function destroy(Gelombang $gelombang)
    {
        if ($gelombang->hasPendaftar()) {
            return redirect()->back()->with('error', 'Tidak bisa hapus gelombang yang sudah ada pendaftar');
        }

        $gelombang->delete();

        return redirect()->route('admin.gelombang.index')->with('success', 'Gelombang berhasil dihapus');
    }
}
