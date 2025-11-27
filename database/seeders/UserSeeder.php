<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Jalankan database seeder.
     */
    public function run(): void
    {
        // Default user - use updateOrInsert to avoid duplicate key errors
        DB::table('users')->updateOrInsert(
            ['email' => 'usersatu@gmail.com'],
            [
                'name' => 'User Satu',
                'password' => Hash::make('password123'),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // Admin user - create or update
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Satu',
                'role' => 'admin', // only if users table has role column
                'password' => Hash::make('admin123'),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
