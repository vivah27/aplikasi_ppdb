<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusVerifikasi extends Model
{
    use HasFactory;

    protected $table = 'status_verifikasis';

    protected $fillable = [
        'kode',
        'label',
    ];

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'status_verifikasi_id');
    }

    public function verifikasi()
    {
        return $this->hasMany(Verifikasi::class, 'status_id');
    }
}
