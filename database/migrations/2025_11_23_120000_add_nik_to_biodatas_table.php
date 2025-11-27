<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('biodatas', 'nik')) {
            Schema::table('biodatas', function (Blueprint $table) {
                $table->string('nik', 30)->nullable()->after('nisn');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('biodatas', 'nik')) {
            Schema::table('biodatas', function (Blueprint $table) {
                $table->dropColumn('nik');
            });
        }
    }
};
