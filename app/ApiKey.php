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
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApiKey whereApiKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApiKey whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApiKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApiKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApiKey whereTotalCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApiKey whereUpdatedAt($value)
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
