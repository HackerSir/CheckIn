<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Qrcode
 *
 * @property int $id
 * @property string $code 代碼
 * @property int|null $student_id 對應學生
 * @property string|null $bind_at 綁定時間
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Qrcode whereBindAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Qrcode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Qrcode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Qrcode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Qrcode whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Qrcode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Qrcode extends Model
{
    protected $fillable = [
        'code',
        'student_id',
        'bind_at',
    ];
}
