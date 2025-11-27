<?php

namespace Database\Seeders;

use App\Models\Peran;
use App\Models\StatusVerifikasi;
use App\Models\StatusPendaftaran;
use App\Models\JenisDokumen;
use App\Models\JenisBerkas;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Peran (Roles)
        $roles = [
            ['nama' => 'admin', 'deskripsi' => 'Administrator sistem PPDB'],
            ['nama' => 'user', 'deskripsi' => 'Pengguna/Siswa yang melakukan pendaftaran'],
            ['nama' => 'guru', 'deskripsi' => 'Guru pembimbing'],
            ['nama' => 'panitia', 'deskripsi' => 'Panitia PPDB'],
        ];

        foreach ($roles as $role) {
            Peran::firstOrCreate(
                ['nama' => $role['nama']],
                ['deskripsi' => $role['deskripsi']]
            );
        }

        // Seed Status Pendaftaran
        $statusPendaftaran = [
            ['kode' => 'diterima', 'label' => 'Diterima'],
            ['kode' => 'menunggu', 'label' => 'Menunggu'],
            ['kode' => 'ditolak', 'label' => 'Ditolak'],
        ];

        foreach ($statusPendaftaran as $status) {
            StatusPendaftaran::firstOrCreate(
                ['kode' => $status['kode']],
                ['label' => $status['label']]
            );
        }

        // Seed Status Verifikasi
        $statusVerifikasi = [
            ['kode' => 'pending', 'label' => 'Menunggu Verifikasi'],
            ['kode' => 'verified', 'label' => 'Terverifikasi'],
            ['kode' => 'rejected', 'label' => 'Ditolak'],
            ['kode' => 'revision', 'label' => 'Perlu Revisi'],
        ];

        foreach ($statusVerifikasi as $status) {
            StatusVerifikasi::firstOrCreate(
                ['kode' => $status['kode']],
                ['label' => $status['label']]
            );
        }

        // Seed Jenis Dokumen
        $jenisDokumen = [
            ['nama' => 'Fotokopi Akta Lahir', 'deskripsi' => 'Fotokopi sah akta lahir dari catatan sipil', 'wajib' => true],
            ['nama' => 'Fotokopi KTP/Paspor', 'deskripsi' => 'Fotokopi identitas diri siswa', 'wajib' => true],
            ['nama' => 'Fotokopi KK', 'deskripsi' => 'Fotokopi Kartu Keluarga', 'wajib' => true],
            ['nama' => 'Raport SMP', 'deskripsi' => 'Fotokopi raport semester terakhir SMP', 'wajib' => true],
            ['nama' => 'NISN', 'deskripsi' => 'Bukti NISN dari Kemendikbud', 'wajib' => true],
            ['nama' => 'Foto Siswa', 'deskripsi' => 'Foto 4x6 dengan latar belakang putih (3 lembar)', 'wajib' => true],
            ['nama' => 'Surat Kesehatan', 'deskripsi' => 'Surat keterangan kesehatan dari puskesmas', 'wajib' => false],
            ['nama' => 'Surat Prestasi', 'deskripsi' => 'Surat keterangan prestasi/penghargaan (jika ada)', 'wajib' => false],
        ];

        foreach ($jenisDokumen as $jenis) {
            JenisDokumen::firstOrCreate(
                ['nama' => $jenis['nama']],
                ['deskripsi' => $jenis['deskripsi'], 'wajib' => $jenis['wajib']]
            );
        }

        // Seed Jenis Berkas Cetak
        $jenisBerkas = [
            ['kode' => 'kartu_ujian', 'label' => 'Kartu Ujian'],
            ['kode' => 'bukti_daftar', 'label' => 'Bukti Pendaftaran'],
            ['kode' => 'surat_panggilan', 'label' => 'Surat Panggilan Ujian'],
            ['kode' => 'hasil_ujian', 'label' => 'Surat Hasil Ujian'],
            ['kode' => 'pengumuman_terima', 'label' => 'Pengumuman Penerimaan'],
        ];

        foreach ($jenisBerkas as $berkas) {
            JenisBerkas::firstOrCreate(
                ['kode' => $berkas['kode']],
                ['label' => $berkas['label']]
            );
        }

        echo "✓ Feature data seeded successfully!\n";
    }
}
