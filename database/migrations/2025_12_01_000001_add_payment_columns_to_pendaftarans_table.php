<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            // Tambah kolom harga_gelombang jika belum ada
            if (!Schema::hasColumn('pendaftarans', 'harga_gelombang')) {
                $table->decimal('harga_gelombang', 12, 2)->default(0)->after('gelombang')
                    ->comment('Harga pendaftaran sesuai gelombang yang ditentukan admin');
            }
            
            // Tambah kolom jenis_pembayaran jika belum ada
            if (!Schema::hasColumn('pendaftarans', 'jenis_pembayaran')) {
                $table->string('jenis_pembayaran')->default('Uang Pendaftaran')->after('harga_gelombang')
                    ->comment('Jenis pembayaran untuk pendaftaran ini');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            if (Schema::hasColumn('pendaftarans', 'harga_gelombang')) {
                $table->dropColumn('harga_gelombang');
            }
            
            if (Schema::hasColumn('pendaftarans', 'jenis_pembayaran')) {
                $table->dropColumn('jenis_pembayaran');
            }
        });
    }
};
