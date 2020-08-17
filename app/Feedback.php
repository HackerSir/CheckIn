<?php

namespace App;

use Iatstuti\Database\Support\NullableFields;

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
 * @property string|null $custom_question 社團自訂問題
 * @property string|null $answer_of_custom_question 對於社團自訂問題的回答
 * @property int|null $join_club_intention 加入社團意願
 * @property int|null $join_tea_party_intention 參加迎新茶會意願
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Club $club
 * @property-read string|null $join_club_intention_text
 * @property-read string|null $join_tea_party_intention_text
 * @property-read \App\Student|null $student
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereAnswerOfCustomQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereClubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereCustomQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereIncludeEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereIncludeFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereIncludeLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereIncludePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereJoinClubIntention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereJoinTeaPartyIntention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereStudentNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Feedback extends LoggableModel
{
    use NullableFields;
    protected static $logName = 'feedback';

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
        'custom_question',
        'answer_of_custom_question',
        'join_club_intention',
        'join_tea_party_intention',
    ];

    protected $nullable = [
        'message',
    ];

    protected $casts = [
        'include_phone'            => 'boolean',
        'include_email'            => 'boolean',
        'include_facebook'         => 'boolean',
        'include_line'             => 'boolean',
        'join_club_intention'      => 'int',
        'join_tea_party_intention' => 'int',
    ];

    public static $intentionText = [
        2 => '參加',
        1 => '考慮中',
        0 => '不參加',
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

    /**
     * @return string|null
     */
    public function getJoinClubIntentionTextAttribute()
    {
        if ($this->join_club_intention === null) {
            return null;
        }

        return self::$intentionText[$this->join_club_intention] ?? null;
    }

    /**
     * @return string|null
     */
    public function getJoinTeaPartyIntentionTextAttribute()
    {
        if ($this->join_tea_party_intention === null) {
            return null;
        }

        return self::$intentionText[$this->join_tea_party_intention] ?? null;
    }

    protected function getNameForActivityLog(): string
    {
        return $this->student->display_name . ' 給 ' . $this->club->name . ' 的回饋資料';
    }
}
