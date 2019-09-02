<?php

namespace App;

/**
 * App\ExtraTicket
 *
 * @property int $id
 * @property string $nid 學號
 * @property string $name 姓名
 * @property string|null $class 系級
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExtraTicket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExtraTicket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExtraTicket query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExtraTicket whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExtraTicket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExtraTicket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExtraTicket whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExtraTicket whereNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExtraTicket whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ExtraTicket extends LoggableModel
{
    protected static $logName = 'extra-ticket';
    protected $fillable = [
        'id',
        'nid',
        'name',
        'class',
    ];

    protected function getNameForActivityLog(): string
    {
        return $this->name . '的工作人員抽獎編號';
    }
}
