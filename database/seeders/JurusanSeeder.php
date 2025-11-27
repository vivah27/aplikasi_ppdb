<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode_jurusan' => 'TKJ', 'nama_jurusan' => 'Teknik Komputer Jaringan', 'deskripsi' => 'Teknologi komputer & jaringan', 'kuota' => 36, 'is_active' => true],
            ['kode_jurusan' => 'RPL', 'nama_jurusan' => 'Rekayasa Perangkat Lunak', 'deskripsi' => 'Pengembangan perangkat lunak', 'kuota' => 36, 'is_active' => true],
            ['kode_jurusan' => 'MM',  'nama_jurusan' => 'Multimedia', 'deskripsi' => 'Desain grafis dan multimedia', 'kuota' => 30, 'is_active' => true],
            ['kode_jurusan' => 'AKL', 'nama_jurusan' => 'Akuntansi dan Keuangan Lembaga', 'deskripsi' => 'Akuntansi dan keuangan', 'kuota' => 30, 'is_active' => true],
            ['kode_jurusan' => 'OTKP','nama_jurusan' => 'Otomatisasi & Tata Kelola Perkantoran', 'deskripsi' => 'Administrasi perkantoran', 'kuota' => 24, 'is_active' => true],
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