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
        view()->share(compact('code'));
        //找出 QR Code
        /** @var Qrcode $qrcode */
        $qrcode = Qrcode::where('code', $code)->with('student.records.club.clubType')->first();
        if (!$qrcode) {
            return view('qrcode-scan.scan')->with('level', 'danger')->with('message', 'QR Code無效');
        }
        view()->share(compact('qrcode'));

        //檢查QR Code是否已經被學生綁定
        if (!$qrcode->student) {
            return view('qrcode-scan.scan')->with('level', 'danger')->with('message', '該QR Code不屬於任何學生');
        }

        //檢查是否屬於活動時間
        $startAt = new Carbon(Setting::get('start_at'));
        if ($startAt->gte(Carbon::now())) {
            return view('qrcode-scan.scan')->with('level', 'info')->with('message', '活動尚未開始');
        }
        $endAt = new Carbon(Setting::get('end_at'));
        if ($endAt->lte(Carbon::now())) {
            return view('qrcode-scan.scan')->with('level', 'info')->with('message', '活動已經結束');
        }

        //檢查掃描使用者是否為社團負責人
        /** @var Club $club */
        $user = auth()->user();
        $club = $user->club;
        if (!$club) {
            //非社團負責人，不顯示訊息
            return view('qrcode-scan.scan');
        }

        //檢查QR Code最後一組QR Code
        if (!$qrcode->is_last_one) {
            return view('qrcode-scan.scan')->with('level', 'danger')->with('message', '非最後一組 QR Code');
        }

        //檢查是否在該攤位重複打卡
        /** @var Record $existRecord */
        $existRecord = Record::where('student_id', $qrcode->student->id)
            ->where('club_id', $club->id)
            ->first();
        if ($existRecord) {
            $createdAtForHumans = (new Carbon($existRecord->created_at))->diffForHumans();

            return view('qrcode-scan.scan')->with('level', 'warning')
                ->with('message', "已於 {$existRecord->created_at}（{$createdAtForHumans}） 在「{$club->name}」打卡");
        }

        //打卡
        Record::query()->firstOrCreate([
            'student_id' => $qrcode->student->id,
            'club_id'    => $club->id,
        ], [
            'ip' => request()->getClientIp(),
        ]);

        //重新取得資料
        $qrcode = $qrcode->fresh();
        view()->share(compact('qrcode'));

        return view('qrcode-scan.scan')->with('level', 'success')->with('message', "在「{$club->name}」打卡完成");
    }
}
