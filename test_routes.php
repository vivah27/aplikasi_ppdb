<?php
require 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

// Get database
$pendaftaran = \App\Models\Pendaftaran::first();
$pembayaran = \App\Models\Pembayaran::first();
$users = \App\Models\User::count();

echo "Users: " . $users . "\n";
echo "Pendaftaran: " . ($pendaftaran ? $pendaftaran->id : 'none') . "\n";
echo "Pembayaran: " . ($pembayaran ? $pembayaran->id : 'none') . "\n";

if ($pendaftaran) {
    echo "Route cetak.index: /cetak\n";
    echo "Route cetak.formulir: /cetak/formulir/" . $pendaftaran->id . "\n";
    echo "Route cetak.kartu: /cetak/kartu/" . $pendaftaran->id . "\n";
    echo "Route cetak.surat: /cetak/surat/" . $pendaftaran->id . "\n";
}

if ($pembayaran) {
    echo "Route cetak.kuitansi: /cetak/kuitansi/" . $pembayaran->id . "\n";
}
