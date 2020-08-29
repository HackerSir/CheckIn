<?php

namespace App\Services;

use App\TeaParty;
use Spatie\GoogleCalendar\Event;

class GoogleCalendarService
{
    /**
     * @var boolean
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
        if ($teaParty->google_event_id) {
            // 嘗試找出存在的活動
            $event = Event::find($teaParty->google_event_id);
        }
        if (!$event) {
            // 建立活動
            $event = new Event();
        }

        $event->name = $teaParty->name;
        $event->startDateTime = $teaParty->start_at;
        $event->endDateTime = $teaParty->end_at;
        $event->location = $teaParty->location;
        $event->description = '';
        if ($teaParty->url) {
            $event->description .= '活動網址：' . link_to($teaParty->url, $teaParty->url) . '<br/>';
        }
        $event->description .= '社團：' . link_to_route('clubs.show', $teaParty->club->name, $teaParty->club) . '<br/>'
            . '<br/>'
            . '更新時間：' . $teaParty->updated_at . '<br/>'
            . link_to('/', 'CheckIn 逢甲社博集點');


        $event = $event->save();

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
