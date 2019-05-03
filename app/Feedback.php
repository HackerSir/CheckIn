<?php

namespace App;

use Iatstuti\Database\Support\NullableFields;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Feedback
 *
 * @property int $id
 * @property int $student_id 對應學生
 * @property int $club_id 對應社團
 * @property string|null $phone 聯絡電話
 * @property string|null $email 聯絡信箱
 * @property string|null $facebook FB個人檔案連結
 * @property string|null $line LINE ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $message 附加訊息
 * @property-read \App\Club $club
 * @property-read \App\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereClubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Feedback extends Model
{
    use NullableFields;

    protected $fillable = [
        'student_id',
        'club_id',
        'phone',
        'email',
        'facebook',
        'line',
        'message',
    ];

    protected $nullable = [
        'phone',
        'email',
        'facebook',
        'line',
        'message',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
