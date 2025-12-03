<?php

// Simple direct database check
require_once __DIR__ . '/vendor/autoload.php';

// Load .env
$dotenv = new \Dotenv\Dotenv(__DIR__);
try {
    $dotenv->load();
} catch (\Exception $e) {
    // Ignore if not found
}

// Create PDO connection
$dsn = 'mysql:host=' . getenv('DB_HOST', 'localhost') . ';dbname=' . getenv('DB_DATABASE', 'ppdb');
$username = getenv('DB_USERNAME', 'root');
$password = getenv('DB_PASSWORD', '');

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== DATABASE CHECK ===\n\n";
    
    // 1. Find Denico user
    echo "1. Checking user 'denicottuesdyoesmana@gmail.com':\n";
    $stmt = $pdo->query("SELECT id, name, email FROM users WHERE email = 'denicottuesdyoesmana@gmail.com'");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "   Found: ID=" . $user['id'] . ", Name=" . $user['name'] . "\n\n";
        
        // 2. Find siswa
        echo "2. Checking siswa for user_id=" . $user['id'] . ":\n";
        $stmt = $pdo->query("SELECT id, nama FROM siswas WHERE pengguna_id = " . $user['id']);
        $siswa = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($siswa) {
            echo "   Found: ID=" . $siswa['id'] . ", Nama=" . $siswa['nama'] . "\n\n";
            
            // 3. Find pendaftaran
            echo "3. Checking pendaftaran for siswa_id=" . $siswa['id'] . ":\n";
            $stmt = $pdo->query("SELECT id, nomor_pendaftaran, tahun_ajaran FROM pendaftarans WHERE siswa_id = " . $siswa['id']);
            $pendaftaran = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($pendaftaran) {
                echo "   Found: ID=" . $pendaftaran['id'] . ", Nomor=" . $pendaftaran['nomor_pendaftaran'] . ", Tahun=" . $pendaftaran['tahun_ajaran'] . "\n\n";
                
                // 4. Find pembayaran
                echo "4. Checking pembayaran for pendaftaran_id=" . $pendaftaran['id'] . ":\n";
                $stmt = $pdo->query("SELECT id, pendaftaran_id, nama, metode, jumlah, status FROM pembayaran WHERE pendaftaran_id = " . $pendaftaran['id']);
                $pembayaran = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($pembayaran) {
                    echo "   Found: ID=" . $pembayaran['id'] . ", Status=" . $pembayaran['status'] . ", Jumlah=" . $pembayaran['jumlah'] . "\n";
                    echo "   Full data: " . json_encode($pembayaran, JSON_PRETTY_PRINT) . "\n\n";
                } else {
                    echo "   NOT FOUND\n\n";
                    
                    echo "   All pembayaran records in database:\n";
                    $stmt = $pdo->query("SELECT id, pendaftaran_id, nama, status FROM pembayaran LIMIT 10");
                    $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($all as $p) {
                        echo "     - ID=" . $p['id'] . ", pendaftaran_id=" . $p['pendaftaran_id'] . ", status=" . $p['status'] . "\n";
                    }
                }
            } else {
                echo "   NOT FOUND\n\n";
            }
        } else {
            echo "   NOT FOUND\n\n";
        }
    } else {
        echo "   NOT FOUND\n\n";
    }
    
    // 5. Check pembayaran table structure
    echo "5. Pembayaran table columns:\n";
    $stmt = $pdo->query("DESCRIBE pembayaran");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $col) {
        echo "   - " . $col['Field'] . " (" . $col['Type'] . ") " . ($col['Null'] == 'NO' ? 'NOT NULL' : 'NULL') . "\n";
    }
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
