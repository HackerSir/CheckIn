<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use App\Traits\LogModelEvent;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\DataUpdateRequest
 *
 * @property int $id
 * @property int|null $user_id 申請者
 * @property int $club_id 社團
 * @property string $reason 申請理由
 * @property string|null $submit_at 申請提交時間
 * @property int|null $reviewer_id 審核者
 * @property string|null $review_at 審核時間
 * @property bool|null $review_result 審核通過
 * @property string|null $review_comment 審核評語
 * @property string|null $original_description 原簡介
 * @property string|null $original_url 原網址
 * @property string|null $description 簡介
 * @property string|null $url 網址
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $original_extra_info 原額外資訊
 * @property string|null $extra_info 額外資訊
 * @property string|null $original_custom_question 原自訂問題
 * @property string|null $custom_question 自訂問題
 * @property-read Collection|\App\Models\ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Club $club
 * @property-read string $show_result 審核結果 HTML 標籤
 * @property-read \App\Models\ImgurImage|null $imgurImage
 * @property-read \App\Models\ImgurImage|null $originalImgurImage
 * @property-read \App\Models\User|null $reviewer
 * @property-read \App\Models\User|null $user
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
class DataUpdateRequest extends Model
{
    use LogModelEvent;
    use LegacySerializeDate;

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
     * @comment 審核結果 HTML 標籤
     *
     * @return string
     */
    public function getShowResultAttribute(): string
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
