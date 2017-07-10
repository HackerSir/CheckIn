<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booth extends Model
{
    protected $fillable = [
        'name',
        'longitude',
        'latitude',
    ];
}
