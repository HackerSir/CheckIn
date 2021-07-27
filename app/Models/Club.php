<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use Dyrynda\Database\Support\NullableFields;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

/**
 * App\Models\Club
 *
 * @property int $id
 * @property int|null $club_type_id 社團類型
 * @property string|null $number 社團編號
 * @property string $name 名稱
 * @property string|null $description 簡介
 * @property string|null $url 網址
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $extra_info 額外資訊
 * @property string|null $custom_question 自訂問題
 * @property-read Collection|Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read Collection|\App\Models\Booth[] $booths
 * @property-read int|null $booths_count
 * @property-read \App\Models\ClubSurvey|null $clubSurvey
 * @property-read \App\Models\ClubType|null $clubType
 * @property-read Collection|\App\Models\DataUpdateRequest[] $dataUpdateRequests
 * @property-read int|null $data_update_requests_count
 * @property-read Collection|\App\Models\User[] $favoriteBy
 * @property-read int|null $favorite_by_count
 * @property-read Collection|\App\Models\Feedback[] $feedback
 * @property-read int|null $feedback_count
 * @property-read string $display_name 顯示名稱
 * @property-read bool $is_counted 是否列入抽獎集點
 * @property-read \App\Models\ImgurImage|null $imgurImage
 * @property-read Collection|\App\Models\Student[] $leaders
 * @property-read int|null $leaders_count
 * @property-read Collection|\App\Models\PaymentRecord[] $paymentRecords
 * @property-read int|null $payment_records_count
 * @property-read Collection|\App\Models\Record[] $records
 * @property-read int|null $records_count
 * @property-read Collection|\App\Models\Student[] $staffs
 * @property-read int|null $staffs_count
 * @property-read Collection|\App\Models\Student[] $students
 * @property-read int|null $students_count
 * @property-read \App\Models\TeaParty|null $teaParty
 * @property-read Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\ClubFactory factory(...$parameters)
 * @method static Builder|Club newModelQuery()
 * @method static Builder|Club newQuery()
 * @method static Builder|Club query()
 * @method static Builder|Club whereClubTypeId($value)
 * @method static Builder|Club whereCreatedAt($value)
 * @method static Builder|Club whereCustomQuestion($value)
 * @method static Builder|Club whereDescription($value)
 * @method static Builder|Club whereExtraInfo($value)
 * @method static Builder|Club whereId($value)
 * @method static Builder|Club whereName($value)
 * @method static Builder|Club whereNumber($value)
 * @method static Builder|Club whereUpdatedAt($value)
 * @method static Builder|Club whereUrl($value)
 * @mixin Eloquent
 */
class Club extends LoggableModel
{
    use LegacySerializeDate;
    use NullableFields;
    use HasFactory;

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

    /**
     * @return BelongsTo|Builder
     */
    public function clubType()
    {
        return $this->belongsTo(ClubType::class);
    }

    /**
     * @return HasMany|Builder
     */
    public function booths()
    {
        return $this->hasMany(Booth::class);
    }

    /**
     * @return HasMany|Builder
     */
    public function records()
    {
        return $this->hasMany(Record::class);
    }

    /**
     * @return HasMany|Builder
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * @return HasMany|Builder
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return MorphOne
     */
    public function imgurImage()
    {
        return $this->morphOne(ImgurImage::class, 'club');
    }

    /**
     * @return HasMany|Builder
     */
    public function dataUpdateRequests()
    {
        return $this->hasMany(DataUpdateRequest::class)->orderByDesc('submit_at');
    }

    /**
     * @return HasOne
     */
    public function clubSurvey()
    {
        return $this->hasOne(ClubSurvey::class);
    }

    /**
     * @return HasOne
     */
    public function teaParty()
    {
        return $this->hasOne(TeaParty::class);
    }

    /**
     * @return BelongsToMany
     */
    public function students()
    {
        return $this->belongsToMany(Student::class)->withTimestamps()->withPivot('is_leader');
    }

    /**
     * @return BelongsToMany
     */
    public function staffs()
    {
        return $this->belongsToMany(Student::class)->withTimestamps()->wherePivot('is_leader', false);
    }

    /**
     * @return BelongsToMany
     */
    public function leaders()
    {
        return $this->belongsToMany(Student::class)->withTimestamps()->wherePivot('is_leader', true);
    }

    /**
     * @return BelongsToMany
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
     * @comment 是否列入抽獎集點
     *
     * @return bool
     */
    public function getIsCountedAttribute(): bool
    {
        if (!$this->clubType) {
            return false;
        }

        return $this->clubType->is_counted;
    }

    /**
     * @comment 顯示名稱
     *
     * @return string
     */
    public function getDisplayNameAttribute(): string
    {
        $html = '';
        if ($this->clubType) {
            $html .= $this->clubType->tag . ' ';
        }
        $html .= $this->name;

        return $html;
    }

    protected function getNameForActivityLog(): string
    {
        return $this->name;
    }
}
