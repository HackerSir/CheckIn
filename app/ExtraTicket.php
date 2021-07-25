<?php

namespace App;

use App\Traits\LegacySerializeDate;

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
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraTicket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraTicket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraTicket query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraTicket whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraTicket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraTicket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraTicket whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraTicket whereNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraTicket whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ExtraTicket extends LoggableModel
{
    use LegacySerializeDate;

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
