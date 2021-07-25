<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use Dyrynda\Database\Support\NullableFields;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

/**
 * App\Models\Feedback
 *
 * @property int $id
 * @property string|null $student_nid
 * @property int $club_id
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $facebook
 * @property string|null $line
 * @property bool $include_phone
 * @property bool $include_email
 * @property bool $include_facebook
 * @property bool $include_line
 * @property string|null $message
 * @property string|null $custom_question
 * @property string|null $answer_of_custom_question
 * @property int|null $join_club_intention
 * @property int|null $join_tea_party_intention
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read Club $club
 * @property-read string|null $join_club_intention_text
 * @property-read string|null $join_tea_party_intention_text
 * @property-read Student|null $student
 * @method static Builder|Feedback newModelQuery()
 * @method static Builder|Feedback newQuery()
 * @method static Builder|Feedback query()
 * @method static Builder|Feedback whereAnswerOfCustomQuestion($value)
 * @method static Builder|Feedback whereClubId($value)
 * @method static Builder|Feedback whereCreatedAt($value)
 * @method static Builder|Feedback whereCustomQuestion($value)
 * @method static Builder|Feedback whereEmail($value)
 * @method static Builder|Feedback whereFacebook($value)
 * @method static Builder|Feedback whereId($value)
 * @method static Builder|Feedback whereIncludeEmail($value)
 * @method static Builder|Feedback whereIncludeFacebook($value)
 * @method static Builder|Feedback whereIncludeLine($value)
 * @method static Builder|Feedback whereIncludePhone($value)
 * @method static Builder|Feedback whereJoinClubIntention($value)
 * @method static Builder|Feedback whereJoinTeaPartyIntention($value)
 * @method static Builder|Feedback whereLine($value)
 * @method static Builder|Feedback whereMessage($value)
 * @method static Builder|Feedback wherePhone($value)
 * @method static Builder|Feedback whereStudentNid($value)
 * @method static Builder|Feedback whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Feedback extends LoggableModel
{
    use LegacySerializeDate;
    use NullableFields;
    use HasFactory;

    public static $intentionText = [
        2 => '參加',
        1 => '考慮中',
        0 => '不參加',
    ];
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

    /**
     * @return BelongsTo|Builder
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * @return BelongsTo|Builder
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
