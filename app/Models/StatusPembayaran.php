<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPembayaran extends Model
{
    use HasFactory;

    // migrations create the table as `status_pembayarans`
    protected $table = 'status_pembayarans';
    protected $fillable = ['kode', 'label'];
}
