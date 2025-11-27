<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBerkas extends Model
{
    use HasFactory;

    protected $table = 'jenis_berkas';

    protected $fillable = [
        'kode',
        'label',
        'nama',
    ];

    public function berkasCetak()
    {
        return $this->hasMany(BerkasCetak::class, 'jenis_berkas_id');
    }
}
