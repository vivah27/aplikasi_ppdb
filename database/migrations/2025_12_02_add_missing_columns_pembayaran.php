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
                // Add missing columns jika belum ada
                if (!Schema::hasColumn('pembayaran', 'catatan')) {
                    $table->text('catatan')->nullable();
                }
                if (!Schema::hasColumn('pembayaran', 'tanggal_bayar')) {
                    $table->dateTime('tanggal_bayar')->nullable();
                }
                if (!Schema::hasColumn('pembayaran', 'nama_bank')) {
                    $table->string('nama_bank')->nullable();
                }
                if (!Schema::hasColumn('pembayaran', 'nomor_rekening')) {
                    $table->string('nomor_rekening')->nullable();
                }
                if (!Schema::hasColumn('pembayaran', 'atas_nama_rekening')) {
                    $table->string('atas_nama_rekening')->nullable();
                }
                if (!Schema::hasColumn('pembayaran', 'jenis_ewallet')) {
                    $table->string('jenis_ewallet')->nullable();
                }
                if (!Schema::hasColumn('pembayaran', 'nomor_ewallet')) {
                    $table->string('nomor_ewallet')->nullable();
                }
                if (!Schema::hasColumn('pembayaran', 'pendaftaran_id')) {
                    $table->unsignedBigInteger('pendaftaran_id')->nullable();
                }
                if (!Schema::hasColumn('pembayaran', 'metode_pembayaran_id')) {
                    $table->unsignedBigInteger('metode_pembayaran_id')->nullable();
                }
                if (!Schema::hasColumn('pembayaran', 'status_pembayaran_id')) {
                    $table->unsignedBigInteger('status_pembayaran_id')->nullable();
                }
                if (!Schema::hasColumn('pembayaran', 'keterangan')) {
                    $table->text('keterangan')->nullable();
                }
                if (!Schema::hasColumn('pembayaran', 'bukti_pembayaran')) {
                    $table->string('bukti_pembayaran')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        // Rollback columns
    }
};
