<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pembayaran')) {
            return; // Table doesn't exist yet, skip
        }

        try {
            // 1. Fix all columns to have proper constraints
            DB::statement("ALTER TABLE pembayaran MODIFY COLUMN nama VARCHAR(255) NOT NULL DEFAULT 'Pembayaran Pendaftaran'");
            
            DB::statement("ALTER TABLE pembayaran MODIFY COLUMN metode VARCHAR(255) NOT NULL DEFAULT 'Transfer Bank'");
            
            DB::statement("ALTER TABLE pembayaran MODIFY COLUMN jumlah DECIMAL(10,2) NOT NULL DEFAULT 0");
            
            DB::statement("ALTER TABLE pembayaran MODIFY COLUMN status VARCHAR(255) NOT NULL DEFAULT 'Menunggu Verifikasi'");
            
            // Get table columns safely
            try {
                $columns = DB::select("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'pembayaran' AND TABLE_SCHEMA = DATABASE()");
                $columnNames = array_column($columns, 'COLUMN_NAME');
                
                if (in_array('bukti', $columnNames)) {
                    DB::statement("ALTER TABLE pembayaran MODIFY COLUMN bukti VARCHAR(255) NULL");
                }
            } catch (\Exception $e) {
                // Ignore if we can't check columns
            }

            // 2. Update any existing NULL values
            DB::table('pembayaran')->whereNull('nama')->update(['nama' => 'Pembayaran Pendaftaran']);
            DB::table('pembayaran')->whereNull('metode')->update(['metode' => 'Transfer Bank']);
            DB::table('pembayaran')->whereNull('jumlah')->update(['jumlah' => 0]);
            DB::table('pembayaran')->whereNull('status')->update(['status' => 'Menunggu Verifikasi']);
        } catch (\Exception $e) {
            // Log error tapi jangan stop migration
            Log::warning('Pembayaran table migration warning: ' . $e->getMessage());
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('pembayaran')) {
            return;
        }

        try {
            // Revert to nullable
            DB::statement("ALTER TABLE pembayaran MODIFY COLUMN nama VARCHAR(255) NULL");
            DB::statement("ALTER TABLE pembayaran MODIFY COLUMN metode VARCHAR(255) NULL");
            DB::statement("ALTER TABLE pembayaran MODIFY COLUMN jumlah DECIMAL(10,2) NULL");
            DB::statement("ALTER TABLE pembayaran MODIFY COLUMN status VARCHAR(255) NULL");
        } catch (\Exception $e) {
            Log::warning('Pembayaran rollback warning: ' . $e->getMessage());
        }
    }
};
