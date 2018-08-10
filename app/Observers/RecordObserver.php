<?php

namespace App\Observers;

use App\Record;
use App\Ticket;

class RecordObserver
{
    public function created(Record $record)
    {
        //打卡目標
        $target = (int) \Setting::get('target');
        if ($target <= 0) {
            //目標非正，視為未啟用此機制
            return;
        }
        //是否為新生
        if (!$record->student->is_freshman) {
            //非新生無法抽獎
            return;
        }
        //是否已有抽獎編號
        if ($record->student->ticket) {
            //已有抽獎編號
            return;
        }
        //檢查打卡進度
        if (!$record->student->has_enough_counted_records) {
            //未完成
            return;
        }
        //給予抽獎編號
        $record->student->ticket()->save(new Ticket());
    }
}
