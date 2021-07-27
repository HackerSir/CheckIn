<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

/**
 * App\Models\StudentSurvey
 *
 * @property int $id
 * @property string|null $student_nid 對應學生
 * @property int $rating 星等評價
 * @property string|null $comment 意見與建議
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read string $stars 星等
 * @property-read \App\Models\Student|null $student
 * @method static \Database\Factories\StudentSurveyFactory factory(...$parameters)
 * @method static Builder|StudentSurvey newModelQuery()
 * @method static Builder|StudentSurvey newQuery()
 * @method static Builder|StudentSurvey query()
 * @method static Builder|StudentSurvey whereComment($value)
 * @method static Builder|StudentSurvey whereCreatedAt($value)
 * @method static Builder|StudentSurvey whereId($value)
 * @method static Builder|StudentSurvey whereRating($value)
 * @method static Builder|StudentSurvey whereStudentNid($value)
 * @method static Builder|StudentSurvey whereUpdatedAt($value)
 * @mixin Eloquent
 */
class StudentSurvey extends LoggableModel
{
    use LegacySerializeDate;
    use HasFactory;

    protected static $logName = 'student-survey';
    protected $fillable = [
        'student_nid',
        'rating',
        'comment',
    ];

    /**
     * @return BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_nid', 'nid');
    }

    /**
     * @comment 星等
     *
     * @return string
     */
    public function getStarsAttribute(): string
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    protected function getNameForActivityLog(): string
    {
        return $this->student->display_name . ' 的學生問卷';
    }
}
