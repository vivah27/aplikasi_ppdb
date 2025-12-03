<?php
// Debug script to check pembayaran status in database

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/app.php';

use App\Models\Pembayaran;

echo "=== DEBUG PEMBAYARAN STATUS ===\n\n";

// Get all pembayaran with status
$pembayarans = Pembayaran::select('id', 'status', 'status_pembayaran_id', 'nama', 'metode')
    ->with('statusPembayaran')
    ->get();

echo "Total Pembayaran: " . $pembayarans->count() . "\n\n";

foreach ($pembayarans as $p) {
    echo "ID: {$p->id}\n";
    echo "  Status (field): " . $p->status . "\n";
    echo "  Status (uppercase): " . strtoupper($p->status ?? '') . "\n";
    echo "  Status ID: " . $p->status_pembayaran_id . "\n";
    echo "  Status Pembayaran Name: " . ($p->statusPembayaran?->nama ?? 'NULL') . "\n";
    echo "  Nama: " . $p->nama . "\n";
    echo "  Metode: " . $p->metode . "\n";
    echo "  Check strtoupper EQUALS TERVERIFIKASI: " . (strtoupper($p->status ?? '') === 'TERVERIFIKASI' ? 'TRUE' : 'FALSE') . "\n";
    echo "\n";
}
?>
