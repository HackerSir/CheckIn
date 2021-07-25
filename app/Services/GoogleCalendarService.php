<?php

namespace App\Services;

use App\Models\TeaParty;
use Google_Service_Exception;
use Spatie\GoogleCalendar\Event;

class GoogleCalendarService
{
    /**
     * @var bool
     */
    private $enabled = true;

    /**
     * GoogleCalendarService constructor.
     */
    public function __construct()
    {
        if (!config('google-calendar.calendar_id')) {
            $this->enabled = false;
        }
    }

    public function updateEvent(TeaParty $teaParty)
    {
        if (!$this->enabled) {
            return;
        }
        $event = null;
        $originalGoogleEventID = $teaParty->google_event_id;
        if ($originalGoogleEventID) {
            // 嘗試找出存在的活動
            $event = Event::find($originalGoogleEventID);
        }
        if (!$event) {
            // 建立活動
            $event = new Event();
        }

        // 超過5天整的活動視為太長
        $tooLong = $teaParty->start_at->diffInDays($teaParty->end_at) >= 5;
        // 若活動已被手動刪除，將狀態回復到未刪除
        $event->status = 'confirmed';
        $event->name = $teaParty->name;
        $event->startDateTime = $teaParty->start_at;
        $event->endDateTime = $tooLong ? $teaParty->start_at->clone()->addDays(5) : $teaParty->end_at;
        $event->location = $teaParty->location;
        $event->description = '';
        if ($teaParty->url) {
            $event->description .= '活動網址：' . link_to($teaParty->url, $teaParty->url) . '<br/>';
        }
        $event->description .= '社團：' . link_to_route('clubs.show', $teaParty->club->name, $teaParty->club) . '<br/>';
        if ($tooLong) {
            $event->description .= '<b>！！！此活動時間長度超過系統限制，實際結束時間請至 CheckIn 網站確認！！！</b><br/>';
        }
        $event->description .= '<br/>'
            . '更新時間：' . $teaParty->updated_at . '<br/>'
            . link_to('/', 'CheckIn 逢甲社博集點');

        try {
            $event = $event->save();
        } catch (Google_Service_Exception $exception) {
            // 無法儲存活動時，清空活動ID
            $teaParty->google_event_id = null;
            $teaParty->saveWithoutEvents();
            if ($originalGoogleEventID) {
                // 若原本就有活動ID，表示可能是活動被從日曆刪除，且從垃圾桶移除，
                // 導致出現 403 的情況，此時再以無活動ID的前提重新嘗試
                $this->updateEvent($teaParty);

                return;
            }
            throw $exception;
        }

        $teaParty->google_event_id = $event->id;
        $teaParty->saveWithoutEvents();
    }

    public function deleteEvent(TeaParty $teaParty)
    {
        if (!$this->enabled) {
            return;
        }
        if (!$teaParty->google_event_id) {
            return;
        }
        // 嘗試找出存在的活動
        $event = Event::find($teaParty->google_event_id);
        if (!$event) {
            return;
        }
        $event->delete();
        $teaParty->google_event_id = null;
        if ($teaParty->exists()) {
            $teaParty->saveWithoutEvents();
        }
    }
}
