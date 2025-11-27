<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pembayaran')) {
            Schema::create('pembayaran', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('pendaftaran_id')->nullable();
                $table->unsignedBigInteger('metode_pembayaran_id')->nullable();
                $table->unsignedBigInteger('status_pembayaran_id')->nullable();
                $table->decimal('jumlah', 10, 2)->default(0);
                $table->dateTime('tanggal_bayar')->nullable();
                $table->string('bukti_pembayaran')->nullable();
                $table->text('keterangan')->nullable();
                $table->timestamps();
            });
            return;
        }

        Schema::table('pembayaran', function (Blueprint $table) {
            if (!Schema::hasColumn('pembayaran', 'id')) {
                $table->bigIncrements('id');
            }

            if (!Schema::hasColumn('pembayaran', 'pendaftaran_id')) {
                $table->unsignedBigInteger('pendaftaran_id')->nullable()->after('id');
            }

            if (!Schema::hasColumn('pembayaran', 'metode_pembayaran_id')) {
                $table->unsignedBigInteger('metode_pembayaran_id')->nullable()->after('pendaftaran_id');
            }

            if (!Schema::hasColumn('pembayaran', 'status_pembayaran_id')) {
                $table->unsignedBigInteger('status_pembayaran_id')->nullable()->after('metode_pembayaran_id');
            }

            if (!Schema::hasColumn('pembayaran', 'jumlah')) {
                $table->decimal('jumlah', 10, 2)->default(0)->after('status_pembayaran_id');
            }

            if (!Schema::hasColumn('pembayaran', 'tanggal_bayar')) {
                $table->dateTime('tanggal_bayar')->nullable()->after('jumlah');
            }

            if (!Schema::hasColumn('pembayaran', 'bukti_pembayaran')) {
                $table->string('bukti_pembayaran')->nullable()->after('tanggal_bayar');
            }

            if (!Schema::hasColumn('pembayaran', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('bukti_pembayaran');
            }

            if (!Schema::hasColumn('pembayaran', 'created_at') || !Schema::hasColumn('pembayaran', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            if (Schema::hasColumn('pembayaran', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
            if (Schema::hasColumn('pembayaran', 'bukti_pembayaran')) {
                $table->dropColumn('bukti_pembayaran');
            }
            if (Schema::hasColumn('pembayaran', 'tanggal_bayar')) {
                $table->dropColumn('tanggal_bayar');
            }
            if (Schema::hasColumn('pembayaran', 'jumlah')) {
                $table->dropColumn('jumlah');
            }
            if (Schema::hasColumn('pembayaran', 'status_pembayaran_id')) {
                $table->dropColumn('status_pembayaran_id');
            }
            if (Schema::hasColumn('pembayaran', 'metode_pembayaran_id')) {
                $table->dropColumn('metode_pembayaran_id');
            }
            if (Schema::hasColumn('pembayaran', 'pendaftaran_id')) {
                $table->dropColumn('pendaftaran_id');
            }
            // Do not drop id/timestamps here to avoid dangerous operations on existing tables.
        });
    }
};
