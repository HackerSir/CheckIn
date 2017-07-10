<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $fillable = [
        'name',
        'club_type_id',
        'description',
        'url',
        'image_url',
    ];
}
