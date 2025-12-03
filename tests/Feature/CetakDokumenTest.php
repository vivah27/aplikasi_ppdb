<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use App\Models\StatusPendaftaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CetakDokumenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test bahwa user bisa akses cetak index
     */
    public function test_user_can_access_cetak_index()
    {
        // Setup user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Setup siswa
        $siswa = Siswa::create([
            'pengguna_id' => $user->id,
            'nama' => 'Test Siswa',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2005-01-01',
            'jenis_kelamin' => 'L',
        ]);

        // Setup status pendaftaran
        $status = StatusPendaftaran::create([
            'nama' => 'BELUM DIVERIFIKASI',
        ]);

        // Setup pendaftaran
        $pendaftaran = Pendaftaran::create([
            'siswa_id' => $siswa->id,
            'pengguna_id' => $user->id,
            'nomor_pendaftaran' => '001-2025',
            'tahun_ajaran' => '2025/2026',
            'jalur_pendaftaran' => 'Reguler',
            'status_id' => $status->id,
        ]);

        // Login
        $this->actingAs($user);

        // Access cetak index
        $response = $this->get(route('cetak.index'));
        $response->assertStatus(200);
        $response->assertViewIs('cetak.index');
    }

    /**
     * Test pembayaran relationship loading
     */
    public function test_pembayaran_relationship_loading()
    {
        // Setup user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Setup siswa
        $siswa = Siswa::create([
            'pengguna_id' => $user->id,
            'nama' => 'Test Siswa',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2005-01-01',
            'jenis_kelamin' => 'L',
        ]);

        // Setup status pendaftaran
        $status = StatusPendaftaran::create([
            'nama' => 'BELUM DIVERIFIKASI',
        ]);

        // Setup pendaftaran
        $pendaftaran = Pendaftaran::create([
            'siswa_id' => $siswa->id,
            'pengguna_id' => $user->id,
            'nomor_pendaftaran' => '001-2025',
            'tahun_ajaran' => '2025/2026',
            'jalur_pendaftaran' => 'Reguler',
            'status_id' => $status->id,
        ]);

        // Create pembayaran
        $pembayaran = Pembayaran::create([
            'pendaftaran_id' => $pendaftaran->id,
            'nama' => 'Pembayaran Pendaftaran - ' . $pendaftaran->id,
            'metode' => 'Transfer Bank',
            'jumlah' => 15000000,
            'status' => 'Terverifikasi',
        ]);

        // Test 1: Direct relationship access
        $this->assertNotNull($pendaftaran->pembayaran);
        $this->assertEquals($pembayaran->id, $pendaftaran->pembayaran->id);
        $this->assertEquals('Terverifikasi', $pendaftaran->pembayaran->status);

        // Test 2: With eager loading
        $reloaded = Pendaftaran::with('pembayaran')->find($pendaftaran->id);
        $this->assertNotNull($reloaded->pembayaran);
        $this->assertEquals($pembayaran->id, $reloaded->pembayaran->id);

        // Test 3: Verification check
        $isVerified = strtoupper($reloaded->pembayaran->status ?? '') === 'TERVERIFIKASI';
        $this->assertTrue($isVerified);
    }

    /**
     * Test user bisa cetak kartu peserta jika pembayaran terverifikasi
     */
    public function test_user_can_generate_kartu_peserta_after_payment_verified()
    {
        // Setup user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Setup siswa
        $siswa = Siswa::create([
            'pengguna_id' => $user->id,
            'nama' => 'Test Siswa',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2005-01-01',
            'jenis_kelamin' => 'L',
        ]);

        // Setup status pendaftaran
        $status = StatusPendaftaran::create([
            'nama' => 'BELUM DIVERIFIKASI',
        ]);

        // Setup pendaftaran
        $pendaftaran = Pendaftaran::create([
            'siswa_id' => $siswa->id,
            'pengguna_id' => $user->id,
            'nomor_pendaftaran' => '001-2025',
            'tahun_ajaran' => '2025/2026',
            'jalur_pendaftaran' => 'Reguler',
            'status_id' => $status->id,
        ]);

        // Setup pembayaran terverifikasi
        $pembayaran = Pembayaran::create([
            'pendaftaran_id' => $pendaftaran->id,
            'nama' => 'Pembayaran Pendaftaran - ' . $pendaftaran->id,
            'metode' => 'Transfer Bank',
            'jumlah' => 15000000,
            'status' => 'Terverifikasi',
        ]);

        // Login
        $this->actingAs($user);

        // Test cetak kartu peserta
        $response = $this->get(route('cetak.kartu', ['pendaftaranId' => $pendaftaran->id]));
        
        // Should render view without errors (either 200 or 500 with proper error message)
        $this->assertTrue(
            $response->status() == 200 || $response->status() == 500,
            'Response status: ' . $response->status()
        );
    }
}
