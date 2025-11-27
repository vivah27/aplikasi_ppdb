<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas'; // Ubah dari 'siswa' ke 'siswas'

    protected $fillable = [
        'nama_lengkap',
        'nisn',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_telepon',
        'email',
        'asal_sekolah',
        'jurusan_id',
        'foto',
        'bio',
        'pengguna_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class);
    }
}