<?php

namespace Database\Seeders;

use App\Models\MetodePembayaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MetodePembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metodes = [
            ['kode' => 'transfer_bank', 'label' => 'Transfer Bank'],
            ['kode' => 'e_wallet', 'label' => 'E-Wallet'],
        ];

        foreach ($metodes as $metode) {
            MetodePembayaran::updateOrCreate(
                ['kode' => $metode['kode']],
                ['label' => $metode['label']]
            );
        }
    }
}
