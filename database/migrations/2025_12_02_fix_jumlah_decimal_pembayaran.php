<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pembayaran') && !$this->isSQLite()) {
            // Modify jumlah column ke decimal yang lebih besar (MySQL only)
            DB::statement('ALTER TABLE pembayaran MODIFY COLUMN jumlah DECIMAL(15,2) NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pembayaran') && !$this->isSQLite()) {
            DB::statement('ALTER TABLE pembayaran MODIFY COLUMN jumlah DECIMAL(10,2) NULL');
        }
    }

    private function isSQLite(): bool
    {
        return DB::connection()->getDriverName() === 'sqlite';
    }
};
