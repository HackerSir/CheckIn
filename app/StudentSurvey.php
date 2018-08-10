<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\StudentSurvey
 *
 * @property int $id
 * @property int $student_id
 * @property int $rating 星等評價
 * @property string|null $comment 意見與建議
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentSurvey whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentSurvey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentSurvey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentSurvey whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentSurvey whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentSurvey whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StudentSurvey extends Model
{
    protected $fillable = [
        'student_id',
        'rating',
        'comment',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}