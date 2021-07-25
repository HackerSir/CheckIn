<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

/**
 * App\Models\DataUpdateRequest
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $club_id
 * @property string $reason
 * @property string|null $submit_at
 * @property int|null $reviewer_id
 * @property string|null $review_at
 * @property bool|null $review_result
 * @property string|null $review_comment
 * @property string|null $original_description
 * @property string|null $original_url
 * @property string|null $description
 * @property string|null $url
 * @property string|null $original_extra_info
 * @property string|null $extra_info
 * @property string|null $original_custom_question
 * @property string|null $custom_question
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read Club $club
 * @property-read string $show_result
 * @property-read ImgurImage|null $imgurImage
 * @property-read ImgurImage|null $originalImgurImage
 * @property-read User|null $reviewer
 * @property-read User|null $user
 * @method static Builder|DataUpdateRequest newModelQuery()
 * @method static Builder|DataUpdateRequest newQuery()
 * @method static Builder|DataUpdateRequest query()
 * @method static Builder|DataUpdateRequest whereClubId($value)
 * @method static Builder|DataUpdateRequest whereCreatedAt($value)
 * @method static Builder|DataUpdateRequest whereCustomQuestion($value)
 * @method static Builder|DataUpdateRequest whereDescription($value)
 * @method static Builder|DataUpdateRequest whereExtraInfo($value)
 * @method static Builder|DataUpdateRequest whereId($value)
 * @method static Builder|DataUpdateRequest whereOriginalCustomQuestion($value)
 * @method static Builder|DataUpdateRequest whereOriginalDescription($value)
 * @method static Builder|DataUpdateRequest whereOriginalExtraInfo($value)
 * @method static Builder|DataUpdateRequest whereOriginalUrl($value)
 * @method static Builder|DataUpdateRequest whereReason($value)
 * @method static Builder|DataUpdateRequest whereReviewAt($value)
 * @method static Builder|DataUpdateRequest whereReviewComment($value)
 * @method static Builder|DataUpdateRequest whereReviewResult($value)
 * @method static Builder|DataUpdateRequest whereReviewerId($value)
 * @method static Builder|DataUpdateRequest whereSubmitAt($value)
 * @method static Builder|DataUpdateRequest whereUpdatedAt($value)
 * @method static Builder|DataUpdateRequest whereUrl($value)
 * @method static Builder|DataUpdateRequest whereUserId($value)
 * @mixin Eloquent
 */
class DataUpdateRequest extends LoggableModel
{
    use LegacySerializeDate;

    protected static $logName = 'data-update-request';
    protected $fillable = [
        'user_id',
        'club_id',
        'reason',
        'submit_at',
        'reviewer_id',
        'review_at',
        'review_result',
        'review_comment',
        'original_description',
        'original_extra_info',
        'original_url',
        'original_custom_question',
        'description',
        'extra_info',
        'url',
        'custom_question',
    ];

    protected $casts = [
        'review_result' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function imgurImage()
    {
        return $this->morphOne(ImgurImage::class, 'club')->where('memo', 'new');
    }

    public function originalImgurImage()
    {
        return $this->morphOne(ImgurImage::class, 'club')->where('memo', 'original');
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    /**
     * @return string
     */
    public function getShowResultAttribute()
    {
        if (is_null($this->review_result)) {
            return '<span class="text-info"><i class="fas fa-fw fa-question mr-2"></i>等待審核</span>';
        }
        if ($this->review_result) {
            return '<span class="text-success"><i class="fas fa-fw fa-check mr-2"></i>通過</span>';
        }

        return '<span class="text-danger"><i class="fas fa-fw fa-times mr-2"></i>不通過</span>';
    }

    protected function getNameForActivityLog(): string
    {
        return $this->club->name . ' 的資料更新申請';
    }
}
