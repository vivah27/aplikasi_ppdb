<?php

use App\Models\Biodata;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Simulate auth (test untuk user ID 4)
$user = User::find(4);

if ($user) {
    $siswa = Siswa::where('pengguna_id', $user->id)->first();
    $biodata = Biodata::where('user_id', $user->id)->first();
    
    echo "=== PROFILE VIEW DEBUG ===\n\n";
    echo "User: {$user->name} (ID: {$user->id})\n\n";
    
    echo "[Controller Variables]\n";
    echo "  \$siswa: " . ($siswa ? "Found (ID: {$siswa->id})" : "NULL") . "\n";
    echo "  \$biodata: " . ($biodata ? "Found (ID: {$biodata->id})" : "NULL") . "\n\n";
    
    echo "[View PHP Logic]\n";
    echo "  \$user->siswa relation: ";
    try {
        $userSiswa = $user->siswa;
        echo ($userSiswa ? "Found" : "NULL") . "\n";
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
    }
    
    echo "\n[Photo Display Logic]\n";
    echo "  \$biodata && \$biodata->foto: " . (($biodata && $biodata->foto) ? "TRUE ({$biodata->foto})" : "FALSE") . "\n";
    echo "  \$siswa && \$siswa->foto: " . (($siswa && $siswa->foto) ? "TRUE ({$siswa->foto})" : "FALSE") . "\n";
    
    $fotoDisplay = ($biodata && $biodata->foto) ? $biodata->foto : ($siswa && $siswa->foto ? $siswa->foto : null);
    echo "  \$fotoDisplay: " . ($fotoDisplay ? "'{$fotoDisplay}'" : "NULL") . "\n";
    
    if ($fotoDisplay) {
        echo "  asset('storage/' . \$fotoDisplay): " . asset('storage/' . $fotoDisplay) . "\n";
    }
    
} else {
    echo "User not found\n";
}
