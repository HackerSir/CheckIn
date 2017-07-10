<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Ticket
 *
 * @property int $id
 * @property int|null $student_id 對應學生
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticket whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ticket extends Model
{
    protected $fillable = [
        'student_id',
    ];
}
