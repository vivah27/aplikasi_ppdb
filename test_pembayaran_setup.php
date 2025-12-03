<?php

// Script untuk test dan fix pembayaran database
// Jalankan: php artisan tinker < test_pembayaran.php

namespace {
    use App\Models\MetodePembayaran;
    use App\Models\Pembayaran;
    use Illuminate\Support\Facades\DB;

    echo "=== Testing Pembayaran Setup ===\n";

    // 1. Check if metode_pembayarans table exists and has data
    echo "\n1. Checking MetodePembayaran table...\n";
    $metodes = MetodePembayaran::all();
    if ($metodes->count() > 0) {
        echo "   ✓ MetodePembayaran table exists dengan " . $metodes->count() . " data\n";
        foreach ($metodes as $m) {
            echo "   - ID: {$m->id}, Kode: {$m->kode}, Label: {$m->label}\n";
        }
    } else {
        echo "   ✗ MetodePembayaran table kosong\n";
    }

    // 2. Check pembayaran table structure
    echo "\n2. Checking pembayaran table structure...\n";
    $columns = DB::select("SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_DEFAULT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'pembayaran' AND TABLE_SCHEMA = DATABASE()");
    
    if (count($columns) > 0) {
        echo "   ✓ pembayaran table exists\n";
        foreach ($columns as $col) {
            $nullable = $col->IS_NULLABLE === 'YES' ? 'NULL' : 'NOT NULL';
            $default = $col->COLUMN_DEFAULT ? "DEFAULT {$col->COLUMN_DEFAULT}" : 'NO DEFAULT';
            echo "   - {$col->COLUMN_NAME}: {$col->DATA_TYPE} {$nullable} {$default}\n";
        }
    } else {
        echo "   ✗ pembayaran table not found\n";
    }

    // 3. Test creating a pembayaran record
    echo "\n3. Testing pembayaran record creation...\n";
    try {
        $testData = [
            'nama' => 'Test Pembayaran - ' . now()->timestamp,
            'metode' => 'Transfer Bank',
            'jumlah' => 150000.00,
            'status' => 'Menunggu Verifikasi',
        ];
        
        $pembayaran = Pembayaran::create($testData);
        echo "   ✓ Successfully created test pembayaran record\n";
        echo "   - ID: {$pembayaran->id}\n";
        echo "   - Nama: {$pembayaran->nama}\n";
        echo "   - Metode: {$pembayaran->metode}\n";
        
        // Clean up test record
        $pembayaran->delete();
        echo "   ✓ Test record deleted\n";
    } catch (\Exception $e) {
        echo "   ✗ Error creating pembayaran: {$e->getMessage()}\n";
    }

    echo "\n=== Test Complete ===\n";
}
