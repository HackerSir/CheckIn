<?php

namespace App\Observers;

use App\Models\StudentSurvey;
use App\Services\TaskService;

class StudentSurveyObserver
{
    public function saved(StudentSurvey $studentSurvey)
    {
        $taskService = app(TaskService::class);
        $taskService->checkProgress($studentSurvey->student);
    }
}
