<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

/**
 * App\PaymentRecord
 *
 * @property int $id
 * @property int $club_id 社團
 * @property string $nid NID
 * @property string|null $name 姓名
 * @property bool|null $is_paid 已付清
 * @property string|null $handler 經手人
 * @property string|null $note 備註
 * @property int|null $user_id 使用者
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Club $club
 * @property-read \App\Student $student
 * @property-read \App\User|null $user
 * @method static Builder|PaymentRecord newModelQuery()
 * @method static Builder|PaymentRecord newQuery()
 * @method static Builder|PaymentRecord query()
 * @method static Builder|PaymentRecord whereClubId($value)
 * @method static Builder|PaymentRecord whereCreatedAt($value)
 * @method static Builder|PaymentRecord whereHandler($value)
 * @method static Builder|PaymentRecord whereId($value)
 * @method static Builder|PaymentRecord whereIsPaid($value)
 * @method static Builder|PaymentRecord whereName($value)
 * @method static Builder|PaymentRecord whereNid($value)
 * @method static Builder|PaymentRecord whereNote($value)
 * @method static Builder|PaymentRecord whereUpdatedAt($value)
 * @method static Builder|PaymentRecord whereUserId($value)
 * @mixin \Eloquent
 */
class PaymentRecord extends LoggableModel
{
    protected static $logName = 'payment-record';
    protected $fillable = [
        'nid',
        'name',
        'is_paid',
        'handler',
        'note',
        'user_id',
        'club_id',
    ];

    protected $casts = [
        'is_paid' => 'bool',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * 對應學生，必須有填寫該社團回饋資料，且對於參與社團或茶會有意願
     * @return Builder|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'nid', 'nid')->whereHas('feedback', function ($query) {
            /** @var Builder|Feedback $query */
            //FIXME: $this->club_id 這用法似乎會導致無法進行 Eager loading
            $query->where('club_id', $this->club_id)
                ->where(function ($query) {
                    /** @var Builder|Feedback $query */
                    $query->where('join_club_intention', '<>', 0)
                        ->orWhere('join_tea_party_intention', '<>', 0);
                });
        });
    }

    protected function getNameForActivityLog(): string
    {
        return $this->name . ' 在 ' . $this->club->name . ' 的繳費紀錄';
    }
}
