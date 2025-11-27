<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddTransferMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add payment methods if they don't exist
        $methods = [
            ['kode' => 'tunai', 'label' => 'Tunai'],
            ['kode' => 'transfer', 'label' => 'Transfer Bank'],
            ['kode' => 'kartu_kredit', 'label' => 'Kartu Kredit'],
            ['kode' => 'e_wallet', 'label' => 'E-Wallet (GCash/GoPay)'],
        ];
        
        foreach ($methods as $method) {
            $exists = DB::table('metode_pembayarans')->where('kode', $method['kode'])->exists();
            if (!$exists) {
                DB::table('metode_pembayarans')->insert([
                    'kode' => $method['kode'],
                    'label' => $method['label'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
