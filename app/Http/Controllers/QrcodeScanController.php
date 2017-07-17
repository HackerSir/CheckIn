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
        //找出 QR Code
        $qrcode = Qrcode::where('code', $code)->first();
        //TODO
        dd($code, $qrcode);
    }
}
