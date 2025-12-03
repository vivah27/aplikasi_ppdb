<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode_jurusan' => 'AKL', 'nama_jurusan' => 'Akuntansi dan Keuangan Lembaga', 'deskripsi' => 'Bidang Keahlian Bisnis dan Manajemen', 'kuota' => 30, 'is_active' => true],
            ['kode_jurusan' => 'MM',  'nama_jurusan' => 'Multimedia', 'deskripsi' => 'Bidang Keahlian Teknologi Informasi dan Komunikasi', 'kuota' => 30, 'is_active' => true],
            ['kode_jurusan' => 'RPL', 'nama_jurusan' => 'Rekayasa Perangkat Lunak', 'deskripsi' => 'Bidang Keahlian Teknologi Informasi dan Komunikasi', 'kuota' => 36, 'is_active' => true],
            ['kode_jurusan' => 'TKJ', 'nama_jurusan' => 'Teknik Komputer Jaringan', 'deskripsi' => 'Bidang Keahlian Teknologi Informasi dan Komunikasi', 'kuota' => 36, 'is_active' => true],
        ];

        foreach ($data as $row) {
            Jurusan::updateOrCreate(
                ['kode_jurusan' => $row['kode_jurusan']],
                $row
            );
        }

        $this->command->info('JurusanSeeder: inserted ' . count($data) . ' jurusan.');
    }
}