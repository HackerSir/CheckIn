<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ApiKey
 *
 * @property int $id
 * @property string $api_key
 * @property int $count 使用次數
 * @property int $total_count 總使用次數
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Database\Factories\ApiKeyFactory factory(...$parameters)
 * @method static Builder|ApiKey newModelQuery()
 * @method static Builder|ApiKey newQuery()
 * @method static Builder|ApiKey query()
 * @method static Builder|ApiKey whereApiKey($value)
 * @method static Builder|ApiKey whereCount($value)
 * @method static Builder|ApiKey whereCreatedAt($value)
 * @method static Builder|ApiKey whereId($value)
 * @method static Builder|ApiKey whereTotalCount($value)
 * @method static Builder|ApiKey whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ApiKey extends Model
{
    use LegacySerializeDate;
    use HasFactory;

    protected $fillable = [
        'api_key',
        'count',
        'total_count',
    ];
}
