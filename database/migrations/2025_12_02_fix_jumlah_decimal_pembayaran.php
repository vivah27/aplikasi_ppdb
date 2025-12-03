<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pembayaran')) {
            // Modify jumlah column ke decimal yang lebih besar
            DB::statement('ALTER TABLE pembayaran MODIFY COLUMN jumlah DECIMAL(15,2) NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pembayaran')) {
            DB::statement('ALTER TABLE pembayaran MODIFY COLUMN jumlah DECIMAL(10,2) NULL');
        }
    }
};
