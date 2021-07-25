<?php

namespace App\Observers;

use App\Models\Record;
use App\Services\TaskService;

class RecordObserver
{
    public function created(Record $record)
    {
        $taskService = app(TaskService::class);
        $taskService->checkProgress($record->student);
    }
}
