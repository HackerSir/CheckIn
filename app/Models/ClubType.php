<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

/**
 * App\Models\ClubType
 *
 * @property int $id
 * @property string $name
 * @property string $color
 * @property bool $is_counted
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read Collection|Club[] $clubs
 * @property-read int|null $clubs_count
 * @property-read string $tag
 * @method static Builder|ClubType newModelQuery()
 * @method static Builder|ClubType newQuery()
 * @method static Builder|ClubType query()
 * @method static Builder|ClubType whereColor($value)
 * @method static Builder|ClubType whereCreatedAt($value)
 * @method static Builder|ClubType whereId($value)
 * @method static Builder|ClubType whereIsCounted($value)
 * @method static Builder|ClubType whereName($value)
 * @method static Builder|ClubType whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ClubType extends LoggableModel
{
    use LegacySerializeDate;
    use HasFactory;

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
     * @return array
     */
    public static function selectOptions()
    {
        $options = [null => ''] + static::pluck('name', 'id')->toArray();

        return $options;
    }

    /**
     * @return HasMany|Builder
     */
    public function clubs()
    {
        return $this->hasMany(Club::class);
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
