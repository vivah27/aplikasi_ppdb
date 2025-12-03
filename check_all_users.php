<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Biodata;

// Get all users
$users = User::all();
echo "All Users:\n";
foreach ($users as $user) {
    echo "  - ID: {$user->id}, Name: {$user->name}, Email: {$user->email}\n";
}

echo "\nAll Biodatas:\n";
$biodatas = Biodata::all();
foreach ($biodatas as $biodata) {
    echo "  - ID: {$biodata->id}, User ID: {$biodata->user_id}, Nama: {$biodata->nama_lengkap}, Foto: {$biodata->foto}\n";
}
