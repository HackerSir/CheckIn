<?php

namespace App\Observers;

use App\Models\ActivityLog;

class ActivityLogObserver
{
    public function saving(ActivityLog $activity)
    {
        //自動追加記錄IP
        $activity->properties = $activity->properties->put('ip', request()->ip());
    }
}
