<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $table = 'dokumens';

    protected $fillable = [
        'siswa_id',
        'jenis_dokumen_id',
        'path',
        'status_verifikasi_id',
        'catatan',
        'dibuat_oleh',
        'diperbarui_oleh',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function jenisDokumen()
    {
        return $this->belongsTo(JenisDokumen::class, 'jenis_dokumen_id');
    }

    public function statusVerifikasi()
    {
        return $this->belongsTo(StatusVerifikasi::class, 'status_verifikasi_id');
    }

    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function diperbaruiOleh()
    {
        return $this->belongsTo(User::class, 'diperbarui_oleh');
    }
}
