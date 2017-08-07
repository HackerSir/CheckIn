<?php

namespace App;

use Iatstuti\Database\Support\NullableFields;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Club
 *
 * @property int $id
 * @property int|null $club_type_id 社團類型
 * @property string|null $number 社團編號
 * @property string $name 名稱
 * @property string|null $description 簡介
 * @property string|null $url 網址
 * @property string|null $image_url 圖片網址
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Booth[] $booths
 * @property-read \App\ClubType|null $clubType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Feedback[] $feedback
 * @property-read bool $is_counted
 * @property-read \App\ImgurImage $imgurImage
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Record[] $records
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Club whereClubTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Club whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Club whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Club whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Club whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Club whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Club whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Club whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Club whereUrl($value)
 * @mixin \Eloquent
 */
class Club extends Model
{
    use NullableFields;

    protected $fillable = [
        'name',
        'number',
        'club_type_id',
        'description',
        'url',
        'image_url',
    ];

    protected $nullable = [
        'description',
        'url',
        'image_url',
    ];

    protected $appends = [
        'is_counted',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function clubType()
    {
        return $this->belongsTo(ClubType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function booths()
    {
        return $this->hasMany(Booth::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function records()
    {
        return $this->hasMany(Record::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|\Illuminate\Database\Eloquent\Builder
     */
    public function imgurImage()
    {
        return $this->hasOne(ImgurImage::class);
    }

    /**
     * @return bool
     */
    public function getIsCountedAttribute()
    {
        if (!$this->clubType) {
            return false;
        }

        return $this->clubType->is_counted;
    }

    /**
     * @return array
     */
    public static function selectOptions()
    {
        $options = [null => '&nbsp;'];

        $clubs = static::all();
        $clubTypes = ClubType::has('clubs', '>', 0)->get();
        foreach ($clubTypes as $clubType) {
            $options[$clubType->name] = $clubs->where('club_type_id', $clubType->id)->pluck('name', 'id')->toArray();
        }
        $options += $clubs->where('club_type_id', null)->pluck('name', 'id')->toArray();

        return $options;
    }
}
