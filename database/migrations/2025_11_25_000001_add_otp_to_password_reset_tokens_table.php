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
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            if (!Schema::hasColumn('password_reset_tokens', 'otp_code')) {
                $table->string('otp_code')->nullable()->after('token');
            }
            if (!Schema::hasColumn('password_reset_tokens', 'otp_expires_at')) {
                $table->timestamp('otp_expires_at')->nullable()->after('otp_code');
            }
            if (!Schema::hasColumn('password_reset_tokens', 'is_verified')) {
                $table->boolean('is_verified')->default(false)->after('otp_expires_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('password_reset_tokens', 'otp_code')) {
                $table->dropColumn('otp_code');
            }
            if (Schema::hasColumn('password_reset_tokens', 'otp_expires_at')) {
                $table->dropColumn('otp_expires_at');
            }
            if (Schema::hasColumn('password_reset_tokens', 'is_verified')) {
                $table->dropColumn('is_verified');
            }
        });
    }
};
