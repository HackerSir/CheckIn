<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Qrcode
 *
 * @property int $id
 * @property string $code 代碼
 * @property int|null $student_id 對應學生
 * @property string|null $student_nid 對應學生
 * @property \Illuminate\Support\Carbon|null $bind_at 綁定時間
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $qrcode_set_id
 * @property-read bool $is_last_one
 * @property-read string $scan_url
 * @property-read \App\QrcodeSet|null $qrcodeSet
 * @property-read \App\Student|null $student
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Qrcode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Qrcode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Qrcode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Qrcode whereBindAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Qrcode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Qrcode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Qrcode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Qrcode whereQrcodeSetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Qrcode whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Qrcode whereStudentNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Qrcode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Qrcode extends Model
{
    protected $fillable = [
        'code',
        'student_id',
        'student_nid',
        'bind_at',
        'qrcode_set_id',
    ];

    protected $dates = [
        'bind_at',
    ];

    protected $appends = [
        'is_last_one',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_nid', 'nid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function qrcodeSet()
    {
        return $this->belongsTo(QrcodeSet::class);
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

    /**
     * 是否為學生最後一組QR Code
     *
     * @return bool
     */
    public function getIsLastOneAttribute()
    {
        if (!$this->student) {
            return false;
        }

        return $this->student->qrcode->setAppends([])->id == $this->id;
    }
}
