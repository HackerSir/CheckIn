<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Booth
 *
 * @property int $id
 * @property int|null $club_id 對應社團
 * @property string $name 名稱
 * @property float|null $longitude 經度
 * @property float|null $latitude 緯度
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereClubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Booth extends Model
{
    protected $fillable = [
        'club_id',
        'name',
        'longitude',
        'latitude',
    ];
}
