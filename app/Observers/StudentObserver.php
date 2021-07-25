<?php

namespace App\Observers;

use App\Models\Student;
use Illuminate\Support\Str;

class StudentObserver
{
    /**
     * Handle the student "saving" event.
     *
     * @param Student $student
     * @return void
     */
    public function saving(Student $student)
    {
        $student->nid = trim(Str::upper($student->nid));
    }
}
