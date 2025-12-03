<?php

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;

class TestInsertPembayaran extends Command
{
    protected $signature = 'test:pembayaran';
    protected $description = 'Insert test pembayaran for Denico';

    public function handle()
    {
        $user = User::where('email', 'denicottuesdyoesmana@gmail.com')->first();
        if ($user) {
            $siswa = Siswa::where('pengguna_id', $user->id)->first();
            if ($siswa) {
                $pendaftaran = Pendaftaran::where('siswa_id', $siswa->id)->first();
                if ($pendaftaran) {
                    $this->info("Pendaftaran ID: " . $pendaftaran->id);
                    $pembayaran = Pembayaran::where('pendaftaran_id', $pendaftaran->id)->first();
                    if ($pembayaran) {
                        $this->info("Pembayaran sudah ada! ID: " . $pembayaran->id . ", Status: " . $pembayaran->status);
                    } else {
                        $p = Pembayaran::create([
                            'pendaftaran_id' => $pendaftaran->id,
                            'nama' => 'Pembayaran Pendaftaran - ' . $pendaftaran->id,
                            'metode' => 'Transfer Bank',
                            'jumlah' => 500000,
                            'status' => 'Terverifikasi',
                            'catatan' => 'Test - Sudah diverifikasi admin',
                        ]);
                        $this->info("Pembayaran berhasil dibuat! ID: " . $p->id . ", Status: " . $p->status);
                    }
                } else {
                    $this->error("Pendaftaran tidak ditemukan");
                }
            } else {
                $this->error("Siswa tidak ditemukan");
            }
        } else {
            $this->error("User tidak ditemukan");
        }
    }
}


