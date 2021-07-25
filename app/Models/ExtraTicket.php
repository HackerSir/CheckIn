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
 * App\Models\ExtraTicket
 *
 * @property int $id
 * @property string $nid
 * @property string $name
 * @property string|null $class
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Activity[] $activities
 * @property-read int|null $activities_count
 * @method static Builder|ExtraTicket newModelQuery()
 * @method static Builder|ExtraTicket newQuery()
 * @method static Builder|ExtraTicket query()
 * @method static Builder|ExtraTicket whereClass($value)
 * @method static Builder|ExtraTicket whereCreatedAt($value)
 * @method static Builder|ExtraTicket whereId($value)
 * @method static Builder|ExtraTicket whereName($value)
 * @method static Builder|ExtraTicket whereNid($value)
 * @method static Builder|ExtraTicket whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ExtraTicket extends LoggableModel
{
    use LegacySerializeDate;
    use HasFactory;

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
