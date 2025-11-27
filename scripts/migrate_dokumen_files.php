<?php
// scripts/migrate_dokumen_files.php
// Purpose: Copy files from storage/app/public/dokumen -> storage/app/dokumen
// Usage examples:
//  php scripts/migrate_dokumen_files.php            # dry-run (default)
//  php scripts/migrate_dokumen_files.php --apply    # actually copy files
//  php scripts/migrate_dokumen_files.php --apply --delete-public  # copy then delete public copies

$opts = array_slice($argv, 1);
$apply = in_array('--apply', $opts, true);
$deletePublic = in_array('--delete-public', $opts, true);

echo "migrate_dokumen_files.php: Starting\n";
echo $apply ? "Mode: APPLY (files will be copied)\n" : "Mode: DRY-RUN (no changes)\n";
if ($deletePublic) {
    echo "Option: --delete-public enabled (public files will be deleted after successful copy)\n";
}

$base = realpath(__DIR__ . '/..');
$publicRoot = $base . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'dokumen';
$localRoot = $base . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'dokumen';

echo "Public dir: {$publicRoot}\n";
echo "Local dir : {$localRoot}\n";

if (!is_dir($publicRoot)) {
    echo "Public dokumen directory does not exist; nothing to do.\n";
    exit(0);
}

$files = [];
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($publicRoot, RecursiveDirectoryIterator::SKIP_DOTS));
foreach ($iterator as $fileInfo) {
    if ($fileInfo->isFile()) {
        $full = $fileInfo->getPathname();
        $rel = substr($full, strlen($publicRoot) + 1);
        $files[] = [$full, $rel];
    }
}

$total = count($files);
echo "Found {$total} files to consider.\n";

$migrated = 0;
$skipped = 0;
$errors = 0;

foreach ($files as [$full, $rel]) {
    $dest = $localRoot . DIRECTORY_SEPARATOR . $rel;
    $destDir = dirname($dest);

    if (file_exists($dest)) {
        echo "[SKIP] Already exists locally: {$rel}\n";
        $skipped++;
        continue;
    }

    echo ($apply ? "[COPY] " : "[DRY ] ") . "{$rel} -> {$dest}\n";

    if ($apply) {
        if (!is_dir($destDir) && !mkdir($destDir, 0755, true)) {
            echo "[ERROR] Failed to create dir: {$destDir}\n";
            $errors++;
            continue;
        }

        $in = fopen($full, 'rb');
        if ($in === false) {
            echo "[ERROR] Failed to open source: {$full}\n";
            $errors++;
            continue;
        }

        $out = fopen($dest, 'wb');
        if ($out === false) {
            echo "[ERROR] Failed to open dest: {$dest}\n";
            fclose($in);
            $errors++;
            continue;
        }

        $copied = stream_copy_to_stream($in, $out);
        fclose($in);
        fclose($out);

        if ($copied === 0 && filesize($full) > 0) {
            echo "[ERROR] Copied zero bytes for: {$rel}\n";
            $errors++;
            continue;
        }

        $migrated++;

        if ($deletePublic) {
            if (!unlink($full)) {
                echo "[WARN] Could not delete public file: {$full}\n";
            } else {
                // clean up empty directories under publicRoot
                $p = dirname($full);
                while ($p !== $publicRoot) {
                    if (@rmdir($p)) {
                        $p = dirname($p);
                    } else {
                        break;
                    }
                }
            }
        }
    }
}

echo "Done. Migrated: {$migrated}, Skipped: {$skipped}, Errors: {$errors}\n";

exit($errors > 0 ? 2 : 0);
