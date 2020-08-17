<?php

namespace App;

/**
 * App\StudentSurvey
 *
 * @property int $id
 * @property string|null $student_nid 對應學生
 * @property int $rating 星等評價
 * @property string|null $comment 意見與建議
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read string $stars
 * @property-read \App\Student|null $student
 * @method static \Illuminate\Database\Eloquent\Builder|StudentSurvey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentSurvey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentSurvey query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentSurvey whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentSurvey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentSurvey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentSurvey whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentSurvey whereStudentNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentSurvey whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StudentSurvey extends LoggableModel
{
    protected static $logName = 'student-survey';
    protected $fillable = [
        'student_nid',
        'rating',
        'comment',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_nid', 'nid');
    }

    /**
     * @return string
     */
    public function getStarsAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    protected function getNameForActivityLog(): string
    {
        return $this->student->display_name . ' 的學生問卷';
    }
}
