<?php

namespace App;

use Iatstuti\Database\Support\NullableFields;

/**
 * App\Club
 *
 * @property int $id
 * @property int|null $club_type_id 社團類型
 * @property string|null $number 社團編號
 * @property string $name 名稱
 * @property string|null $description 簡介
 * @property string|null $url 網址
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $extra_info 額外資訊
 * @property string|null $custom_question 自訂問題
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Booth[] $booths
 * @property-read int|null $booths_count
 * @property-read \App\ClubSurvey|null $clubSurvey
 * @property-read \App\ClubType|null $clubType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DataUpdateRequest[] $dataUpdateRequests
 * @property-read int|null $data_update_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $favoriteBy
 * @property-read int|null $favorite_by_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Feedback[] $feedback
 * @property-read int|null $feedback_count
 * @property-read string $display_name
 * @property-read bool $is_counted
 * @property-read \App\ImgurImage|null $imgurImage
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Student[] $leaders
 * @property-read int|null $leaders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PaymentRecord[] $paymentRecords
 * @property-read int|null $payment_records_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Record[] $records
 * @property-read int|null $records_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Student[] $staffs
 * @property-read int|null $staffs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Student[] $students
 * @property-read int|null $students_count
 * @property-read \App\TeaParty|null $teaParty
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Club newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Club newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Club query()
 * @method static \Illuminate\Database\Eloquent\Builder|Club whereClubTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Club whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Club whereCustomQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Club whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Club whereExtraInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Club whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Club whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Club whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Club whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Club whereUrl($value)
 * @mixin \Eloquent
 */
class Club extends LoggableModel
{
    use NullableFields;

    protected static $logName = 'club';

    protected $fillable = [
        'name',
        'number',
        'club_type_id',
        'description',
        'extra_info',
        'url',
        'custom_question',
    ];

    protected $nullable = [
        'description',
        'url',
    ];

    protected $appends = [
        'is_counted',
    ];

    protected $hidden = [
        'extra_info',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function clubType()
    {
        return $this->belongsTo(ClubType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function booths()
    {
        return $this->hasMany(Booth::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function records()
    {
        return $this->hasMany(Record::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function imgurImage()
    {
        return $this->morphOne(ImgurImage::class, 'club');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function dataUpdateRequests()
    {
        return $this->hasMany(DataUpdateRequest::class)->orderByDesc('submit_at');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function clubSurvey()
    {
        return $this->hasOne(ClubSurvey::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function teaParty()
    {
        return $this->hasOne(TeaParty::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students()
    {
        return $this->belongsToMany(Student::class)->withTimestamps()->withPivot('is_leader');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function staffs()
    {
        return $this->belongsToMany(Student::class)->withTimestamps()->wherePivot('is_leader', false);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function leaders()
    {
        return $this->belongsToMany(Student::class)->withTimestamps()->wherePivot('is_leader', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favoriteBy()
    {
        return $this->belongsToMany(User::class, 'favorite_club')->withTimestamps();
    }

    public function paymentRecords()
    {
        return $this->hasMany(PaymentRecord::class);
    }

    /**
     * @return bool
     */
    public function getIsCountedAttribute()
    {
        if (!$this->clubType) {
            return false;
        }

        return $this->clubType->is_counted;
    }

    /**
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        $html = '';
        if ($this->clubType) {
            $html .= $this->clubType->tag . ' ';
        }
        $html .= $this->name;

        return $html;
    }

    /**
     * @return array
     */
    public static function selectOptions()
    {
        $options = [null => '&nbsp;'];

        $clubs = static::all();
        $clubTypes = ClubType::has('clubs', '>', 0)->get();
        foreach ($clubTypes as $clubType) {
            $options[$clubType->name] = $clubs->where('club_type_id', $clubType->id)->pluck('name', 'id')->toArray();
        }
        $options += $clubs->where('club_type_id', null)->pluck('name', 'id')->toArray();

        return $options;
    }

    protected function getNameForActivityLog(): string
    {
        return $this->name;
    }
}
