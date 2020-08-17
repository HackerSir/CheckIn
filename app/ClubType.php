<?php

namespace App;

/**
 * App\ClubType
 *
 * @property int $id
 * @property string $name 名稱
 * @property string $color 標籤顏色
 * @property bool $is_counted 是否列入抽獎集點
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Club[] $clubs
 * @property-read int|null $clubs_count
 * @property-read string $tag
 * @method static \Illuminate\Database\Eloquent\Builder|ClubType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClubType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClubType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClubType whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClubType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClubType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClubType whereIsCounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClubType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClubType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ClubType extends LoggableModel
{
    protected static $logName = 'club-type';
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
        return "<span class='badge badge-secondary' style='background-color:{$this->color}; font-size: 20px;'>{$this->name}</span>";
    }

    protected function getNameForActivityLog(): string
    {
        return $this->name;
    }
}
