<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

/**
 * App\Models\Record
 *
 * @property int $id
 * @property string $ip
 * @property string|null $student_nid
 * @property int|null $club_id
 * @property int|null $scanned_by_user_id
 * @property bool $web_scan
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read Club|null $club
 * @property-read User|null $scanBy
 * @property-read Student|null $student
 * @method static Builder|Record newModelQuery()
 * @method static Builder|Record newQuery()
 * @method static Builder|Record query()
 * @method static Builder|Record whereClubId($value)
 * @method static Builder|Record whereCreatedAt($value)
 * @method static Builder|Record whereId($value)
 * @method static Builder|Record whereIp($value)
 * @method static Builder|Record whereScannedByUserId($value)
 * @method static Builder|Record whereStudentNid($value)
 * @method static Builder|Record whereUpdatedAt($value)
 * @method static Builder|Record whereWebScan($value)
 * @mixin Eloquent
 */
class Record extends LoggableModel
{
    use LegacySerializeDate;
    use HasFactory;

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

    public function scanBy()
    {
        return $this->belongsTo(User::class, 'scanned_by_user_id');
    }

    protected function getNameForActivityLog(): string
    {
        return $this->student->display_name . ' 在 ' . $this->club->name . ' 的打卡紀錄';
    }
}
