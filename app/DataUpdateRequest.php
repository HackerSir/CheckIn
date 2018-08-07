<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DataUpdateRequest
 *
 * @property int $id
 * @property int|null $user_id 申請者
 * @property int $club_id 社團
 * @property string $reason 申請理由
 * @property string|null $submit_at 申請提交時間
 * @property int|null $reviewer_id 審核者
 * @property string|null $review_at 審核時間
 * @property int|null $review_result 審核通過
 * @property string|null $review_comment 審核評語
 * @property string|null $original_description 原簡介
 * @property string|null $original_url 原網址
 * @property string|null $original_image_url 原圖片網址
 * @property string|null $description 簡介
 * @property string|null $url 網址
 * @property string|null $image_url 圖片網址
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Club $club
 * @property-read \App\User|null $reviewer
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataUpdateRequest whereClubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataUpdateRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataUpdateRequest whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataUpdateRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataUpdateRequest whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataUpdateRequest whereOriginalDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataUpdateRequest whereOriginalImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataUpdateRequest whereOriginalUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataUpdateRequest whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataUpdateRequest whereReviewAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataUpdateRequest whereReviewComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataUpdateRequest whereReviewResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataUpdateRequest whereReviewerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataUpdateRequest whereSubmitAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataUpdateRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataUpdateRequest whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataUpdateRequest whereUserId($value)
 * @mixin \Eloquent
 */
class DataUpdateRequest extends Model
{
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
        'original_url',
        'original_image_url',
        'description',
        'url',
        'image_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
