<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDokumen extends Model
{
    use HasFactory;

    protected $table = 'jenis_dokumens';

    protected $fillable = [
        'nama',
        'deskripsi',
        'wajib',
    ];

    protected $casts = [
        'wajib' => 'boolean',
    ];

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'jenis_dokumen_id');
    }
}
