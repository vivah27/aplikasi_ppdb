<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;

class CheckPembayaranRelation extends Command
{
    protected $signature = 'app:check-pembayaran-relation';
    protected $description = 'Check dan debug pembayaran relationship';

    public function handle()
    {
        $this->info('Checking pembayaran relationships...');
        $this->newLine();

        // Find Denico
        $user = User::where('email', 'denicottuesdyoesmana@gmail.com')->first();
        
        if (!$user) {
            $this->error('User denicottuesdyoesmana@gmail.com not found');
            return 1;
        }

        $this->info("User found: {$user->email} (ID: {$user->id})");

        // Find siswa
        $siswa = Siswa::where('pengguna_id', $user->id)->first();
        
        if (!$siswa) {
            $this->error('Siswa not found for this user');
            return 1;
        }

        $this->info("Siswa found: {$siswa->nama} (ID: {$siswa->id})");

        // Find pendaftaran
        $pendaftaran = Pendaftaran::where('siswa_id', $siswa->id)->first();
        
        if (!$pendaftaran) {
            $this->error('Pendaftaran not found for this siswa');
            return 1;
        }

        $this->info("Pendaftaran found: ID={$pendaftaran->id}, Nomor={$pendaftaran->nomor_pendaftaran}");
        $this->newLine();

        // Direct DB query
        $this->info('Checking with direct DB query:');
        $pembayaranDb = DB::table('pembayaran')
            ->where('pendaftaran_id', $pendaftaran->id)
            ->first();
        
        if ($pembayaranDb) {
            $this->line('  ✓ Found in DB: ID=' . $pembayaranDb->id . ', Status=' . $pembayaranDb->status);
        } else {
            $this->error('  ✗ NOT found in DB');
        }

        // Via relationship
        $this->info('Checking via hasOne() relationship:');
        $pembayaranRel = $pendaftaran->pembayaran;
        
        if ($pembayaranRel) {
            $this->line('  ✓ Found via relationship: ID=' . $pembayaranRel->id . ', Status=' . $pembayaranRel->status);
        } else {
            $this->error('  ✗ NOT found via relationship (NULL)');
        }

        // Via with()
        $this->info('Checking via with(pembayaran):');
        $pendaftaranWith = Pendaftaran::where('id', $pendaftaran->id)
            ->with('pembayaran')
            ->first();
        
        if ($pendaftaranWith && $pendaftaranWith->pembayaran) {
            $this->line('  ✓ Found with with(): ID=' . $pendaftaranWith->pembayaran->id . ', Status=' . $pendaftaranWith->pembayaran->status);
        } else {
            $this->error('  ✗ NOT found with with() (NULL)');
        }

        // Check all pembayaran records
        $this->info('All pembayaran records in database:');
        $allPembayaran = Pembayaran::all();
        
        if ($allPembayaran->count() == 0) {
            $this->warn('  No pembayaran records found');
        } else {
            foreach ($allPembayaran as $p) {
                $this->line("  - ID={$p->id}, pendaftaran_id={$p->pendaftaran_id}, status={$p->status}, metode={$p->metode}");
            }
        }

        // Check pembayaran table structure
        $this->info('Pembayaran table columns:');
        $columns = DB::select("DESCRIBE pembayaran");
        
        foreach ($columns as $col) {
            $this->line("  - {$col->Field} ({$col->Type})");
        }

        return 0;
    }
}
