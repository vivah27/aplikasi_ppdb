<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Peran;
use App\Models\PeRanPengguna;
use Illuminate\Http\Request;

class UserPeranController extends Controller
{
    /**
     * Attach peran ke user
     */
    public function attach(Request $request, User $user)
    {
        $validated = $request->validate([
            'peran_id' => 'required|exists:perans,id',
        ]);

        // Cek apakah sudah ada
        $exists = PeRanPengguna::where('pengguna_id', $user->id)
            ->where('peran_id', $validated['peran_id'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Peran sudah ditambahkan ke pengguna ini');
        }

        PeRanPengguna::create([
            'pengguna_id' => $user->id,
            'peran_id' => $validated['peran_id'],
        ]);

        return back()->with('success', 'Peran berhasil ditambahkan');
    }

    /**
     * Detach peran dari user
     */
    public function detach(Request $request, User $user)
    {
        $validated = $request->validate([
            'peran_id' => 'required|exists:perans,id',
        ]);

        PeRanPengguna::where('pengguna_id', $user->id)
            ->where('peran_id', $validated['peran_id'])
            ->delete();

        return back()->with('success', 'Peran berhasil dihapus');
    }
}
