<?php

namespace App;

/**
 * App\StudentTicket
 *
 * @property int $id
 * @property string|null $student_nid 對應學生
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read string $nid
 * @property-read \App\Student|null $student
 * @method static \Illuminate\Database\Eloquent\Builder|StudentTicket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentTicket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentTicket query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentTicket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentTicket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentTicket whereStudentNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentTicket whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StudentTicket extends LoggableModel
{
    protected static $logName = 'student-ticket';
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

    protected function getNameForActivityLog(): string
    {
        return $this->name . '的學生抽獎編號';
    }
}
