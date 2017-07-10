<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Feedback
 *
 * @property int $id
 * @property int|null $student_id 對應學生
 * @property int|null $club_id 對應社團
 * @property string|null $phone 聯絡電話
 * @property string|null $email 聯絡信箱
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereClubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Feedback whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Feedback extends Model
{
    protected $fillable = [
        'student_id',
        'club_id',
        'phone',
        'email',
    ];
}
