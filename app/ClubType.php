<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClubType extends Model
{
    protected $fillable = [
        'name',
        'target',
        'color',
        'is_counted',
    ];
}
