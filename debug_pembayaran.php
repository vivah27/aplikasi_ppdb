<?php

use Illuminate\Support\Facades\DB;

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Find Denico user
$user = DB::table('users')->where('email', 'denicottuesdyoesmana@gmail.com')->first();

if ($user) {
    echo "User found: " . $user->email . "\n";
    
    // Find siswa
    $siswa = DB::table('siswas')->where('pengguna_id', $user->id)->first();
    
    if ($siswa) {
        echo "Siswa found: " . $siswa->nama . "\n";
        
        // Find pendaftaran
        $pendaftaran = DB::table('pendaftarans')->where('siswa_id', $siswa->id)->first();
        
        if ($pendaftaran) {
            echo "Pendaftaran found: ID=" . $pendaftaran->id . "\n";
            
            // Find pembayaran
            $pembayaran = DB::table('pembayaran')->where('pendaftaran_id', $pendaftaran->id)->first();
            
            if ($pembayaran) {
                echo "Pembayaran found: ID=" . $pembayaran->id . ", Status=" . $pembayaran->status . "\n";
                echo "Full pembayaran data: " . json_encode($pembayaran) . "\n";
            } else {
                echo "Pembayaran NOT found for pendaftaran_id=" . $pendaftaran->id . "\n";
                
                // Check all pembayaran records
                echo "\nAll pembayaran records:\n";
                $allPembayaran = DB::table('pembayaran')->get();
                foreach ($allPembayaran as $p) {
                    echo "  - ID=" . $p->id . ", pendaftaran_id=" . $p->pendaftaran_id . ", status=" . $p->status . "\n";
                }
            }
        } else {
            echo "Pendaftaran NOT found for siswa_id=" . $siswa->id . "\n";
        }
    } else {
        echo "Siswa NOT found for pengguna_id=" . $user->id . "\n";
    }
} else {
    echo "User NOT found: denicottuesdyoesmana@gmail.com\n";
}

// Also check Pendaftaran model relationship
echo "\n\nUsing Model relationship:\n";
$pendaftaranModel = \App\Models\Pendaftaran::whereHas('siswa', function ($query) use ($user) {
    $query->where('pengguna_id', $user->id);
})->with('pembayaran')->first();

if ($pendaftaranModel) {
    echo "Pendaftaran model found: ID=" . $pendaftaranModel->id . "\n";
    echo "Pembayaran relationship: " . ($pendaftaranModel->pembayaran ? "EXISTS" : "NULL") . "\n";
    
    if ($pendaftaranModel->pembayaran) {
        echo "Pembayaran ID: " . $pendaftaranModel->pembayaran->id . "\n";
        echo "Pembayaran status: " . $pendaftaranModel->pembayaran->status . "\n";
    }
}
