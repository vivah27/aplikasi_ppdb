<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Jurusan;
use App\Models\DokumenAccessLog;
use App\Models\User;

echo 'jurusan: ' . Jurusan::count() . PHP_EOL;
echo 'dokumen_access_logs: ' . DokumenAccessLog::count() . PHP_EOL;
echo 'users: ' . User::count() . PHP_EOL;
