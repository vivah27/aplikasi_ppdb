<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusans'; // Ubah dari 'jurusan' ke 'jurusans'

    protected $fillable = [
        'kode_jurusan',
        'nama_jurusan',
        'deskripsi',
        'kuota',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'jurusan_pilihan_1', 'id');
    }
}