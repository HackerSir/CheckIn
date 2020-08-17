<?php

namespace App;

/**
 * App\Record
 *
 * @property int $id
 * @property string $ip 打卡IP
 * @property string|null $student_nid 對應學生
 * @property int|null $club_id 對應社團
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $scanned_by_user_id 掃描者
 * @property bool $web_scan 使用網站內建掃描器掃描
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Club|null $club
 * @property-read \App\User|null $scanBy
 * @property-read \App\Student|null $student
 * @method static \Illuminate\Database\Eloquent\Builder|Record newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Record newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Record query()
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereClubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereScannedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereStudentNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereWebScan($value)
 * @mixin \Eloquent
 */
class Record extends LoggableModel
{
    protected static $logName = 'record';
    protected $fillable = [
        'student_nid',
        'club_id',
        'ip',
        'scanned_by_user_id',
        'web_scan',
    ];

    protected $casts = [
        'web_scan' => 'bool',
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

    public function scanBy()
    {
        return $this->belongsTo(User::class, 'scanned_by_user_id');
    }

    protected function getNameForActivityLog(): string
    {
        return $this->student->display_name . ' 在 ' . $this->club->name . ' 的打卡紀錄';
    }
}
