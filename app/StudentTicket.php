<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\StudentTicket
 *
 * @property int $id
 * @property string|null $student_nid 對應學生
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $nid
 * @property-read \App\Student|null $student
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentTicket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentTicket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentTicket query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentTicket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentTicket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentTicket whereStudentNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentTicket whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StudentTicket extends Model
{
    protected $fillable = [
        'id',
        'student_nid',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_nid', 'nid');
    }

    /**
     * @return string
     */
    public function getNidAttribute()
    {
        return $this->student->nid;
    }
}
