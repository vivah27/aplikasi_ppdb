<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST SCENARIO 1: User Pilih ORTU ===\n\n";

$biodatas = \App\Models\Biodata::all();
foreach ($biodatas as $bio) {
    echo "User ID: {$bio->user_id}\n";
    echo "Jenis Pendamping: " . ($bio->nama_ayah ? 'ORTU' : 'WALI') . "\n";
    echo "Data Ortu:\n";
    echo "  ✓ Nama Ayah: " . ($bio->nama_ayah ?: '❌ NULL') . "\n";
    echo "  ✓ Pekerjaan Ayah: " . ($bio->pekerjaan_ayah ?: '❌ NULL') . "\n";
    echo "  ✓ Nama Ibu: " . ($bio->nama_ibu ?: '❌ NULL') . "\n";
    echo "  ✓ Pekerjaan Ibu: " . ($bio->pekerjaan_ibu ?: '❌ NULL') . "\n";
    echo "Data Wali:\n";
    echo "  ✓ Nama Wali: " . ($bio->nama_wali ?: '❌ NULL') . "\n";
    echo "  ✓ Hubungan Wali: " . ($bio->hubungan_wali ?: '❌ NULL') . "\n\n";
    
    // Validasi
    if ($bio->nama_ayah) {
        $ortuFilled = !empty($bio->nama_ayah) && !empty($bio->pekerjaan_ayah) && 
                      !empty($bio->nama_ibu) && !empty($bio->pekerjaan_ibu);
        $waliEmpty = empty($bio->nama_wali) && empty($bio->hubungan_wali);
        
        if ($ortuFilled && $waliEmpty) {
            echo "✅ VALID: Hanya data ORTU yang terisi, data WALI kosong!\n";
        } else {
            echo "❌ ERROR: Data tidak valid!\n";
            echo "   Ortu lengkap: " . ($ortuFilled ? 'Ya' : 'Tidak') . "\n";
            echo "   Wali kosong: " . ($waliEmpty ? 'Ya' : 'Tidak') . "\n";
        }
    } else {
        $waliFilledRequired = !empty($bio->nama_wali) && !empty($bio->hubungan_wali);
        $ortuEmpty = empty($bio->nama_ayah) && empty($bio->pekerjaan_ayah) && 
                     empty($bio->nama_ibu) && empty($bio->pekerjaan_ibu);
        
        if ($waliFilledRequired && $ortuEmpty) {
            echo "✅ VALID: Hanya data WALI yang terisi, data ORTU kosong!\n";
        } else {
            echo "❌ ERROR: Data tidak valid!\n";
            echo "   Wali lengkap: " . ($waliFilledRequired ? 'Ya' : 'Tidak') . "\n";
            echo "   Ortu kosong: " . ($ortuEmpty ? 'Ya' : 'Tidak') . "\n";
        }
    }
}
?>
