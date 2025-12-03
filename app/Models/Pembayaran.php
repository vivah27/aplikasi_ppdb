<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'pendaftaran_id',
        'metode_pembayaran_id',
        'status_pembayaran_id',
        'jumlah',
        'tanggal_bayar',
        'bukti_pembayaran',
        'keterangan',
        'nama',
        'metode',
        'bukti',
        'status',
        'catatan',
        'nama_bank',
        'nomor_rekening',
        'atas_nama_rekening',
        'jenis_ewallet',
        'nomor_ewallet',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'tanggal_bayar' => 'datetime',
    ];

    /**
     * Relasi ke Pendaftaran
     */
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    /**
     * Relasi ke MetodePembayaran
     */
    public function metodePembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class);
    }

    /**
     * Relasi ke StatusPembayaran
     */
    public function statusPembayaran()
    {
        return $this->belongsTo(StatusPembayaran::class, 'status_pembayaran_id');
    }

    /**
     * Check if pembayaran sudah terverifikasi dan lunas
     */
    public function isTerverifikasi()
    {
        // Check by status field (legacy)
        if ($this->status == 'Terverifikasi' || $this->status == 'LUNAS') {
            return true;
        }

        // Check by status_pembayaran_id (new schema)
        if ($this->statusPembayaran && in_array($this->statusPembayaran->nama, ['LUNAS', 'Terverifikasi'])) {
            return true;
        }

        return false;
    }
}