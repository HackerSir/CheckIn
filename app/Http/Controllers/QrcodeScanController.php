<?php

namespace App\Http\Controllers;

use App\Club;
use App\Qrcode;
use App\Record;
use App\User;
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
        /** @var User $user */
        $user = auth()->user();

        view()->share(compact('code'));
        //檢查冷卻（每分鐘60次）
        $throttle = \ExtendThrottle::get('qrcode scan ' . $user->id, 60, 1);
        if (!$throttle->attempt()) {
            return view('qrcode-scan.scan')->with('level', 'danger')->with('message', '掃描過於頻繁，請稍候重試');
        }

        //找出 QR Code
        /** @var Qrcode $qrcode */
        $qrcode = Qrcode::where('code', $code)->with('student.records.club.clubType')->first();
        if (!$qrcode) {
            return view('qrcode-scan.scan')->with('level', 'danger')->with('message', '無效的 QR Code');
        }
        view()->share(compact('qrcode'));

        //檢查QR Code是否已經被學生綁定
        if (!$qrcode->student) {
            return view('qrcode-scan.scan')->with('level', 'danger')->with('message', 'QR Code 尚未綁定，請聯絡課外活動組');
        }

        //檢查是否屬於活動時間
        $startAt = new Carbon(Setting::get('start_at'));
        if ($startAt->gte(Carbon::now())) {
            $startAtText = $startAt . '（' . $startAt->diffForHumans() . '）';

            return view('qrcode-scan.scan')->with('level', 'info')
                ->with('message', '集點活動尚未開始，預計在 ' . $startAtText . ' 開始');
        }
        $endAt = new Carbon(Setting::get('end_at'));
        if ($endAt->lte(Carbon::now())) {
            $endAtText = $endAt . '（' . $endAt->diffForHumans() . '）';

            return view('qrcode-scan.scan')->with('level', 'info')->with('message', '集點活動已在 ' . $endAtText . ' 結束');
        }

        //檢查掃描使用者是否為攤位負責人
        /** @var Club $club */
        $club = $user->club;
        if (!$club) {
            //非攤位負責人，不顯示訊息
            return view('qrcode-scan.scan');
        }

        //檢查QR Code為最後一組QR Code
        if (!$qrcode->is_last_one) {
            $lastBindingTime = $qrcode->student->qrcode->bind_at;
            $lastBindingTimeText = $lastBindingTime . '（' . $lastBindingTime->diffForHumans() . '）';

            return view('qrcode-scan.scan')->with('level', 'danger')
                ->with('message', '非最後一組 QR Code，請使用於 ' . $lastBindingTimeText . ' 綁定之 QR Code');
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
