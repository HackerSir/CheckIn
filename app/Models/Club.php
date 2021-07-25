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
 * @property int|null $club_type_id
 * @property string|null $number
 * @property string $name
 * @property string|null $description
 * @property string|null $url
 * @property string|null $extra_info
 * @property string|null $custom_question
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read Collection|Booth[] $booths
 * @property-read int|null $booths_count
 * @property-read ClubSurvey|null $clubSurvey
 * @property-read ClubType|null $clubType
 * @property-read Collection|DataUpdateRequest[] $dataUpdateRequests
 * @property-read int|null $data_update_requests_count
 * @property-read Collection|User[] $favoriteBy
 * @property-read int|null $favorite_by_count
 * @property-read Collection|Feedback[] $feedback
 * @property-read int|null $feedback_count
 * @property-read string $display_name
 * @property-read bool $is_counted
 * @property-read ImgurImage|null $imgurImage
 * @property-read Collection|Student[] $leaders
 * @property-read int|null $leaders_count
 * @property-read Collection|PaymentRecord[] $paymentRecords
 * @property-read int|null $payment_records_count
 * @property-read Collection|Record[] $records
 * @property-read int|null $records_count
 * @property-read Collection|Student[] $staffs
 * @property-read int|null $staffs_count
 * @property-read Collection|Student[] $students
 * @property-read int|null $students_count
 * @property-read TeaParty|null $teaParty
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
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

    protected function getNameForActivityLog(): string
    {
        return $this->name;
    }
}
