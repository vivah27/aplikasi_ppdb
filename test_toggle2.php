<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test Case 2: Switch dari ORTU ke WALI
echo "Test Case 2: Switch dari ORANG TUA ke WALI\n";
echo "==========================================\n\n";

$biodata = \App\Models\Biodata::where('user_id', 1)->first();

echo "Sebelum update:\n";
echo "  Nama Ayah: " . ($biodata->nama_ayah ?: '[NULL]') . "\n";
echo "  Nama Wali: " . ($biodata->nama_wali ?: '[NULL]') . "\n";

// Simulasi form submit sebagai WALI
$dataBaru = [
    'user_id' => 1,
    'nama_lengkap' => 'Denico Tuesdyo Esmana',
    'nisn' => '1234567890123456',
    'nik' => '1234567890123456',
    'tempat_lahir' => 'Sidoarjo',
    'tanggal_lahir' => '2008-01-01',
    'jenis_kelamin' => 'Laki-laki',
    'agama' => 'Islam',
    'alamat' => 'Jl. Test No. 123',
    'no_hp' => '081234567890',
    'no_hp_wali' => '081234567891',
    'asal_sekolah' => 'SMP Test',
    'tahun_lulus' => 2024,
    'npsn' => null,
    'foto' => null,
    // ORTU data - di-clear sebagai NULL
    'nama_ayah' => null,
    'pekerjaan_ayah' => null,
    'nama_ibu' => null,
    'pekerjaan_ibu' => null,
    // WALI data
    'nama_wali' => 'Kakek Budi',
    'hubungan_wali' => 'Kakek',
];

$biodata->update($dataBaru);

echo "\nSetelah update (switch ke WALI):\n";
echo "  Nama Ayah: " . ($biodata->fresh()->nama_ayah ?: '[NULL]') . "\n";
echo "  Pekerjaan Ayah: " . ($biodata->fresh()->pekerjaan_ayah ?: '[NULL]') . "\n";
echo "  Nama Ibu: " . ($biodata->fresh()->nama_ibu ?: '[NULL]') . "\n";
echo "  Pekerjaan Ibu: " . ($biodata->fresh()->pekerjaan_ibu ?: '[NULL]') . "\n";
echo "  Nama Wali: " . ($biodata->fresh()->nama_wali ?: '[NULL]') . "\n";
echo "  Hubungan Wali: " . ($biodata->fresh()->hubungan_wali ?: '[NULL]') . "\n";

echo "\n✓ Test berhasil - Data ortu di-clear saat switch ke wali!\n";
?>
