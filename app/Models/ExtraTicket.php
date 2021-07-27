<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use App\Traits\LogModelEvent;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ExtraTicket
 *
 * @property int $id
 * @property string $nid 學號
 * @property string $name 姓名
 * @property string|null $class 系級
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|\App\Models\ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @method static \Database\Factories\ExtraTicketFactory factory(...$parameters)
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
class ExtraTicket extends Model
{
    use LogModelEvent;
    use LegacySerializeDate;
    use HasFactory;

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
