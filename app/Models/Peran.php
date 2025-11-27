<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peran extends Model
{
    use HasFactory;

    protected $table = 'perans';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    public function pengguna()
    {
        return $this->belongsToMany(User::class, 'peran_pengguna', 'peran_id', 'pengguna_id');
    }

    public function peranPengguna()
    {
        return $this->hasMany(PeRanPengguna::class);
    }
}
