<?php

namespace App;

use App\Traits\LegacySerializeDate;

/**
 * App\ClubSurvey
 *
 * @property int $id
 * @property int $user_id
 * @property int $club_id
 * @property int $rating 星等評價
 * @property string|null $comment 意見與建議
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Club $club
 * @property-read string $stars
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ClubSurvey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClubSurvey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClubSurvey query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClubSurvey whereClubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClubSurvey whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClubSurvey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClubSurvey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClubSurvey whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClubSurvey whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClubSurvey whereUserId($value)
 * @mixin \Eloquent
 */
class ClubSurvey extends LoggableModel
{
    use LegacySerializeDate;

    protected static $logName = 'club-survey';
    protected $fillable = [
        'user_id',
        'club_id',
        'rating',
        'comment',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
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
        return $this->user->display_name . '的社團問卷';
    }
}
