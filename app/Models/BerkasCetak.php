<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasCetak extends Model
{
    use HasFactory;

    protected $table = 'berkas_cetaks';

    protected $fillable = [
        'pendaftaran_id',
        'jenis_berkas_id',
        'path',
        'meta',
        'tanggal_cetak',
        'dibuat_oleh',
    ];

    protected $casts = [
        'meta' => 'json',
        'tanggal_cetak' => 'datetime',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function jenisBerkas()
    {
        return $this->belongsTo(JenisBerkas::class, 'jenis_berkas_id');
    }

    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
