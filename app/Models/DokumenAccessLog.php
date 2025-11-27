<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenAccessLog extends Model
{
    protected $table = 'dokumen_access_logs';
    protected $guarded = [];
    public $timestamps = true;
}
