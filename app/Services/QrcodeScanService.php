<?php

namespace App\Services;

use App\Events\CheckInAlert;
use App\Events\CheckInSuccess;
use App\Models\Club;
use App\Models\Qrcode;
use App\Models\Record;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Setting;

class QrcodeScanService
{
    /**
     * @param  User  $user
     * @param  string  $code
     * @param  bool  $webScan
     * @return array|Factory|View
     *
     * @throws Exception
     */
    public function scan(User $user, string $code, bool $webScan = false): array
    {
        //找出 QR Code
        /** @var Qrcode $qrcode */
        $qrcode = Qrcode::where('code', $code)->with('student.records.club.clubType')->first();
        if (!$qrcode) {
            return [
                'success' => false,
                'level'   => 'danger',
                'message' => '無效的 QR Code',
            ];
        }

        //檢查QR Code是否已經被學生綁定
        if (!$qrcode->student) {
            return [
                'success' => false,
                'level'   => 'danger',
                'message' => 'QR Code 尚未綁定，請聯絡服務台',
            ];
        }

        //檢查是否屬於活動時間
        $startAt = new Carbon(Setting::get('start_at'));
        if ($startAt->gte(Carbon::now())) {
            $startAtText = $startAt . '（' . $startAt->diffForHumans() . '）';

            return [
                'success' => false,
                'level'   => 'info',
                'message' => '集點活動尚未開始，預計在 ' . $startAtText . ' 開始',
            ];
        }
        $endAt = new Carbon(Setting::get('end_at'));
        if ($endAt->lte(Carbon::now())) {
            $endAtText = $endAt . '（' . $endAt->diffForHumans() . '）';

            return [
                'success' => false,
                'level'   => 'info',
                'message' => '集點活動已在 ' . $endAtText . ' 結束',
            ];
        }

        //檢查掃描使用者是否為攤位負責人
        /** @var Club $club */
        $club = $user->club;
        if (!$club) {
            //非攤位負責人，不顯示訊息
            return [
                'success' => false,
            ];
        }

        //檢查QR Code為最後一組QR Code
        if (!$qrcode->is_last_one) {
            $lastBindingTime = $qrcode->student->qrcode->bind_at;
            $lastBindingTimeText = $lastBindingTime . '（' . $lastBindingTime->diffForHumans() . '）';

            return [
                'success' => false,
                'level'   => 'danger',
                'message' => '非最後一組 QR Code，請使用於 ' . $lastBindingTimeText . ' 綁定之 QR Code',
            ];
        }

        //檢查是否在該攤位重複打卡
        /** @var Record $existRecord */
        $existRecord = Record::where('student_nid', $qrcode->student->nid)
            ->where('club_id', $club->id)
            ->first();
        if ($existRecord) {
            $createdAtText = $existRecord->created_at . '（' . $existRecord->created_at->diffForHumans() . '）';

            return [
                'success' => false,
                'level'   => 'warning',
                'message' => "已於 {$createdAtText} 在「{$club->name}」打卡",
            ];
        }

        //檢查打卡冷卻時間
        $inCooldown = Record::where('student_nid', $qrcode->student->nid)
            ->where('created_at', '>', now()->subMinutes(3))
            ->exists();
        if ($inCooldown) {
            event(new CheckInAlert($qrcode->student->nid, '每次打卡須間隔 3 分鐘'));

            return [
                'success' => false,
                'level'   => 'danger',
                'message' => '該學生打卡冷卻中，每次打卡須間隔 3 分鐘',
            ];
        }

        //打卡
        /** @var Record $record */
        $record = Record::firstOrCreate([
            'student_nid' => $qrcode->student->nid,
            'club_id'     => $club->id,
        ], [
            'ip'                 => request()->getClientIp(),
            'scanned_by_user_id' => $user->id,
            'web_scan'           => $webScan,
        ]);

        event(new CheckInSuccess($record));

        return [
            'success' => true,
            'level'   => 'success',
            'message' => "在「{$club->name}」打卡完成",
        ];
    }
}
