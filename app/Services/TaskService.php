<?php

namespace App\Services;

use App\Student;
use App\Ticket;

class TaskService
{
    public function checkProgress(Student $student)
    {
        //打卡目標
        $target = (int) \Setting::get('target');
        if ($target <= 0) {
            //目標非正，視為未啟用此機制
            return;
        }
        //是否為新生
        if (!$student->is_freshman) {
            //非新生無法抽獎
            return;
        }
        //是否已有抽獎編號
        if ($student->ticket) {
            //已有抽獎編號
            return;
        }
        //檢查打卡進度
        if (!$student->has_enough_counted_records) {
            //未完成
            return;
        }
        //給予抽獎編號
        $student->ticket()->save(new Ticket());
    }
}
