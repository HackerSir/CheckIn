<?php

namespace App\Http\Controllers;

use App\Qrcode;
use Carbon\Carbon;
use Setting;

class QrcodeScanController extends Controller
{
    /**
     * 掃描QRCode
     *
     * @param $code
     * @return \Illuminate\Http\Response
     */
    public function scan($code)
    {
        //找出 QR Code
        /** @var Qrcode $qrcode */
        $qrcode = Qrcode::where('code', $code)->first();
        if (!$qrcode) {
            dd('QR Code無效');
        }

        //檢查QR Code是否已經被學生綁定
        if (!$qrcode->student) {
            dd('該QR Code不屬於任何學生');
        }

        //檢查是否屬於活動時間
        $startAt = new Carbon(Setting::get('start_at'));
        if ($startAt->gte(Carbon::now())) {
            dd('活動尚未開始');
        }
        $endAt = new Carbon(Setting::get('end_at'));
        if ($endAt->lte(Carbon::now())) {
            dd('活動已經結束');
        }

        //TODO:檢查掃描使用者是否為攤位負責人

        //檢查QR Code最後一組QR Code
        if (!$qrcode->is_last_one) {
            dd('非最後一組 QR Code');
        }

        //TODO:檢查是否在該攤位重複打卡
        //TODO:打卡
        dd($code, $qrcode);
    }
}
