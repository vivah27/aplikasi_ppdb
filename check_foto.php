<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$siswas = \App\Models\Siswa::select('id', 'pengguna_id', 'foto')->limit(5)->get();

foreach ($siswas as $siswa) {
    echo "Siswa ID: {$siswa->id}, Pengguna ID: {$siswa->pengguna_id}, Foto: {$siswa->foto}\n";
}
?>
