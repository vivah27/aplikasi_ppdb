<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('biodatas', function (Blueprint $table) {
            // Tambah kolom jenis_pendamping dan hubungan_wali jika belum ada
            if (!Schema::hasColumn('biodatas', 'jenis_pendamping')) {
                $table->enum('jenis_pendamping', ['ortu', 'wali'])->default('ortu')->after('no_hp_wali');
            }
            
            if (!Schema::hasColumn('biodatas', 'hubungan_wali')) {
                $table->string('hubungan_wali')->nullable()->after('jenis_pendamping');
            }
        });
    }

    public function down(): void
    {
        Schema::table('biodatas', function (Blueprint $table) {
            if (Schema::hasColumn('biodatas', 'jenis_pendamping')) {
                $table->dropColumn('jenis_pendamping');
            }
            
            if (Schema::hasColumn('biodatas', 'hubungan_wali')) {
                $table->dropColumn('hubungan_wali');
            }
        });
    }
};
