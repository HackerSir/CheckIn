<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TeaParty
 *
 * @property int $club_id 對應社團
 * @property string $name 茶會名稱
 * @property \Illuminate\Support\Carbon|null $start_at 開始時間
 * @property \Illuminate\Support\Carbon|null $end_at 結束時間
 * @property string $location 地點
 * @property string|null $url 網址
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Club $club
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeaParty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeaParty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeaParty query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeaParty whereClubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeaParty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeaParty whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeaParty whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeaParty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeaParty whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeaParty whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeaParty whereUrl($value)
 * @mixin \Eloquent
 */
class TeaParty extends Model
{
    protected $primaryKey = 'club_id';
    public $incrementing = false;

    protected $fillable = [
        'club_id',
        'name',
        'start_at',
        'end_at',
        'location',
        'url',
    ];

    protected $dates = [
        'start_at',
        'end_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
