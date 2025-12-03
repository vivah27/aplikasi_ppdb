<?php

namespace App\Http\Controllers\Admin;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::orderBy('nama_jurusan')->paginate(15);
        return view('admin.jurusan.index', compact('jurusan'));
    }

    public function create()
    {
        return view('admin.jurusan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_jurusan' => 'required|string|max:10|unique:jurusans,kode_jurusan',
            'nama_jurusan' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'kuota' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Jurusan::create($validated);

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil ditambahkan');
    }

    public function edit(Jurusan $jurusan)
    {
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $validated = $request->validate([
            'kode_jurusan' => 'required|string|max:10|unique:jurusans,kode_jurusan,' . $jurusan->id,
            'nama_jurusan' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'kuota' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $jurusan->update($validated);

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil diperbarui');
    }

    public function show(Jurusan $jurusan)
    {
        $pendaftar = $jurusan->pendaftarans()->with('siswa', 'pengguna')->paginate(20);
        return view('admin.jurusan.show', compact('jurusan', 'pendaftar'));
    }

    public function destroy(Jurusan $jurusan)
    {
        // Cek apakah ada pendaftar untuk jurusan ini
        if ($jurusan->pendaftarans()->exists()) {
            return redirect()->back()->with('error', 'Tidak bisa hapus jurusan yang sudah ada pendaftar');
        }

        $jurusan->delete();

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil dihapus');
    }
}
