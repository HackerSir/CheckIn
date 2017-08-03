<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ExtraTicket
 *
 * @property int $id
 * @property string $nid 學號
 * @property string $name 姓名
 * @property string $class 系級
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExtraTicket whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExtraTicket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExtraTicket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExtraTicket whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExtraTicket whereNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExtraTicket whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ExtraTicket extends Model
{
    protected $fillable = [
        'nid',
        'name',
        'class',
    ];
}
