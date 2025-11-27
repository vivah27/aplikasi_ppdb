<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SyncRolesSeeder extends Seeder
{
    /**
     * Sync users.role into peran_pengguna table (non-destructive)
     */
    public function run(): void
    {
        $users = DB::table('users')->select('id', 'role')->get();


        foreach ($users as $u) {
            if (!$u->role) continue;

            // normalize role name (try to match existing peran.nama case-insensitively)
            $roleStr = trim($u->role);
            $roleCandidate = mb_strtolower($roleStr);

            $peran = DB::table('perans')
                ->whereRaw('LOWER(nama) = ?', [$roleCandidate])
                ->first();

            // If peran not found, create it using capitalized role string
            if (!$peran) {
                $createdId = DB::table('perans')->insertGetId([
                    'nama' => ucfirst($roleStr),
                    'deskripsi' => 'Auto-created role for ' . $roleStr,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $peran = DB::table('perans')->where('id', $createdId)->first();
            }

            // insert mapping if not exists
            $exists = DB::table('peran_pengguna')
                ->where('pengguna_id', $u->id)
                ->where('peran_id', $peran->id)
                ->exists();

            if (!$exists) {
                DB::table('peran_pengguna')->insert([
                    'pengguna_id' => $u->id,
                    'peran_id' => $peran->id,
                ]);
            }
        }

        $this->command->info('SyncRolesSeeder completed.');
    }
}
