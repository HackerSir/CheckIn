<?php

namespace App;

use App\Traits\LegacySerializeDate;
use Illuminate\Database\Eloquent\Model;

/**
 * App\QrcodeSet
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Qrcode[] $qrcodes
 * @property-read int|null $qrcodes_count
 * @method static \Illuminate\Database\Eloquent\Builder|QrcodeSet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QrcodeSet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QrcodeSet query()
 * @method static \Illuminate\Database\Eloquent\Builder|QrcodeSet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QrcodeSet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QrcodeSet whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QrcodeSet extends Model
{
    use LegacySerializeDate;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function qrcodes()
    {
        return $this->hasMany(Qrcode::class);
    }
}
