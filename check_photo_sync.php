<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';

use App\Models\Biodata;
use App\Models\Siswa;
use App\Models\User;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "=== CHECKING PHOTO SYNC ===\n\n";

// Get all users
$users = User::all();
echo "Total Users: " . count($users) . "\n\n";

foreach ($users as $user) {
    echo "=== USER: {$user->name} (ID: {$user->id}) ===\n";
    
    // Check biodata
    $biodata = Biodata::where('user_id', $user->id)->first();
    if ($biodata) {
        echo "  [BIODATA]\n";
        echo "    - Foto: " . ($biodata->foto ? "✓ " . $biodata->foto : "✗ NULL") . "\n";
        echo "    - Nama: {$biodata->nama_lengkap}\n";
    } else {
        echo "  [BIODATA] ✗ NOT FOUND\n";
    }
    
    // Check siswa
    $siswa = Siswa::where('pengguna_id', $user->id)->first();
    if ($siswa) {
        echo "  [SISWA]\n";
        echo "    - Foto: " . ($siswa->foto ? "✓ " . $siswa->foto : "✗ NULL") . "\n";
        echo "    - Nama: {$siswa->nama_lengkap}\n";
    } else {
        echo "  [SISWA] ✗ NOT FOUND\n";
    }
    
    // Check if photo file exists
    if ($biodata && $biodata->foto) {
        $path = 'storage/app/public/' . $biodata->foto;
        $exists = file_exists($path);
        echo "  [FILE CHECK]\n";
        echo "    - Path: {$path}\n";
        echo "    - Exists: " . ($exists ? "✓ YES" : "✗ NO") . "\n";
    }
    
    echo "\n";
}

echo "\n=== DONE ===\n";
