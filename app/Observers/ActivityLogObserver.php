<?php

namespace App\Observers;

use App\Models\ActivityLog;

class ActivityLogObserver
{
    public function saving(ActivityLog $activityLog)
    {
        //自動追加記錄IP
        $activityLog->ip = request()->ip();
    }
}
