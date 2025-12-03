<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gelombang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gelombang', 50);
            $table->integer('nomor_gelombang')->unique();
            $table->dateTime('tanggal_buka');
            $table->dateTime('tanggal_tutup');
            $table->decimal('harga', 15, 0)->nullable();
            $table->string('jenis_pembayaran')->nullable();
            $table->text('tujuan_rekening')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gelombang');
    }
};
