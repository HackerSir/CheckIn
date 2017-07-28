<?php

namespace App\Http\Controllers;

use App\Club;
use App\Qrcode;
use App\Record;
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
        /** @var Club $club */
//        $user = auth()->user();
//        $club = $user->club;
        $club = Club::first();
        if (!$club) {
            dd('非攤位負責人');
        }

        //檢查QR Code最後一組QR Code
        if (!$qrcode->is_last_one) {
            dd('非最後一組 QR Code');
        }

        //檢查是否在該攤位重複打卡
        /** @var Record $existRecord */
        $existRecord = Record::where('student_id', $qrcode->student->id)
            ->where('club_id', $club->id)
            ->first();
        if ($existRecord) {
            dd('已於 ' . $existRecord->created_at . ' 打卡');
        }

        //打卡
        $record = Record::query()->firstOrCreate([
            'student_id' => $qrcode->student->id,
            'club_id'    => $club->id,
        ], [
            'ip' => request()->getClientIp(),
        ]);

        dd($code, $qrcode, $record);
    }
}
