<?php

namespace App\Observers;

use App\Qrcode;
use App\Student;

class StudentObserver
{
    public function created(Student $student)
    {
        //若是新生
        if ($student->is_freshman) {
            //自動綁定QRCode
            $student->qrcode()->save(Qrcode::create());
        }
    }
}
