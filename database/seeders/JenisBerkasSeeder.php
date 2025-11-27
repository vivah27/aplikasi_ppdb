<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisBerkas;

class JenisBerkasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisBerkas = [
            [
                'kode' => 'FORMULIR',
                'label' => 'Formulir Pendaftaran',
                'nama' => 'FORMULIR',
            ],
            [
                'kode' => 'KARTU_PESERTA',
                'label' => 'Kartu Peserta Ujian',
                'nama' => 'KARTU_PESERTA',
            ],
            [
                'kode' => 'SURAT_PENERIMAAN',
                'label' => 'Surat Penerimaan',
                'nama' => 'SURAT_PENERIMAAN',
            ],
            [
                'kode' => 'KUITANSI',
                'label' => 'Kuitansi Pembayaran',
                'nama' => 'KUITANSI',
            ],
            [
                'kode' => 'IJAZAH',
                'label' => 'Ijazah',
                'nama' => 'IJAZAH',
            ],
            [
                'kode' => 'AKTA_KELAHIRAN',
                'label' => 'Akta Kelahiran',
                'nama' => 'AKTA_KELAHIRAN',
            ],
            [
                'kode' => 'KTP',
                'label' => 'Kartu Tanda Penduduk',
                'nama' => 'KTP',
            ],
        ];

        foreach ($jenisBerkas as $berkas) {
            JenisBerkas::updateOrCreate(
                ['kode' => $berkas['kode']],
                [
                    'label' => $berkas['label'],
                    'nama' => $berkas['nama'],
                ]
            );
        }
    }
}
