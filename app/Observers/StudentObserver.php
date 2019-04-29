<?php

namespace App\Observers;

use App\Student;

class StudentObserver
{
    /**
     * Handle the student "saving" event.
     *
     * @param  \App\Student $student
     * @return void
     */
    public function saving(Student $student)
    {
        $student->nid = trim(strtoupper($student->nid));
    }
}
