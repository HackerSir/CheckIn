<?php

namespace App;

/**
 * App\ContactInformation
 *
 * @property string $student_nid 對應學生
 * @property string|null $phone 聯絡電話
 * @property string|null $email 聯絡信箱
 * @property string|null $facebook FB個人檔案連結
 * @property string|null $line LINE ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read \App\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactInformation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactInformation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactInformation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactInformation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactInformation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactInformation whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactInformation whereLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactInformation wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactInformation whereStudentNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactInformation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContactInformation extends LoggableModel
{
    protected static $logName = 'contact-information';
    protected $primaryKey = 'student_nid';
    public $incrementing = false;

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
