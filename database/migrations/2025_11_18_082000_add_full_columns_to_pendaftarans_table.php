<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            if (!Schema::hasColumn('pendaftarans', 'tahun_ajaran')) {
                $table->string('tahun_ajaran')->nullable()->after('siswa_id');
            }

            if (!Schema::hasColumn('pendaftarans', 'jalur_pendaftaran')) {
                $table->string('jalur_pendaftaran')->nullable()->after('tahun_ajaran');
            }

            if (!Schema::hasColumn('pendaftarans', 'gelombang')) {
                $table->integer('gelombang')->nullable()->after('jalur_pendaftaran');
            }

            if (!Schema::hasColumn('pendaftarans', 'jurusan_pilihan_1')) {
                $table->unsignedBigInteger('jurusan_pilihan_1')->nullable()->after('gelombang');
            }

            if (!Schema::hasColumn('pendaftarans', 'jurusan_pilihan_2')) {
                $table->unsignedBigInteger('jurusan_pilihan_2')->nullable()->after('jurusan_pilihan_1');
            }

            if (!Schema::hasColumn('pendaftarans', 'status_id')) {
                $table->unsignedBigInteger('status_id')->nullable()->after('jurusan_pilihan_2');
            }

            if (!Schema::hasColumn('pendaftarans', 'rata_nilai')) {
                $table->decimal('rata_nilai', 8, 2)->nullable()->after('status_id');
            }

            if (!Schema::hasColumn('pendaftarans', 'skor_seleksi')) {
                $table->integer('skor_seleksi')->nullable()->after('rata_nilai');
            }

            if (!Schema::hasColumn('pendaftarans', 'dibuat_oleh')) {
                $table->unsignedBigInteger('dibuat_oleh')->nullable()->after('skor_seleksi');
            }

            if (!Schema::hasColumn('pendaftarans', 'diperbarui_oleh')) {
                $table->unsignedBigInteger('diperbarui_oleh')->nullable()->after('dibuat_oleh');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $cols = [
                'tahun_ajaran', 'jalur_pendaftaran', 'gelombang', 'jurusan_pilihan_1', 'jurusan_pilihan_2',
                'status_id', 'rata_nilai', 'skor_seleksi', 'dibuat_oleh', 'diperbarui_oleh'
            ];

            foreach ($cols as $c) {
                if (Schema::hasColumn('pendaftarans', $c)) {
                    $table->dropColumn($c);
                }
            }
        });
    }
};
