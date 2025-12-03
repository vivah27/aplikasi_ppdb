<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->default('Pembayaran Pendaftaran');
            $table->string('metode')->default('Transfer Bank');
            $table->decimal('jumlah', 15, 2)->default(0);
            $table->string('bukti')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->string('status')->default('Menunggu Verifikasi');
            $table->dateTime('tanggal_bayar')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('catatan')->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('atas_nama_rekening')->nullable();
            $table->string('jenis_ewallet')->nullable();
            $table->string('nomor_ewallet')->nullable();
            $table->unsignedBigInteger('pendaftaran_id')->nullable();
            $table->unsignedBigInteger('metode_pembayaran_id')->nullable();
            $table->unsignedBigInteger('status_pembayaran_id')->nullable();
            $table->timestamps();
            
            // Foreign keys - akan ditambah di migration terpisah agar tidak error jika tabel dependency tidak ada
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
