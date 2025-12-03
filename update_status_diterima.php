<?php
// Script untuk update status pendaftaran menjadi DITERIMA

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/app.php';

use App\Models\Pendaftaran;
use App\Models\StatusPendaftaran;
use Illuminate\Support\Facades\DB;

// Cari user Denico (dari screenshot: denicotuesddyoesmana@gmail.com)
$pendaftaran = Pendaftaran::whereHas('siswa', function ($query) {
    $query->where('nama_lengkap', 'like', '%DENICO%');
})->first();

if (!$pendaftaran) {
    echo "Pendaftaran Denico tidak ditemukan\n";
    exit;
}

// Cari status DITERIMA
$statusDiterima = StatusPendaftaran::where('label', 'DITERIMA')->first();

if (!$statusDiterima) {
    // Jika tidak ada, buat baru
    $statusDiterima = StatusPendaftaran::create([
        'kode' => 'diterima',
        'label' => 'DITERIMA'
    ]);
    echo "Status DITERIMA dibuat: {$statusDiterima->id}\n";
} else {
    echo "Status DITERIMA ditemukan: {$statusDiterima->id}\n";
}

// Update pendaftaran
$pendaftaran->status_id = $statusDiterima->id;
$pendaftaran->save();

echo "✓ Pendaftaran ID {$pendaftaran->id} berhasil diupdate ke status DITERIMA\n";
echo "  Nama: {$pendaftaran->siswa->nama_lengkap}\n";
echo "  Tahun Ajaran: {$pendaftaran->tahun_ajaran}\n";
?>
