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
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->unsignedBigInteger('siswa_id')->nullable()->after('id');
            $table->unsignedBigInteger('pengguna_id')->nullable()->after('siswa_id');
            $table->string('nomor_pendaftaran')->nullable()->after('pengguna_id');
            $table->string('status')->default('pending')->after('nomor_pendaftaran');
            $table->date('tanggal_daftar')->nullable()->after('status');
            $table->text('keterangan')->nullable()->after('tanggal_daftar');

            // Add foreign keys if those tables/columns exist. Uncomment if you want strict FK.
            // $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('set null');
            // $table->foreign('pengguna_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            // If you uncommented foreign keys above, drop them first:
            // $table->dropForeign(['siswa_id']);
            // $table->dropForeign(['pengguna_id']);

            $table->dropColumn(['siswa_id', 'pengguna_id', 'nomor_pendaftaran', 'status', 'tanggal_daftar', 'keterangan']);
        });
    }
};
