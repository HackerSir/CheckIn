<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\StudentSurvey
 *
 * @property int $id
 * @property int $student_id
 * @property string|null $student_nid 對應學生
 * @property int $rating 星等評價
 * @property string|null $comment 意見與建議
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $stars
 * @property-read \App\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentSurvey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentSurvey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentSurvey query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentSurvey whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentSurvey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentSurvey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentSurvey whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentSurvey whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentSurvey whereStudentNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StudentSurvey whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StudentSurvey extends Model
{
    protected $fillable = [
        'student_id',
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
}
