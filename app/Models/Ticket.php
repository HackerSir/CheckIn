<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Ticket
 *
 * @property int $id
 * @property string|null $student_nid 對應學生
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Student|null $student
 *
 * @method static \Database\Factories\TicketFactory factory(...$parameters)
 * @method static Builder|Ticket newModelQuery()
 * @method static Builder|Ticket newQuery()
 * @method static Builder|Ticket query()
 * @method static Builder|Ticket whereCreatedAt($value)
 * @method static Builder|Ticket whereId($value)
 * @method static Builder|Ticket whereStudentNid($value)
 * @method static Builder|Ticket whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Ticket extends Model
{
    use LegacySerializeDate;
    use HasFactory;

    protected $fillable = [
        'student_nid',
    ];

    /**
     * @return BelongsTo|Builder
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_nid', 'nid');
    }
}
