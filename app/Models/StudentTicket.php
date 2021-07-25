<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

/**
 * App\Models\StudentTicket
 *
 * @property int $id
 * @property string|null $student_nid
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read string $nid
 * @property-read Student|null $student
 * @method static Builder|StudentTicket newModelQuery()
 * @method static Builder|StudentTicket newQuery()
 * @method static Builder|StudentTicket query()
 * @method static Builder|StudentTicket whereCreatedAt($value)
 * @method static Builder|StudentTicket whereId($value)
 * @method static Builder|StudentTicket whereStudentNid($value)
 * @method static Builder|StudentTicket whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StudentTicket extends LoggableModel
{
    use LegacySerializeDate;

    protected static $logName = 'student-ticket';
    protected $fillable = [
        'id',
        'student_nid',
    ];

    /**
     * @return BelongsTo|Builder
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
