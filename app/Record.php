<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Record
 *
 * @property int $id
 * @property string $ip 打卡IP
 * @property int|null $student_id 對應學生
 * @property int|null $club_id 對應社團
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereClubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Record extends Model
{
    protected $fillable = [
        'student_id',
        'club_id',
        'ip',
    ];
}
