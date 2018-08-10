<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * App\Student
 *
 * @property int $id
 * @property int|null $user_id 對應使用者
 * @property string $nid 學號
 * @property string $name 姓名
 * @property string $class 班級
 * @property string $unit_name 科系
 * @property string $dept_name 學院
 * @property int $in_year 入學學年度
 * @property string $gender 性別
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Record[] $countedRecords
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Feedback[] $feedback
 * @property-read string $display_name
 * @property-read bool $is_freshman
 * @property-read bool $is_staff
 * @property-read string $masked_display_name
 * @property-read \App\Qrcode $qrcode
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Qrcode[] $qrcodes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Record[] $records
 * @property-read \App\StudentSurvey $studentSurvey
 * @property-read \App\Ticket $ticket
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student freshman()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student nonFreshman()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereDeptName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereInYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereUnitName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereUserId($value)
 * @mixin \Eloquent
 */
class Student extends Model
{
    private static $freshmanInYear = 107;
    protected $fillable = [
        'nid',
        'user_id',
        'name',
        'class',
        'unit_name',
        'dept_name',
        'in_year',
        'gender',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
            ->whereHas('club', function ($query) {
                /** @var Builder|Club|$query */
                $query->whereHas('clubType', function ($query) {
                    /** @var Builder|ClubType|$query */
                    $query->where('is_counted', true);
                });
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function studentSurvey()
    {
        return $this->hasOne(StudentSurvey::class);
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
        //研究所與教職員不算新生
        if (starts_with($this->nid, 'M') || starts_with($this->nid, 'T')) {
            return false;
        }
        //檢查入學年度
        if ($this->in_year == static::$freshmanInYear) {
            return true;
        }
        //檢查年級
        if (str_contains($this->class, '一年級')) {
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
        //無對應使用者
        if (!$this->user_id) {
            return false;
        }

        return $this->user->is_staff;
    }

    /**
     * @param Builder|static $query
     */
    public function scopeFreshman($query)
    {
        $query->where('nid', 'not like', 'M%')
            ->where('nid', 'not like', 'T%')
            ->where(function ($query) {
                /** @var Builder|static $query */
                $query->where('in_year', static::$freshmanInYear)
                    ->orWhere('class', 'like', '%一年級%');
            });
    }

    /**
     * @param Builder|static $query
     */
    public function scopeNonFreshman($query)
    {
        $query->where('nid', 'like', 'M%')
            ->orWhere('nid', 'like', 'T%')
            ->orWhere(function ($query) {
                /** @var Builder|static $query */
                $query->where('in_year', '<>', static::$freshmanInYear)
                    ->where('class', 'not like', '%一年級%');
            });
    }
}
