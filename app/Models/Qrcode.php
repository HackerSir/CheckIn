<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Qrcode
 *
 * @property int $id
 * @property string $code 代碼
 * @property string|null $student_nid 對應學生
 * @property Carbon|null $bind_at 綁定時間
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $qrcode_set_id
 * @property bool $auto_generated 自動建立
 * @property-read bool $is_last_one 是否為該學生的最後一組 QR Code
 * @property-read string $scan_url 掃描用網址
 * @property-read \App\Models\QrcodeSet|null $qrcodeSet
 * @property-read \App\Models\Student|null $student
 * @method static \Database\Factories\QrcodeFactory factory(...$parameters)
 * @method static Builder|Qrcode newModelQuery()
 * @method static Builder|Qrcode newQuery()
 * @method static Builder|Qrcode query()
 * @method static Builder|Qrcode whereAutoGenerated($value)
 * @method static Builder|Qrcode whereBindAt($value)
 * @method static Builder|Qrcode whereCode($value)
 * @method static Builder|Qrcode whereCreatedAt($value)
 * @method static Builder|Qrcode whereId($value)
 * @method static Builder|Qrcode whereQrcodeSetId($value)
 * @method static Builder|Qrcode whereStudentNid($value)
 * @method static Builder|Qrcode whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Qrcode extends Model
{
    use LegacySerializeDate;
    use HasFactory;

    protected $fillable = [
        'code',
        'student_nid',
        'bind_at',
        'qrcode_set_id',
        'auto_generated',
    ];

    protected $dates = [
        'bind_at',
    ];

    protected $appends = [
        'is_last_one',
    ];

    protected $casts = [
        'auto_generated' => 'bool',
    ];

    /**
     * @return BelongsTo|Builder
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_nid', 'nid');
    }

    /**
     * @return BelongsTo|Builder
     */
    public function qrcodeSet()
    {
        return $this->belongsTo(QrcodeSet::class);
    }

    /**
     * @comment 掃描用網址
     *
     * @return string
     */
    public function getScanUrlAttribute(): string
    {
        return route('qrcode.scan', $this->code);
    }

    /**
     * @comment 是否為該學生的最後一組 QR Code
     *
     * @return bool
     */
    public function getIsLastOneAttribute(): bool
    {
        if (!$this->student) {
            return false;
        }

        return $this->student->qrcode->setAppends([])->id == $this->id;
    }
}
