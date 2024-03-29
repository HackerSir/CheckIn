<?php

namespace App\Observers;

use App\Models\TeaParty;
use App\Services\GoogleCalendarService;

class TeaPartyObserver
{
    /**
     * Handle the tea party "saved" event.
     *
     * @param  TeaParty  $teaParty
     * @return void
     */
    public function saved(TeaParty $teaParty)
    {
        $googleCalendarService = app(GoogleCalendarService::class);
        $googleCalendarService->updateEvent($teaParty);
    }

    /**
     * Handle the tea party "deleted" event.
     *
     * @param  TeaParty  $teaParty
     * @return void
     */
    public function deleted(TeaParty $teaParty)
    {
        $googleCalendarService = app(GoogleCalendarService::class);
        $googleCalendarService->deleteEvent($teaParty);
    }
}
