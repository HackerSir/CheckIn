<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ImgurImage
 *
 * @property int $id
 * @property string $imgur_id
 * @property string $file_name 完整原始檔名
 * @property string $extension 副檔名
 * @property string $delete_hash
 * @property int|null $club_id 所屬社團
 * @property string $club_type
 * @property string|null $memo 備註
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $club
 * @property-read string $url
 * @method static \Illuminate\Database\Eloquent\Builder|ImgurImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImgurImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImgurImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ImgurImage whereClubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImgurImage whereClubType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImgurImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImgurImage whereDeleteHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImgurImage whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImgurImage whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImgurImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImgurImage whereImgurId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImgurImage whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImgurImage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ImgurImage extends Model
{
    protected $fillable = [
        'imgur_id',
        'file_name',
        'extension',
        'delete_hash',
        'club_id',
        'club_type',
        'memo',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function club()
    {
        return $this->morphTo();
    }

    /**
     * 取得圖片網址
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return 'https://i.imgur.com/' . $this->imgur_id . '.' . $this->extension;
    }

    public function thumbnail($suffix = null)
    {
        if (!empty($suffix) && !in_array($suffix, ['s', 'b', 't', 'm', 'l', 'h'])) {
            return null;
        }

        return 'https://i.imgur.com/' . $this->imgur_id . $suffix . '.' . $this->extension;
    }
}
