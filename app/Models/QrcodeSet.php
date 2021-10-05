<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\QrcodeSet
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|\App\Models\Qrcode[] $qrcodes
 * @property-read int|null $qrcodes_count
 *
 * @method static Builder|QrcodeSet newModelQuery()
 * @method static Builder|QrcodeSet newQuery()
 * @method static Builder|QrcodeSet query()
 * @method static Builder|QrcodeSet whereCreatedAt($value)
 * @method static Builder|QrcodeSet whereId($value)
 * @method static Builder|QrcodeSet whereUpdatedAt($value)
 * @mixin Eloquent
 */
class QrcodeSet extends Model
{
    use LegacySerializeDate;

    /**
     * @return HasMany|Builder
     */
    public function qrcodes()
    {
        return $this->hasMany(Qrcode::class);
    }
}
