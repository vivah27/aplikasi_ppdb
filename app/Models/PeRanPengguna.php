<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeRanPengguna extends Model
{
    use HasFactory;

    protected $table = 'peran_pengguna';

    protected $fillable = [
        'pengguna_id',
        'peran_id',
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function peran()
    {
        return $this->belongsTo(Peran::class, 'peran_id');
    }
}
