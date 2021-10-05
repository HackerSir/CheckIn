<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Models\Activity;

/**
 * App\Models\ActivityLog
 *
 * @property int $id
 * @property string|null $log_name
 * @property string $description
 * @property string|null $subject_id
 * @property string|null $subject_type
 * @property string|null $causer_id
 * @property string|null $causer_type
 * @property \Illuminate\Support\Collection|null $properties
 * @property string|null $ip IP
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $causer
 * @property-read \Illuminate\Support\Collection $changes
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $subject
 *
 * @method static Builder|Activity causedBy(\Illuminate\Database\Eloquent\Model $causer)
 * @method static Builder|Activity forSubject(\Illuminate\Database\Eloquent\Model $subject)
 * @method static Builder|Activity inLog($logNames)
 * @method static Builder|ActivityLog newModelQuery()
 * @method static Builder|ActivityLog newQuery()
 * @method static Builder|ActivityLog query()
 * @method static Builder|ActivityLog whereCauserId($value)
 * @method static Builder|ActivityLog whereCauserType($value)
 * @method static Builder|ActivityLog whereCreatedAt($value)
 * @method static Builder|ActivityLog whereDescription($value)
 * @method static Builder|ActivityLog whereId($value)
 * @method static Builder|ActivityLog whereIp($value)
 * @method static Builder|ActivityLog whereLogName($value)
 * @method static Builder|ActivityLog whereProperties($value)
 * @method static Builder|ActivityLog whereSubjectId($value)
 * @method static Builder|ActivityLog whereSubjectType($value)
 * @method static Builder|ActivityLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ActivityLog extends Activity
{
    use LegacySerializeDate;
}
