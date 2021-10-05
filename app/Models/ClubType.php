<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use App\Traits\LogModelEvent;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\ClubType
 *
 * @property int $id
 * @property string $name 名稱
 * @property string $color 標籤顏色
 * @property bool $is_counted 是否列入抽獎集點
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|\App\Models\ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @property-read Collection|\App\Models\Club[] $clubs
 * @property-read int|null $clubs_count
 * @property-read string $tag HTML 標籤
 *
 * @method static \Database\Factories\ClubTypeFactory factory(...$parameters)
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
class ClubType extends Model
{
    use LogModelEvent;
    use LegacySerializeDate;
    use HasFactory;

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
     * @comment HTML 標籤
     *
     * @return string
     */
    public function getTagAttribute(): string
    {
        return "<span class='badge badge-secondary' style='background-color:{$this->color}; font-size: 20px;'>{$this->name}</span>";
    }

    protected function getNameForActivityLog(): string
    {
        return $this->name;
    }
}
