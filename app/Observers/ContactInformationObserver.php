<?php

namespace App\Observers;

use App\ContactInformation;

class ContactInformationObserver
{
    public function saving(ContactInformation $contactInformation)
    {
        //檢查欄位
        $checkFields = ['phone', 'email', 'facebook', 'line'];
        //都未修改時不做處理
        if (!$contactInformation->isDirty($checkFields)) {
            return;
        }
        //找出對應回饋資料，併逐一同步資料
        foreach ($contactInformation->student->feedback as $feedback) {
            //同步資料
            foreach ($checkFields as $checkField) {
                $feedback->$checkField = $feedback->{'include_' . $checkField}
                    ? $contactInformation->$checkField : null;
            }
            //不更新 updated_at
            $feedback->timestamps = false;
            $feedback->save();
        }
    }
}
