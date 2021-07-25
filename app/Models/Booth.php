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
 * App\Models\Booth
 *
 * @property int $id
 * @property string|null $zone
 * @property int|null $club_id
 * @property string $name
 * @property float|null $longitude
 * @property float|null $latitude
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read Club|null $club
 * @property-read string $embed_map_url
 * @method static Builder|Booth newModelQuery()
 * @method static Builder|Booth newQuery()
 * @method static Builder|Booth query()
 * @method static Builder|Booth whereClubId($value)
 * @method static Builder|Booth whereCreatedAt($value)
 * @method static Builder|Booth whereId($value)
 * @method static Builder|Booth whereLatitude($value)
 * @method static Builder|Booth whereLongitude($value)
 * @method static Builder|Booth whereName($value)
 * @method static Builder|Booth whereUpdatedAt($value)
 * @method static Builder|Booth whereZone($value)
 * @mixin Eloquent
 */
class Booth extends LoggableModel
{
    use LegacySerializeDate;
    use HasFactory;

    protected static $logName = 'booth';

    protected $fillable = [
        'zone',
        'club_id',
        'name',
        'longitude',
        'latitude',
    ];

    /**
     * @return BelongsTo|Builder
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * 內嵌地圖網址
     *
     * @return string
     */
    public function getEmbedMapUrlAttribute()
    {
        $url = 'https://www.google.com/maps/embed/v1/place';
        $queryParameters = [
            'key'  => config('services.google.map.embed_key'),
            'q'    => $this->latitude . ',' . $this->longitude,
            'zoom' => 18,
        ];
        $fullUrl = $url . '?' . urldecode(http_build_query($queryParameters));

        return $fullUrl;
    }

    protected function getNameForActivityLog(): string
    {
        return $this->name;
    }
}