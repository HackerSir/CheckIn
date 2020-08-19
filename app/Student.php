<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

/**
 * App\Student
 *
 * @property string $nid 學號
 * @property string $name 姓名
 * @property string|null $type 類型
 * @property string|null $unit_id 科系ID
 * @property string|null $class 班級
 * @property string|null $unit_name 科系
 * @property string|null $dept_id 學院ID
 * @property string|null $dept_name 學院
 * @property int|null $in_year 入學學年度
 * @property string|null $gender 性別
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $consider_as_freshman 視為新生
 * @property bool $is_dummy 是否為虛構資料
 * @property \Illuminate\Support\Carbon|null $fetch_at 最後一次由API獲取資料時間
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Club[] $clubs
 * @property-read int|null $clubs_count
 * @property-read \App\ContactInformation|null $contactInformation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Record[] $countedRecords
 * @property-read int|null $counted_records_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Feedback[] $feedback
 * @property-read int|null $feedback_count
 * @property-read string $display_name
 * @property-read bool $has_enough_counted_records
 * @property-read bool $is_freshman
 * @property-read bool $is_staff
 * @property-read string $masked_display_name
 * @property-read \App\Qrcode|null $qrcode
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Qrcode[] $qrcodes
 * @property-read int|null $qrcodes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Record[] $records
 * @property-read int|null $records_count
 * @property-read \App\StudentSurvey|null $studentSurvey
 * @property-read \App\StudentTicket|null $studentTicket
 * @property-read \App\Ticket|null $ticket
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Student freshman()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student nonFreshman()
 * @method static \Illuminate\Database\Eloquent\Builder|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereConsiderAsFreshman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereDeptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereDeptName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereFetchAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereInYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereIsDummy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUnitName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Student extends Model
{
    protected $primaryKey = 'nid';
    public $incrementing = false;

    private static $freshmanInYear = 109;
    protected $fillable = [
        'nid',
        'name',
        'type',
        'class',
        'unit_id',
        'unit_name',
        'dept_id',
        'dept_name',
        'in_year',
        'gender',
        'consider_as_freshman',
        'is_dummy',
        'fetch_at',
    ];

    protected $casts = [
        'consider_as_freshman' => 'boolean',
        'is_dummy'             => 'boolean',
    ];

    protected $dates = [
        'fetch_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'nid', 'nid');
    }

    /**
     * 最後一組 QR Code
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|\Illuminate\Database\Eloquent\Builder
     */
    public function qrcode()
    {
        return $this->hasOne(Qrcode::class)->orderBy('bind_at', 'desc');
    }

    /**
     * 所有 QR Code
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function qrcodes()
    {
        return $this->hasMany(Qrcode::class)->orderBy('bind_at', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function records()
    {
        return $this->hasMany(Record::class)->orderBy('created_at', 'desc');
    }

    /**
     * 有採計的打卡紀錄
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function countedRecords()
    {
        return $this->hasMany(Record::class)
            //社團所屬類型必須為可集點
            ->whereHas('club', function ($query) {
                /** @var Builder|Club $query */
                $query->whereHas('clubType', function ($query) {
                    /** @var Builder|ClubType $query */
                    $query->where('is_counted', true);
                });
            })
            //必須填寫該社團的回饋資料
            ->whereHas('club.feedback', function ($query) {
                /** @var Builder|Feedback $query */
                $query->where('student_nid', $this->nid);
            })
            ->orderBy('created_at', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|\Illuminate\Database\Eloquent\Builder
     */
    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|\Illuminate\Database\Eloquent\Builder
     */
    public function studentTicket()
    {
        return $this->hasOne(StudentTicket::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contactInformation()
    {
        return $this->hasOne(ContactInformation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'student_nid', 'nid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function studentSurvey()
    {
        return $this->hasOne(StudentSurvey::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clubs()
    {
        return $this->belongsToMany(Club::class)->withTimestamps()->withPivot('is_leader');
    }

    /**
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return $this->nid . ' ' . $this->name;
    }

    /**
     * @return string
     */
    public function getMaskedDisplayNameAttribute()
    {
        $nid = mb_substr($this->nid, 0, 3)
            . str_repeat('▒', mb_strlen($this->nid) - 5)
            . mb_substr($this->nid, -2);

        $name = mb_substr($this->name, 0, 1)
            . str_repeat('▒', max(mb_strlen($this->name) - 2, 1))
            . mb_substr($this->name, -1);

        return $nid . ' ' . $name;
    }

    /**
     * 是否為新生
     *
     * @return bool
     */
    public function getIsFreshmanAttribute()
    {
        //強制視為新生
        if ($this->consider_as_freshman) {
            return true;
        }
        //研究所與教職員不算新生
        if (Str::startsWith($this->nid, ['M', 'P', 'T'])) {
            return false;
        }
        //檢查入學年度
        if ($this->in_year == static::$freshmanInYear) {
            return true;
        }
        //檢查年級
        if (Str::contains($this->class, '一年級')) {
            return true;
        }

        return false;
    }

    /**
     * 是否為攤位負責人
     *
     * @return bool
     */
    public function getIsStaffAttribute()
    {
        //如果已經載入 clubs 關聯，直接計算，避免匯出資料時造成過多 query
        if (isset($this->relations['clubs'])) {
            return $this->clubs->count() > 0;
        }

        return $this->clubs()->exists();
    }

    /**
     * @return bool
     */
    public function getHasEnoughCountedRecordsAttribute()
    {
        //打卡目標
        $target = (int) \Setting::get('target');
        //檢查打卡進度
        $count = $this->countedRecords->count();

        return $count >= $target;
    }

    /**
     * @param Builder|static $query
     */
    public function scopeFreshman($query)
    {
        $query->where('consider_as_freshman', true)
            ->orWhere(function ($query) {
                /** @var Builder|static $query */
                $query->where('nid', 'not like', 'M%')
                    ->where('nid', 'not like', 'P%')
                    ->where('nid', 'not like', 'T%')
                    ->where(function ($query) {
                        /** @var Builder|static $query */
                        $query->where('in_year', static::$freshmanInYear)
                            ->orWhere('class', 'like', '%一年級%');
                    });
            });
    }

    /**
     * @param Builder|static $query
     */
    public function scopeNonFreshman($query)
    {
        $query->where('consider_as_freshman', false)
            ->where(function ($query) {
                /** @var Builder|static $query */
                $query->where('nid', 'like', 'M%')
                    ->orWhere('nid', 'like', 'P%')
                    ->orWhere('nid', 'like', 'T%')
                    ->orWhere(function ($query) {
                        /** @var Builder|static $query */
                        $query->where('in_year', '<>', static::$freshmanInYear)
                            ->where('class', 'not like', '%一年級%');
                    });
            });
    }
}
