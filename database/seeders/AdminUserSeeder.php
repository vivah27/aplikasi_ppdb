<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@localhost');
        $password = env('ADMIN_PASSWORD', 'Admin123!');

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Administrator',
                'password' => Hash::make($password),
                'role' => 'admin',
                'is_verified' => true,
            ]
        );

        $this->command->info("Admin user ensured: {$email} (password from ADMIN_PASSWORD env)");
    }
}
