<?php

namespace App;

use App\Traits\LegacySerializeDate;

/**
 * App\TeaParty
 *
 * @property int $club_id 對應社團
 * @property string $name 茶會名稱
 * @property \Illuminate\Support\Carbon|null $start_at 開始時間
 * @property \Illuminate\Support\Carbon|null $end_at 結束時間
 * @property string $location 地點
 * @property string|null $url 網址
 * @property string|null $google_event_id Google日曆活動ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Club $club
 * @property-read \Spatie\GoogleCalendar\Event|null $google_event
 * @property-read string|null $google_event_url
 * @property-read bool $is_ended
 * @property-read bool $is_started
 * @property-read string $state
 * @property-read string $state_for_list
 * @method static \Illuminate\Database\Eloquent\Builder|TeaParty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeaParty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeaParty query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeaParty whereClubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeaParty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeaParty whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeaParty whereGoogleEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeaParty whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeaParty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeaParty whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeaParty whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeaParty whereUrl($value)
 * @mixin \Eloquent
 */
class TeaParty extends LoggableModel
{
    use LegacySerializeDate;

    protected $primaryKey = 'club_id';
    public $incrementing = false;
    protected static $logName = 'club';

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * @return \Spatie\GoogleCalendar\Event|null
     */
    public function getGoogleEventAttribute()
    {
        if (!$this->google_event_id) {
            return null;
        }
        try {
            //TODO: 可能需要暫存？
            return \Spatie\GoogleCalendar\Event::find($this->google_event_id);
        } catch (\Google_Service_Exception $exception) {
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
        } catch (\Exception $e) {
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

    protected function getNameForActivityLog(): string
    {
        return $this->club->name . ' 的茶會資訊';
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
}
