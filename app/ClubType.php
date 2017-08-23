<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ClubType
 *
 * @property int $id
 * @property string $name 名稱
 * @property string $color 標籤顏色
 * @property bool $is_counted 是否列入抽獎集點
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Club[] $clubs
 * @property-read string $tag
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClubType whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClubType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClubType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClubType whereIsCounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClubType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClubType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ClubType extends Model
{
    protected $fillable = [
        'name',
        'color',
        'is_counted',
    ];

    protected $appends = [
        'tag',
    ];

    protected $casts = [
        'is_counted' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function clubs()
    {
        return $this->hasMany(Club::class);
    }

    /**
     * @return array
     */
    public static function selectOptions()
    {
        $options = [null => ''] + static::pluck('name', 'id')->toArray();

        return $options;
    }

    /**
     * @return string
     */
    public function getTagAttribute()
    {
        return "<span class='badge badge-default' style='background-color:{$this->color}; font-size: 20px;'>{$this->name}</span>";
    }
}
