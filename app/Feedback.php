<?php

namespace App;

use Iatstuti\Database\Support\NullableFields;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Feedback
 *
 * @property int $id
 * @property string|null $student_nid 對應學生
 * @property int $club_id 對應社團
 * @property string|null $phone 聯絡電話
 * @property string|null $email 聯絡信箱
 * @property string|null $facebook FB個人檔案連結
 * @property string|null $line LINE ID
 * @property bool $include_phone 聯絡電話
 * @property bool $include_email 聯絡信箱
 * @property bool $include_facebook FB個人檔案連結
 * @property bool $include_line LINE ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $message 附加訊息
 * @property-read \App\Club $club
 * @property-read \App\Student|null $student
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereClubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereIncludeEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereIncludeFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereIncludeLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereIncludePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereStudentNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Feedback extends Model
{
    use NullableFields;

    protected $fillable = [
        'student_nid',
        'club_id',
        'phone',
        'email',
        'facebook',
        'line',
        'include_phone',
        'include_email',
        'include_facebook',
        'include_line',
        'message',
    ];

    protected $nullable = [
        'message',
    ];

    protected $casts = [
        'include_phone'    => 'boolean',
        'include_email'    => 'boolean',
        'include_facebook' => 'boolean',
        'include_line'     => 'boolean',
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
        return $this->belongsTo(Student::class, 'student_nid', 'nid');
    }

    /**
     * 從聯絡資料中，將資料同步至此
     */
    public function syncContactInformation()
    {
        //檢查欄位
        $checkFields = ['phone', 'email', 'facebook', 'line'];
        //使用者的聯絡資料
        $contactInformation = $this->student->contactInformation;
        //同步資料
        foreach ($checkFields as $checkField) {
            $this->$checkField = $this->{'include_' . $checkField} ? $contactInformation->$checkField : null;
        }
    }
}
