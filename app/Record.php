<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'student_id',
        'club_id',
        'ip',
    ];
}
