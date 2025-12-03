#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Now we can use Laravel models
use App\Models\User;
use App\Models\Siswa;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;

echo "=== RELATIONSHIP DEBUG ===\n\n";

// Find Denico user
$user = User::where('email', 'denicottuesdyoesmana@gmail.com')->first();

if (!$user) {
    echo "User not found!\n";
    exit(1);
}

echo "1. User found: " . $user->email . " (ID: " . $user->id . ")\n";

// Find siswa
$siswa = Siswa::where('pengguna_id', $user->id)->first();

if (!$siswa) {
    echo "Siswa not found!\n";
    exit(1);
}

echo "2. Siswa found: " . $siswa->nama . " (ID: " . $siswa->id . ")\n";

// Find pendaftaran
$pendaftaran = Pendaftaran::where('siswa_id', $siswa->id)->first();

if (!$pendaftaran) {
    echo "Pendaftaran not found!\n";
    exit(1);
}

echo "3. Pendaftaran found: ID=" . $pendaftaran->id . ", Nomor=" . $pendaftaran->nomor_pendaftaran . "\n\n";

// Check pembayaran relationship - the key test
echo "4. Testing pembayaran relationship:\n";

// Direct query
$pembayaranDirect = DB::table('pembayaran')
    ->where('pendaftaran_id', $pendaftaran->id)
    ->first();

echo "   Direct DB query: " . ($pembayaranDirect ? "FOUND (ID: " . $pembayaranDirect->id . ")" : "NOT FOUND") . "\n";

// Via relationship - without with()
$pembayaranRel1 = $pendaftaran->pembayaran;
echo "   Via hasOne() relationship (fresh): " . ($pembayaranRel1 ? "FOUND (ID: " . $pembayaranRel1->id . ")" : "NULL") . "\n";

// Via with() explicitly
$pendaftaranWithPembayaran = Pendaftaran::where('id', $pendaftaran->id)
    ->with('pembayaran')
    ->first();
echo "   Via with('pembayaran'): " . ($pendaftaranWithPembayaran->pembayaran ? "FOUND (ID: " . $pendaftaranWithPembayaran->pembayaran->id . ")" : "NULL") . "\n";

if ($pembayaranDirect) {
    echo "\n5. Pembayaran data:\n";
    echo "   ID: " . $pembayaranDirect->id . "\n";
    echo "   Status: " . $pembayaranDirect->status . "\n";
    echo "   Jumlah: " . $pembayaranDirect->jumlah . "\n";
    echo "   Metode: " . ($pembayaranDirect->metode ?? 'N/A') . "\n";
    
    // Check if status match
    $isVerified = strtoupper($pembayaranDirect->status ?? '') === 'TERVERIFIKASI';
    echo "   Is Terverifikasi: " . ($isVerified ? "YES" : "NO (status=" . strtoupper($pembayaranDirect->status) . ")") . "\n";
}

echo "\n";
