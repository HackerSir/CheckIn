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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Club|null $club
 * @property-read string $url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImgurImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImgurImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImgurImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImgurImage whereClubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImgurImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImgurImage whereDeleteHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImgurImage whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImgurImage whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImgurImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImgurImage whereImgurId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImgurImage whereUpdatedAt($value)
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
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
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
