<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

/**
 * App\Models\ContactInformation
 *
 * @property string $student_nid
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $facebook
 * @property string|null $line
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read Student $student
 * @method static Builder|ContactInformation newModelQuery()
 * @method static Builder|ContactInformation newQuery()
 * @method static Builder|ContactInformation query()
 * @method static Builder|ContactInformation whereCreatedAt($value)
 * @method static Builder|ContactInformation whereEmail($value)
 * @method static Builder|ContactInformation whereFacebook($value)
 * @method static Builder|ContactInformation whereLine($value)
 * @method static Builder|ContactInformation wherePhone($value)
 * @method static Builder|ContactInformation whereStudentNid($value)
 * @method static Builder|ContactInformation whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ContactInformation extends LoggableModel
{
    use LegacySerializeDate;
    use HasFactory;

    protected static $logName = 'contact-information';
    public $incrementing = false;
    protected $primaryKey = 'student_nid';
    protected $keyType = 'string';

    protected $fillable = [
        'student_nid',
        'phone',
        'email',
        'facebook',
        'line',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    protected function getNameForActivityLog(): string
    {
        return $this->student->display_name . ' 的聯絡資訊';
    }
}