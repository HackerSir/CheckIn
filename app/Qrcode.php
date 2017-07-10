<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qrcode extends Model
{
    protected $fillable = [
        'code',
        'bind_at',
    ];
}
