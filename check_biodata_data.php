<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Biodata;
use Illuminate\Support\Facades\DB;

// Get first user
$user = User::first();
echo "User: " . ($user ? $user->email . " (ID: " . $user->id . ")" : "Not found") . "\n";

if ($user) {
    // Check biodata
    $biodata = Biodata::where('user_id', $user->id)->first();
    if ($biodata) {
        echo "Biodata Found!\n";
        echo "  - ID: " . $biodata->id . "\n";
        echo "  - Nama: " . $biodata->nama_lengkap . "\n";
        echo "  - Foto: " . $biodata->foto . "\n";
        echo "  - User ID: " . $biodata->user_id . "\n";
    } else {
        echo "No biodata found for this user\n";
        
        // Check if any biodata exists
        $count = Biodata::count();
        echo "Total biodata records in DB: " . $count . "\n";
        
        if ($count > 0) {
            echo "Sample biodata:\n";
            $sample = Biodata::first();
            echo "  - ID: " . $sample->id . "\n";
            echo "  - User ID: " . $sample->user_id . "\n";
            echo "  - Nama: " . $sample->nama_lengkap . "\n";
            echo "  - Foto: " . $sample->foto . "\n";
        }
    }
}
