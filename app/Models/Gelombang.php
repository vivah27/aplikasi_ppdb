<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gelombang extends Model
{
    use HasFactory;

    protected $table = 'gelombang';

    protected $fillable = [
        'nama_gelombang',
        'nomor_gelombang',
        'tanggal_buka',
        'tanggal_tutup',
        'harga',
        'jenis_pembayaran',
        'tujuan_rekening',
        'is_active',
    ];

    protected $casts = [
        'tanggal_buka' => 'datetime',
        'tanggal_tutup' => 'datetime',
        'is_active' => 'boolean',
        'harga' => 'integer',
    ];

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'gelombang', 'nomor_gelombang');
    }

    /**
     * Cek apakah gelombang masih aktif (belum tutup)
     */
    public function isOpen(): bool
    {
        $now = now();
        return $this->tanggal_buka <= $now && $now <= $this->tanggal_tutup && $this->is_active;
    }

    /**
     * Cek apakah sudah ada pendaftar untuk gelombang ini
     */
    public function hasPendaftar(): bool
    {
        return $this->pendaftarans()->exists();
    }
}
