<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$biodatas = \App\Models\Biodata::all();

foreach ($biodatas as $bio) {
    echo "========================================\n";
    echo "Biodata ID: {$bio->id}, User ID: {$bio->user_id}\n";
    echo "Jenis Pendamping: " . ($bio->nama_ayah ? 'ORTU (Ayah & Ibu)' : 'WALI') . "\n";
    echo "Data Orang Tua:\n";
    echo "  - Nama Ayah: " . ($bio->nama_ayah ?: '[NULL]') . "\n";
    echo "  - Pekerjaan Ayah: " . ($bio->pekerjaan_ayah ?: '[NULL]') . "\n";
    echo "  - Nama Ibu: " . ($bio->nama_ibu ?: '[NULL]') . "\n";
    echo "  - Pekerjaan Ibu: " . ($bio->pekerjaan_ibu ?: '[NULL]') . "\n";
    echo "Data Wali:\n";
    echo "  - Nama Wali: " . ($bio->nama_wali ?: '[NULL]') . "\n";
    echo "  - Hubungan Wali: " . ($bio->hubungan_wali ?: '[NULL]') . "\n";
    echo "========================================\n\n";
}
?>
