<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\ImgurImage
 *
 * @property int $id
 * @property string $imgur_id
 * @property string $file_name 完整原始檔名
 * @property string $extension 副檔名
 * @property string $delete_hash
 * @property int|null $club_id 所屬社團
 * @property string $club_type
 * @property string|null $memo 備註
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|\Eloquent $club
 * @property-read string $url 取得圖片網址
 *
 * @method static Builder|ImgurImage newModelQuery()
 * @method static Builder|ImgurImage newQuery()
 * @method static Builder|ImgurImage query()
 * @method static Builder|ImgurImage whereClubId($value)
 * @method static Builder|ImgurImage whereClubType($value)
 * @method static Builder|ImgurImage whereCreatedAt($value)
 * @method static Builder|ImgurImage whereDeleteHash($value)
 * @method static Builder|ImgurImage whereExtension($value)
 * @method static Builder|ImgurImage whereFileName($value)
 * @method static Builder|ImgurImage whereId($value)
 * @method static Builder|ImgurImage whereImgurId($value)
 * @method static Builder|ImgurImage whereMemo($value)
 * @method static Builder|ImgurImage whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ImgurImage extends Model
{
    use LegacySerializeDate;

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
     * @return MorphTo
     */
    public function club()
    {
        return $this->morphTo();
    }

    /**
     * @comment 取得圖片網址
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return 'https://i.imgur.com/' . $this->imgur_id . '.' . $this->extension;
    }

    public function thumbnail($suffix = null): ?string
    {
        if (!empty($suffix) && !in_array($suffix, ['s', 'b', 't', 'm', 'l', 'h'])) {
            return null;
        }

        return 'https://i.imgur.com/' . $this->imgur_id . $suffix . '.' . $this->extension;
    }
}
