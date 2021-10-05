<?php

namespace App\Observers;

use App\Models\Student;

class StudentObserver
{
    /**
     * Handle the student "saving" event.
     *
     * @param  Student  $student
     * @return void
     */
    public function saving(Student $student)
    {
        $student->nid = trim(strtoupper($student->nid));
    }
}
