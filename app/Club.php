<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Club
 *
 * @property int $id
 * @property int|null $club_type_id 社團類型
 * @property string $name 名稱
 * @property string|null $description 簡介
 * @property string|null $url 網址
 * @property string|null $image_url 圖片網址
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Club whereClubTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Club whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Club whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Club whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Club whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Club whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Club whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Club whereUrl($value)
 * @mixin \Eloquent
 */
class Club extends Model
{
    protected $fillable = [
        'name',
        'club_type_id',
        'description',
        'url',
        'image_url',
    ];
}
