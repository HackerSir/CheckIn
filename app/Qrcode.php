<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Qrcode
 *
 * @property int $id
 * @property string $code 代碼
 * @property int|null $student_id 對應學生
 * @property \Carbon\Carbon|null $bind_at 綁定時間
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read string $scan_url
 * @property-read \App\Student|null $student
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

    protected $dates = [
        'bind_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * 掃描用網址
     *
     * @return string
     */
    public function getScanUrlAttribute()
    {
        return route('qrcode.scan', $this->code);
    }
}
