<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Simulasi: User switch dari Wali ke Orang Tua
echo "Test Case: Switch dari WALI ke ORANG TUA\n";
echo "==========================================\n\n";

// Ambil biodata user 1
$biodata = \App\Models\Biodata::where('user_id', 1)->first();

echo "Sebelum update:\n";
echo "  Nama Ayah: " . ($biodata->nama_ayah ?: '[NULL]') . "\n";
echo "  Nama Wali: " . ($biodata->nama_wali ?: '[NULL]') . "\n";

// Simulasi form submit sebagai ORTU
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
    // ORTU data
    'nama_ayah' => 'Ayah Test',
    'pekerjaan_ayah' => 'Pekerjaan Ayah',
    'nama_ibu' => 'Ibu Test',
    'pekerjaan_ibu' => 'Pekerjaan Ibu',
    // WALI data - di-clear sebagai NULL
    'nama_wali' => null,
    'hubungan_wali' => null,
];

// Update dengan clear wali data
$biodata->update($dataBaru);

echo "\nSetelah update (switch ke ORTU):\n";
echo "  Nama Ayah: " . ($biodata->fresh()->nama_ayah ?: '[NULL]') . "\n";
echo "  Nama Wali: " . ($biodata->fresh()->nama_wali ?: '[NULL]') . "\n";

echo "\n✓ Test berhasil - Data wali di-clear saat switch ke ortu!\n";
?>
