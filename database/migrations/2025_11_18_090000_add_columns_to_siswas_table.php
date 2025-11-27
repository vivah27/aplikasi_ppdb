<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('siswas')) {
            // If the table doesn't exist, create it with common columns
            Schema::create('siswas', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('pengguna_id')->nullable();
                $table->string('nisn')->nullable();
                $table->string('nik')->nullable();
                $table->string('nama_lengkap')->nullable();
                $table->enum('jenis_kelamin', ['L','P'])->nullable();
                $table->string('tempat_lahir')->nullable();
                $table->date('tanggal_lahir')->nullable();
                $table->string('agama')->nullable();
                $table->text('alamat')->nullable();
                $table->string('no_telepon')->nullable();
                $table->string('email')->nullable();
                $table->string('asal_sekolah')->nullable();
                $table->unsignedBigInteger('jurusan_id')->nullable();
                $table->string('foto')->nullable();
                $table->integer('anak_ke')->nullable();
                $table->integer('jumlah_saudara')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
            return;
        }

        Schema::table('siswas', function (Blueprint $table) {
            if (!Schema::hasColumn('siswas', 'pengguna_id')) {
                $table->unsignedBigInteger('pengguna_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('siswas', 'nisn')) {
                $table->string('nisn')->nullable()->after('pengguna_id');
            }
            if (!Schema::hasColumn('siswas', 'nik')) {
                $table->string('nik')->nullable()->after('nisn');
            }
            if (!Schema::hasColumn('siswas', 'nama_lengkap')) {
                $table->string('nama_lengkap')->nullable()->after('nik');
            }
            if (!Schema::hasColumn('siswas', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['L','P'])->nullable()->after('nama_lengkap');
            }
            if (!Schema::hasColumn('siswas', 'tempat_lahir')) {
                $table->string('tempat_lahir')->nullable()->after('jenis_kelamin');
            }
            if (!Schema::hasColumn('siswas', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            }
            if (!Schema::hasColumn('siswas', 'agama')) {
                $table->string('agama')->nullable()->after('tanggal_lahir');
            }
            if (!Schema::hasColumn('siswas', 'alamat')) {
                $table->text('alamat')->nullable()->after('agama');
            }
            if (!Schema::hasColumn('siswas', 'no_telepon')) {
                $table->string('no_telepon')->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('siswas', 'email')) {
                $table->string('email')->nullable()->after('no_telepon');
            }
            if (!Schema::hasColumn('siswas', 'asal_sekolah')) {
                $table->string('asal_sekolah')->nullable()->after('email');
            }
            if (!Schema::hasColumn('siswas', 'jurusan_id')) {
                $table->unsignedBigInteger('jurusan_id')->nullable()->after('asal_sekolah');
            }
            if (!Schema::hasColumn('siswas', 'foto')) {
                $table->string('foto')->nullable()->after('jurusan_id');
            }
            if (!Schema::hasColumn('siswas', 'anak_ke')) {
                $table->integer('anak_ke')->nullable()->after('foto');
            }
            if (!Schema::hasColumn('siswas', 'jumlah_saudara')) {
                $table->integer('jumlah_saudara')->nullable()->after('anak_ke');
            }
            if (!Schema::hasColumn('siswas', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $cols = [
                'pengguna_id','nisn','nik','nama_lengkap','jenis_kelamin','tempat_lahir','tanggal_lahir','agama','alamat','no_telepon','email','asal_sekolah','jurusan_id','foto','anak_ke','jumlah_saudara','deleted_at'
            ];
            foreach ($cols as $c) {
                if (Schema::hasColumn('siswas', $c)) {
                    // dropColumn doesn't accept deleted_at if softDeletes created it as timestamp; attempt drop safely
                    $table->dropColumn($c);
                }
            }
        });
    }
};
