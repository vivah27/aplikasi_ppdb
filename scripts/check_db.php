<?php
// scripts/check_db.php
// Usage: php scripts/check_db.php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    DB::connection()->getPdo();
    echo "DB connection OK: " . DB::connection()->getDatabaseName() . PHP_EOL;
    exit(0);
} catch (Exception $e) {
    echo "DB connection failed: " . $e->getMessage() . PHP_EOL;
    echo "Check your .env and ensure your database server is running.\n";
    exit(1);
}
