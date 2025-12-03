<?php

namespace App\Console\Commands;

use App\Models\Biodata;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Console\Command;

class CheckPhotoSync extends Command
{
    protected $signature = 'check:photo-sync';
    protected $description = 'Check photo synchronization between biodata and siswa';

    public function handle()
    {
        $this->info('=== CHECKING PHOTO SYNC ===\n');

        $users = User::all();
        $this->info('Total Users: ' . count($users) . '\n');

        foreach ($users as $user) {
            $this->line("=== USER: {$user->name} (ID: {$user->id}) ===");
            
            // Check biodata
            $biodata = Biodata::where('user_id', $user->id)->first();
            if ($biodata) {
                $this->line("  [BIODATA]");
                $this->line("    - Foto: " . ($biodata->foto ? "✓ " . $biodata->foto : "✗ NULL"));
                $this->line("    - Nama: {$biodata->nama_lengkap}");
            } else {
                $this->line("  [BIODATA] ✗ NOT FOUND");
            }
            
            // Check siswa
            $siswa = Siswa::where('pengguna_id', $user->id)->first();
            if ($siswa) {
                $this->line("  [SISWA]");
                $this->line("    - Foto: " . ($siswa->foto ? "✓ " . $siswa->foto : "✗ NULL"));
                $this->line("    - Nama: {$siswa->nama_lengkap}");
            } else {
                $this->line("  [SISWA] ✗ NOT FOUND");
            }
            
            // Check if photo file exists
            if ($biodata && $biodata->foto) {
                $path = 'storage/app/public/' . $biodata->foto;
                $exists = file_exists($path);
                $this->line("  [FILE CHECK]");
                $this->line("    - Path: {$path}");
                $this->line("    - Exists: " . ($exists ? "✓ YES" : "✗ NO"));
            }
            
            $this->line("");
        }

        $this->info("=== DONE ===");
    }
}
