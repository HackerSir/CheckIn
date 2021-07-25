<?php

namespace App\Observers;

use App\Models\Feedback;

class FeedbackObserver
{
    public function saving(Feedback $feedback)
    {
        //檢查欄位
        $checkFields = ['phone', 'email', 'facebook', 'line'];
        $prefixedCheckFields = preg_filter('/^/', 'include_', $checkFields);
        //都未修改時不做處理
        if (!$feedback->isDirty($prefixedCheckFields)) {
            return;
        }
        //同步資料
        $feedback->syncContactInformation();
    }
}
