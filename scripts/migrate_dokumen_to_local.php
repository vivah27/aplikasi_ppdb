<?php
// scripts/migrate_dokumen_to_local.php
// Usage: php scripts/migrate_dokumen_to_local.php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Bootstrap framework (so facades, config, etc. are available)
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Dokumen;
use Illuminate\Support\Facades\Storage;

echo "Starting dokumen migration: public -> local\n";

$count = 0;

// Use cursor to avoid loading everything into memory
foreach (Dokumen::cursor() as $dokumen) {
    $path = $dokumen->path;

    if (empty($path)) {
        echo "[WARN] Empty path for Dokumen ID {$dokumen->id}\n";
        continue;
    }

    if (Storage::disk('local')->exists($path)) {
        echo "[SKIP] Already local: {$path}\n";
        continue;
    }

    if (!Storage::disk('public')->exists($path)) {
        echo "[MISSING] Public file not found: {$path}\n";
        continue;
    }

    $readStream = Storage::disk('public')->readStream($path);
    if ($readStream === false) {
        echo "[ERROR] Failed to open stream for: {$path}\n";
        continue;
    }

    $wrote = Storage::disk('local')->writeStream($path, $readStream);

    if (is_resource($readStream)) {
        fclose($readStream);
    }

    if ($wrote) {
        // Optionally delete public copy after successful write. Keep public copy for now.
        // Storage::disk('public')->delete($path);

        // Ensure DB path stays the same (we used same relative path)
        $dokumen->path = $path;
        $dokumen->saveQuietly();

        echo "[MIGRATED] {$path}\n";
        $count++;
    } else {
        echo "[ERROR] Failed to write to local disk: {$path}\n";
    }
}

echo "Migration complete. Files migrated: {$count}\n";

exit(0);
