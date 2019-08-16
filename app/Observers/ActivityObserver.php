<?php

namespace App\Observers;

use Spatie\Activitylog\Models\Activity;

class ActivityObserver
{
    public function saving(Activity $activity)
    {
        //自動追加記錄IP
        $activity->properties = $activity->properties->put('ip', request()->ip());
    }
}
