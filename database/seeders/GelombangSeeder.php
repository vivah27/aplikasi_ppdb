<?php

namespace Database\Seeders;

use App\Models\Gelombang;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class GelombangSeeder extends Seeder
{
    public function run(): void
    {
        $gelombang = [
            [
                'nama_gelombang' => 'Gelombang 1',
                'nomor_gelombang' => 1,
                'tanggal_buka' => Carbon::now()->startOfDay(),
                'tanggal_tutup' => Carbon::now()->addDays(30)->endOfDay(),
                'harga' => 50000000,
                'jenis_pembayaran' => 'Uang Pendaftaran',
                'tujuan_rekening' => 'Bank BCA No.0125251 (SMK ANTARTIKA 1)',
                'is_active' => true,
            ],
            [
                'nama_gelombang' => 'Gelombang 2',
                'nomor_gelombang' => 2,
                'tanggal_buka' => Carbon::now()->addDays(31)->startOfDay(),
                'tanggal_tutup' => Carbon::now()->addDays(60)->endOfDay(),
                'harga' => 50000000,
                'jenis_pembayaran' => 'Uang Pendaftaran',
                'tujuan_rekening' => 'Bank BCA No.0125251 (SMK ANTARTIKA 1)',
                'is_active' => true,
            ],
            [
                'nama_gelombang' => 'Gelombang 3',
                'nomor_gelombang' => 3,
                'tanggal_buka' => Carbon::now()->addDays(61)->startOfDay(),
                'tanggal_tutup' => Carbon::now()->addDays(90)->endOfDay(),
                'harga' => 50000000,
                'jenis_pembayaran' => 'Uang Pendaftaran',
                'tujuan_rekening' => 'Bank BCA No.0125251 (SMK ANTARTIKA 1)',
                'is_active' => false,
            ],
        ];

        foreach ($gelombang as $item) {
            Gelombang::firstOrCreate(
                ['nomor_gelombang' => $item['nomor_gelombang']],
                $item
            );
        }
    }
}
