<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use Eloquent;
use Exception;
use Google_Service_Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;
use Spatie\GoogleCalendar\Event;

/**
 * App\Models\TeaParty
 *
 * @property int $club_id
 * @property string $name
 * @property Carbon|null $start_at
 * @property Carbon|null $end_at
 * @property string $location
 * @property string|null $url
 * @property string|null $google_event_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read Club $club
 * @property-read Event|null $google_event
 * @property-read string|null $google_event_url
 * @property-read bool $is_ended
 * @property-read bool $is_started
 * @property-read string $state
 * @property-read string $state_for_list
 * @method static Builder|TeaParty newModelQuery()
 * @method static Builder|TeaParty newQuery()
 * @method static Builder|TeaParty query()
 * @method static Builder|TeaParty whereClubId($value)
 * @method static Builder|TeaParty whereCreatedAt($value)
 * @method static Builder|TeaParty whereEndAt($value)
 * @method static Builder|TeaParty whereGoogleEventId($value)
 * @method static Builder|TeaParty whereLocation($value)
 * @method static Builder|TeaParty whereName($value)
 * @method static Builder|TeaParty whereStartAt($value)
 * @method static Builder|TeaParty whereUpdatedAt($value)
 * @method static Builder|TeaParty whereUrl($value)
 * @mixin Eloquent
 */
class TeaParty extends LoggableModel
{
    use LegacySerializeDate;

    protected static $logName = 'club';
    public $incrementing = false;
    protected $primaryKey = 'club_id';
    protected $fillable = [
        'club_id',
        'name',
        'start_at',
        'end_at',
        'location',
        'url',
        'google_event_id',
    ];

    protected $dates = [
        'start_at',
        'end_at',
    ];

    protected $appends = [
        'state',
    ];

    /**
     * @return BelongsTo
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * @return Event|null
     */
    public function getGoogleEventAttribute()
    {
        if (!$this->google_event_id) {
            return null;
        }
        try {
            //TODO: 可能需要暫存？
            return Event::find($this->google_event_id);
        } catch (Google_Service_Exception $exception) {
            return null;
        }
    }

    /**
     * @return string|null
     */
    public function getGoogleEventUrlAttribute()
    {
        if (!$this->google_event_id) {
            return null;
        }
        $rememberKey = sprintf('tp_%s_gevent_url_%s', $this->id, $this->updated_at);
        try {
            $url = cache()->remember($rememberKey, now()->addDay(), function () {
                return $this->google_event->htmlLink;
            });
        } catch (Exception $e) {
            return null;
        }

        return $url;
    }

    /**
     * @return bool
     */
    public function getIsStartedAttribute()
    {
        return $this->start_at->isPast();
    }

    /**
     * @return bool
     */
    public function getIsEndedAttribute()
    {
        return $this->end_at->isPast();
    }

    /**
     * @return string
     */
    public function getStateAttribute()
    {
        if ($this->is_ended) {
            return 'ended';
        }
        if ($this->is_started) {
            return 'in_process';
        }

        return 'not_started';
    }

    /**
     * @return string
     */
    public function getStateForListAttribute()
    {
        // 給茶會清單使用的狀態，開始超過五天也算結束
        if ($this->is_ended || $this->start_at->clone()->addDays(5)->isPast()) {
            return 'ended';
        }
        if ($this->is_started) {
            return 'in_process';
        }

        return 'not_started';
    }

    /**
     * 儲存但不觸發 Observer 監聽的 Model 事件
     *
     * @param array $options
     * @return mixed
     */
    public function saveWithoutEvents(array $options = [])
    {
        return static::withoutEvents(function () use ($options) {
            return $this->save($options);
        });
    }

    protected function getNameForActivityLog(): string
    {
        return $this->club->name . ' 的茶會資訊';
    }
}
