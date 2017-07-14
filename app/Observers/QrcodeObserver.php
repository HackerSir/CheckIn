<?php

namespace App\Observers;

use App\Qrcode;

class QrcodeObserver
{
    public function creating(Qrcode $qrcode)
    {
        //若code為空，或該code已存在
        if (empty($qrcode->code) || Qrcode::where('code', $qrcode->code)->count() != 0) {
            do {
                //隨機產生長度8的大寫英文數字字串
                $code = strtoupper(str_random(8));
            } while (Qrcode::where('code', $code)->count() != 0);
            $qrcode->code = $code;
        }
    }
}
