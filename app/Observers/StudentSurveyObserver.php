<?php

namespace App\Observers;

use App\Services\TaskService;
use App\StudentSurvey;

class StudentSurveyObserver
{
    public function saved(StudentSurvey $studentSurvey)
    {
        $taskService = app(TaskService::class);
        $taskService->checkProgress($studentSurvey->student);
    }
}
