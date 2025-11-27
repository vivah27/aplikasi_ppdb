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
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('jenis_dokumen_id')->constrained('jenis_dokumens')->onDelete('cascade');
            $table->string('path', 255);
            $table->foreignId('status_verifikasi_id')->nullable()->constrained('status_verifikasis')->onDelete('set null');
            $table->text('catatan')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('users')->onDelete('restrict');
            $table->foreignId('diperbarui_oleh')->nullable()->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
