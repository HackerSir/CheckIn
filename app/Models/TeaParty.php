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
 * @property int $club_id 對應社團
 * @property string $name 茶會名稱
 * @property Carbon|null $start_at 開始時間
 * @property Carbon|null $end_at 結束時間
 * @property string $location 地點
 * @property string|null $url 網址
 * @property string|null $google_event_id Google日曆活動ID
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Club $club
 * @property-read \Event|null $google_event Google 日曆事件
 * @property-read string|null $google_event_url Google 日曆事件網址
 * @property-read bool $is_ended 是否已結束
 * @property-read bool $is_started 是否已開始
 * @property-read string $state 狀態
 * @property-read string $state_for_list （清單用）狀態
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
     * @comment Google 日曆事件
     *
     * @return Event|null
     */
    public function getGoogleEventAttribute(): ?Event
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
     * @comment Google 日曆事件網址
     *
     * @return string|null
     */
    public function getGoogleEventUrlAttribute(): ?string
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
     * @comment 是否已開始
     *
     * @return bool
     */
    public function getIsStartedAttribute(): bool
    {
        return $this->start_at->isPast();
    }

    /**
     * @comment 是否已結束
     *
     * @return bool
     */
    public function getIsEndedAttribute(): bool
    {
        return $this->end_at->isPast();
    }

    /**
     * @comment 狀態
     *
     * @return string
     */
    public function getStateAttribute(): string
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
     * @comment （清單用）狀態
     * @return string
     */
    public function getStateForListAttribute(): string
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
