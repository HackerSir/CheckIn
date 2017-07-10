<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
