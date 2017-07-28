<?php

namespace App\Http\Controllers;

use App\Qrcode;

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
        //TODO:檢查是否屬於活動時間

        //找出 QR Code
        $qrcode = Qrcode::where('code', $code)->first();

        //TODO:檢查QR Code是否已經被學生綁定
        //TODO:檢查掃描使用者是否為攤位負責人
        //TODO:檢查QR Code最後一組QR Code
        //TODO:檢查是否在該攤位重複打卡
        //TODO:打卡
        dd($code, $qrcode);
    }
}
