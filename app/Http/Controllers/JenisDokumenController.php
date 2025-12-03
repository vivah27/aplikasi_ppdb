<?php

namespace App\Http\Controllers;

use App\Models\JenisDokumen;
use Illuminate\Http\Request;

class JenisDokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisDokumen = JenisDokumen::paginate(10);
        return view('admin.jenis-dokumen.index', compact('jenisDokumen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jenis-dokumen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'wajib' => 'boolean',
        ]);

        JenisDokumen::create($validated);

        return redirect()->route('admin.jenis-dokumen.index')
            ->with('success', 'Jenis dokumen berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisDokumen $jenisDokumen)
    {
        return view('admin.jenis-dokumen.show', compact('jenisDokumen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisDokumen $jenisDokumen)
    {
        return view('admin.jenis-dokumen.edit', compact('jenisDokumen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisDokumen $jenisDokumen)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'wajib' => 'boolean',
        ]);

        $jenisDokumen->update($validated);

        return redirect()->route('admin.jenis-dokumen.index')
            ->with('success', 'Jenis dokumen berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisDokumen $jenisDokumen)
    {
        // Get count of related documents before deletion
        $jumlahDokumen = $jenisDokumen->dokumen()->count();

        // Delete jenis dokumen (cascade will delete related dokumen records)
        $jenisDokumen->delete();

        // Show success message with info about deleted documents
        if ($jumlahDokumen > 0) {
            return redirect()->route('admin.jenis-dokumen.index')
                ->with('success', "Jenis dokumen berhasil dihapus beserta $jumlahDokumen dokumen terkait yang telah diunggah siswa");
        }

        return redirect()->route('admin.jenis-dokumen.index')
            ->with('success', 'Jenis dokumen berhasil dihapus');
    }
}
