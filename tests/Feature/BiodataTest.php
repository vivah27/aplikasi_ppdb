<?php

use App\Models\User;

/**
 * Integration test for biodata store.
 *
 * Note: This test requires a real test database (MySQL or a SQLite file) and
 * running migrations that are compatible with the DB. The project's default
 * in-memory sqlite may fail due to some migrations using ALTER TABLE statements
 * not supported by SQLite in-memory. Run tests with a proper test DB to execute.
 */

it('allows an authenticated user with role user to submit biodata', function () {
    // Skip this DB-heavy integration test when using in-memory sqlite where some migrations
    // (alter table statements) may be incompatible. Run this test using a MySQL/SQLite file
    // or proper test DB in CI.
    if (config('database.default') === 'sqlite') {
        $this->markTestSkipped('Skipping DB integration test on sqlite in this environment.');
    }

    // create a user with role 'user'
    $user = User::factory()->create(['role' => 'user']);

    $payload = [
        'nama_lengkap' => 'Test User',
        'nisn' => '1234567890',
        'nik' => '1234567890123456',
        'tempat_lahir' => 'Sidoarjo',
        'tanggal_lahir' => '2005-05-12',
        'jenis_kelamin' => 'Laki-laki',
        'agama' => 'Islam',
        'alamat' => 'Jl. Contoh No.1',
        'no_hp' => '081234567890',
        'nama_ayah' => 'Bapak',
        'pekerjaan_ayah' => 'Pekerjaan',
        'nama_ibu' => 'Ibu',
        'pekerjaan_ibu' => 'Pekerjaan',
        'no_hp_wali' => '081234567891',
        'asal_sekolah' => 'SMP Negeri',
        'npsn' => '200088',
        'tahun_lulus' => '2023',
    ];

    $response = actingAs($user)->post(route('biodata.store'), $payload);

    $response->assertRedirect(route('user.pembayaran.create'));

    $this->assertDatabaseHas('biodatas', [
        'user_id' => $user->id,
        'nik' => $payload['nik'],
        'nama_lengkap' => $payload['nama_lengkap'],
    ]);
});
