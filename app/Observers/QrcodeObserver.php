<?php

namespace App\Observers;

use App\Qrcode;
use Carbon\Carbon;

class QrcodeObserver
{
    public function creating(Qrcode $qrcode)
    {
        //若code為空、該code已存在、code太像NID等情況
        while (empty($qrcode->code)
            || Qrcode::where('code', $qrcode->code)->count() != 0
            || preg_match('#^[a-zA-Z]\d+$#', $qrcode->code)
        ) {
            //隨機產生長度8的大寫英文數字字串
            $code = strtoupper(str_random(8));
            $qrcode->code = $code;
        }
    }

    public function saving(Qrcode $qrcode)
    {
        //剛綁定
        if ($qrcode->student_id && $qrcode->isDirty('student_id')) {
            $qrcode->bind_at = Carbon::now();
        }
    }
}
