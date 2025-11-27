<?php

namespace App\Http\Controllers;

use App\Models\Peran;
use Illuminate\Http\Request;

class PeranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peran = Peran::paginate(10);
        return view('admin.peran.index', compact('peran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.peran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50|unique:perans,nama',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        Peran::create($validated);

        return redirect()->route('admin.peran.index')
            ->with('success', 'Peran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Peran $peran)
    {
        $peran->load('pengguna');
        return view('admin.peran.show', compact('peran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peran $peran)
    {
        return view('admin.peran.edit', compact('peran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peran $peran)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50|unique:perans,nama,' . $peran->id,
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $peran->update($validated);

        return redirect()->route('admin.peran.index')
            ->with('success', 'Peran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peran $peran)
    {
        // Check if peran is still used by any users
        if ($peran->pengguna()->exists()) {
            return redirect()->route('admin.peran.index')
                ->with('error', 'Tidak bisa menghapus peran ini karena masih digunakan oleh ' . $peran->pengguna()->count() . ' pengguna');
        }

        $peran->delete();

        return redirect()->route('admin.peran.index')
            ->with('success', 'Peran berhasil dihapus');
    }
}
