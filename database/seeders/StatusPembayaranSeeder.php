<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusPembayaranSeeder extends Seeder
{
    /**
     * Jalankan database seeder.
     */
    public function run(): void
    {
        DB::table('status_pembayaran')->insert([
            ['status' => 'Belum Lunas', 'created_at' => now(), 'updated_at' => now()],
            ['status' => 'Lunas', 'created_at' => now(), 'updated_at' => now()],
            ['status' => 'Menunggu Konfirmasi', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
