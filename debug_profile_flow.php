<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Biodata;
use App\Models\Siswa;

// Simulate the currently logged-in user (ID 4 - denico tuesdy oesmana)
$user = User::find(4);
echo "=== USER INFO ===\n";
echo "User ID: {$user->id}\n";
echo "User Name: {$user->name}\n";
echo "User Email: {$user->email}\n\n";

// Check Biodata like ProfileController does
echo "=== BIODATA CHECK (ProfileController method) ===\n";
$biodata = Biodata::where('user_id', $user->id)->first();
if ($biodata) {
    echo "Biodata Found: YES\n";
    echo "  - ID: {$biodata->id}\n";
    echo "  - Nama: {$biodata->nama_lengkap}\n";
    echo "  - NISN: {$biodata->nisn}\n";
    echo "  - User ID (FK): {$biodata->user_id}\n";
    echo "  - Foto: {$biodata->foto}\n";
    echo "  - Foto exists: " . (file_exists('storage/app/public/' . $biodata->foto) ? 'YES' : 'NO') . "\n";
} else {
    echo "Biodata Found: NO\n";
}

// Check Siswa like ProfileController does
echo "\n=== SISWA CHECK ===\n";
$siswa = Siswa::where('pengguna_id', $user->id)->first();
if ($siswa) {
    echo "Siswa Found: YES\n";
    echo "  - ID: {$siswa->id}\n";
    echo "  - Nama: {$siswa->nama_lengkap}\n";
    echo "  - NISN: {$siswa->nisn}\n";
    echo "  - User ID (FK): {$siswa->pengguna_id}\n";
    echo "  - Foto: {$siswa->foto}\n";
} else {
    echo "Siswa Found: NO\n";
}

// Test what compact() would pass
echo "\n=== WHAT GETS PASSED TO VIEW ===\n";
$compact_data = compact('user', 'siswa', 'biodata');
echo "Compact Keys: " . implode(', ', array_keys($compact_data)) . "\n";
echo "Biodata var in compact: " . ($compact_data['biodata'] ? 'YES' : 'NO') . "\n";

// Test the view logic
echo "\n=== VIEW LOGIC TEST ===\n";
$profileData = ($biodata ?? null) ?? $siswa;
echo "\$profileData set to: " . ($profileData ? get_class($profileData) : 'null') . "\n";
if ($profileData) {
    echo "  - Nama: {$profileData->nama_lengkap}\n";
    echo "  - Foto: {$profileData->foto}\n";
}
