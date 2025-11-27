<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    use HasFactory;

    // migrations create the table as `metode_pembayarans`
    protected $table = 'metode_pembayarans';
    protected $fillable = ['kode', 'label'];
}
