<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pembayaran')) {
            Schema::table('pembayaran', function (Blueprint $table) {
                // Add foreign keys jika kolom ada dan belum ada constraint
                try {
                    if (Schema::hasColumn('pembayaran', 'pendaftaran_id')) {
                        $table->foreign('pendaftaran_id')
                            ->references('id')
                            ->on('pendaftarans')
                            ->onDelete('cascade');
                    }
                } catch (\Exception $e) {
                    // Foreign key sudah ada atau table dependency tidak ada, skip
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pembayaran')) {
            Schema::table('pembayaran', function (Blueprint $table) {
                try {
                    $table->dropForeign(['pendaftaran_id']);
                } catch (\Exception $e) {
                    // Foreign key tidak ada, skip
                }
            });
        }
    }
};
