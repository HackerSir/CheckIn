<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PaymentRecord
 *
 * @property int $id
 * @property string $nid NID
 * @property string|null $name 姓名
 * @property bool|null $is_paid 姓名
 * @property string|null $handler 經手人
 * @property string|null $note 備註
 * @property int|null $user_id 使用者
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentRecord whereHandler($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentRecord whereIsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentRecord whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentRecord whereNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentRecord whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaymentRecord whereUserId($value)
 * @mixin \Eloquent
 */
class PaymentRecord extends Model
{
    protected $fillable = [
        'nid',
        'name',
        'is_paid',
        'handler',
        'note',
        'user_id',
    ];

    protected $casts = [
        'is_paid' => 'bool',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
