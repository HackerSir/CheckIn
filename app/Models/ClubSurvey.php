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
 * App\Models\ClubSurvey
 *
 * @property int $id
 * @property int $user_id
 * @property int $club_id
 * @property int $rating
 * @property string|null $comment
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read Club $club
 * @property-read string $stars
 * @property-read User $user
 * @method static Builder|ClubSurvey newModelQuery()
 * @method static Builder|ClubSurvey newQuery()
 * @method static Builder|ClubSurvey query()
 * @method static Builder|ClubSurvey whereClubId($value)
 * @method static Builder|ClubSurvey whereComment($value)
 * @method static Builder|ClubSurvey whereCreatedAt($value)
 * @method static Builder|ClubSurvey whereId($value)
 * @method static Builder|ClubSurvey whereRating($value)
 * @method static Builder|ClubSurvey whereUpdatedAt($value)
 * @method static Builder|ClubSurvey whereUserId($value)
 * @mixin Eloquent
 */
class ClubSurvey extends LoggableModel
{
    use LegacySerializeDate;
    use HasFactory;

    protected static $logName = 'club-survey';
    protected $fillable = [
        'user_id',
        'club_id',
        'rating',
        'comment',
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
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
