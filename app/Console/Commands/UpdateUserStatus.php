<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pendaftaran;
use App\Models\StatusPendaftaran;

class UpdateUserStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ppdb:update-status {name} {status=DITERIMA}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status pendaftaran user berdasarkan nama. Contoh: php artisan ppdb:update-status "DENICO TUESDYOESMANA" DITERIMA';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $namaUser = $this->argument('name');
        $statusTarget = strtoupper($this->argument('status'));

        // Cari pendaftaran berdasarkan nama
        $pendaftaran = Pendaftaran::whereHas('siswa', function ($query) use ($namaUser) {
            $query->where('nama_lengkap', 'like', "%{$namaUser}%");
        })->first();

        if (!$pendaftaran) {
            $this->error("Pendaftaran untuk '{$namaUser}' tidak ditemukan.");
            return 1;
        }

        // Cari status
        $status = StatusPendaftaran::where('label', $statusTarget)->first();
        if (!$status) {
            $this->error("Status '{$statusTarget}' tidak ditemukan di database.");
            $this->line('Status yang tersedia:');
            StatusPendaftaran::all()->each(fn($s) => $this->line("  - {$s->label}"));
            return 1;
        }

        // Update
        $oldStatus = $pendaftaran->statusPendaftaran->label ?? 'BELUM DIVERIFIKASI';
        $pendaftaran->status_id = $status->id;
        $pendaftaran->save();

        $this->info("✓ Pendaftaran berhasil diupdate!");
        $this->line("  ID: {$pendaftaran->id}");
        $this->line("  Nama: {$pendaftaran->siswa->nama_lengkap}");
        $this->line("  Status Lama: {$oldStatus}");
        $this->line("  Status Baru: {$statusTarget}");
        $this->line("  Tahun Ajaran: {$pendaftaran->tahun_ajaran}");

        return 0;
    }
}
