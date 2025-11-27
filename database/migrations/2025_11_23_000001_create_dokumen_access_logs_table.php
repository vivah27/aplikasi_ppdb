<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('dokumen_access_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dokumen_id')->index();
            $table->unsignedBigInteger('pengguna_id')->nullable()->index();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('method')->nullable();
            $table->timestamps();

            $table->foreign('dokumen_id')->references('id')->on('dokumens')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumen_access_logs');
    }
};
