<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('biodatas', function (Blueprint $table) {
            // Make orang tua fields nullable
            if (Schema::hasColumn('biodatas', 'nama_ayah')) {
                $table->string('nama_ayah')->nullable()->change();
            }
            if (Schema::hasColumn('biodatas', 'pekerjaan_ayah')) {
                $table->string('pekerjaan_ayah')->nullable()->change();
            }
            if (Schema::hasColumn('biodatas', 'nama_ibu')) {
                $table->string('nama_ibu')->nullable()->change();
            }
            if (Schema::hasColumn('biodatas', 'pekerjaan_ibu')) {
                $table->string('pekerjaan_ibu')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('biodatas', function (Blueprint $table) {
            if (Schema::hasColumn('biodatas', 'nama_ayah')) {
                $table->string('nama_ayah')->nullable(false)->change();
            }
            if (Schema::hasColumn('biodatas', 'pekerjaan_ayah')) {
                $table->string('pekerjaan_ayah')->nullable(false)->change();
            }
            if (Schema::hasColumn('biodatas', 'nama_ibu')) {
                $table->string('nama_ibu')->nullable(false)->change();
            }
            if (Schema::hasColumn('biodatas', 'pekerjaan_ibu')) {
                $table->string('pekerjaan_ibu')->nullable(false)->change();
            }
        });
    }
};
