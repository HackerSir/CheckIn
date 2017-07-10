<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'nid',
        'name',
        'class',
        'unit_name',
        'dept_name',
        'in_year',
        'gender',
    ];
}
