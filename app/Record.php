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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read \App\Club|null $club
 * @property-read \App\Student|null $student
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereClubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereStudentNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Record extends LoggableModel
{
    protected static $logName = 'record';
    protected $fillable = [
        'student_nid',
        'club_id',
        'ip',
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

    protected function getNameForActivityLog(): string
    {
        return $this->student->display_name . ' 在 ' . $this->club->name . ' 的打卡紀錄';
    }
}
