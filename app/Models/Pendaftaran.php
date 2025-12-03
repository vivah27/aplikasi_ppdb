<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftarans'; // Ubah dari 'pendaftaran' ke 'pendaftarans'

    protected $fillable = [
        'siswa_id',
        'pengguna_id',
        'nomor_pendaftaran',
        'tahun_ajaran',
        'jalur_pendaftaran',
        'gelombang',
        'jurusan_pilihan_1',
        'jurusan_pilihan_2',
        'status_id',
        'rata_nilai',
        'skor_seleksi',
        'tanggal_daftar',
        'dibuat_oleh',
        'diperbarui_oleh',
        'keterangan',
        'harga_gelombang',
        'jenis_pembayaran',
        'tujuan_rekening',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function statusPendaftaran()
    {
        return $this->belongsTo(StatusPendaftaran::class, 'status_id');
    }

    public function jurusanPilihan1()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_pilihan_1');
    }

    public function jurusanPilihan2()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_pilihan_2');
    }

    /**
     * Relasi ke jurusan yang diterima/dipilih
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_pilihan_1');
    }

    public function verifikasi()
    {
        return $this->hasMany(Verifikasi::class);
    }

    public function berkasCetak()
    {
        return $this->hasMany(BerkasCetak::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function gelombangData()
    {
        return $this->belongsTo(Gelombang::class, 'gelombang', 'nomor_gelombang');
    }

    public function biodata()
    {
        return $this->hasOneThrough(Biodata::class, User::class, 'id', 'user_id', 'pengguna_id', 'id');
    }

    public function biodata_siswa()
    {
        // Relasi ke biodata melalui siswa jika ada
        return $this->hasOneThrough(Biodata::class, Siswa::class, 'pengguna_id', 'user_id', 'siswa_id', 'id');
    }
}