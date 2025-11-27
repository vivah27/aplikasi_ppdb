<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jenis_berkas', function (Blueprint $table) {
            // Add nama column if it doesn't exist
            if (!Schema::hasColumn('jenis_berkas', 'nama')) {
                $table->string('nama', 100)->nullable()->after('label');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jenis_berkas', function (Blueprint $table) {
            if (Schema::hasColumn('jenis_berkas', 'nama')) {
                $table->dropColumn('nama');
            }
        });
    }
};
