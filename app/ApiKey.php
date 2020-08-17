<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ApiKey
 *
 * @property int $id
 * @property string $api_key
 * @property int $count 使用次數
 * @property int $total_count 總使用次數
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey whereApiKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey whereTotalCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiKey whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApiKey extends Model
{
    protected $fillable = [
        'api_key',
        'count',
        'total_count',
    ];
}
