<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ClubType
 *
 * @property int $id
 * @property string $name 名稱
 * @property int $target 過關需求該類型攤位數量
 * @property string $color 標籤顏色
 * @property int $is_counted 是否列入抽獎集點
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Club[] $clubs
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClubType whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClubType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClubType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClubType whereIsCounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClubType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClubType whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClubType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ClubType extends Model
{
    protected $fillable = [
        'name',
        'target',
        'color',
        'is_counted',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function clubs()
    {
        return $this->hasMany(Club::class);
    }
}
