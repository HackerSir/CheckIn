<?php

namespace App\Http\Controllers;

use App\Models\Qrcode;
use App\Models\User;
use App\Services\QrcodeScanService;
use Exception;
use ExtendThrottle;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\View\View;

class QrcodeScanController extends Controller
{
    /**
     * 掃描QRCode
     *
     * @param QrcodeScanService $qrcodeScanService
     * @param $code
     * @return Response
     * @throws Exception
     */
    public function scan(QrcodeScanService $qrcodeScanService, $code)
    {
        /** @var User $user */
        $user = auth()->user();

        view()->share(compact('code'));
        //檢查冷卻（每分鐘60次）
        $throttle = ExtendThrottle::get('qrcode scan ' . $user->id, 60, 1);
        if (!$throttle->attempt()) {
            return view('qrcode-scan.scan')->with('level', 'danger')->with('message', '掃描過於頻繁，請稍候重試');
        }

        // 是否使用網站內建掃描器掃描
        $webScan = request('from') == 'web-scan';
        // 掃描
        $scanResult = $qrcodeScanService->scan($user, $code, $webScan);

        // 找出 QR Code
        /** @var Qrcode $qrcode */
        $qrcode = Qrcode::where('code', $code)->with('student.records.club.clubType')->first();
        if ($qrcode) {
            view()->share(compact('qrcode'));
        }

        if (isset($scanResult['level']) && isset($scanResult['message'])) {
            return view('qrcode-scan.scan')
                ->with('level', $scanResult['level'])
                ->with('message', $scanResult['message']);
        } else {
            return view('qrcode-scan.scan');
        }
    }

    public function webScan()
    {
        return view('qrcode-scan.web-scan');
    }

    /**
     * @param QrcodeScanService $qrcodeScanService
     * @param $code
     * @return array|Factory|View
     * @throws Exception
     */
    public function webScanApi(QrcodeScanService $qrcodeScanService, $code)
    {
        /** @var User $user */
        $user = auth()->user();

        //檢查冷卻（每分鐘60次）
        $throttle = ExtendThrottle::get('qrcode scan ' . $user->id, 60, 1);
        if (!$throttle->attempt()) {
            return [
                'success' => false,
                'level'   => 'danger',
                'message' => '掃描過於頻繁，請稍候重試',
            ];
        }

        // 掃描
        $scanResult = $qrcodeScanService->scan($user, $code, true);

        // 找出 QR Code
        /** @var Qrcode $qrcode */
        $qrcode = Qrcode::where('code', $code)->with('student.records.club.clubType')->first();
        if ($qrcode) {
            if ($qrcode->student) {
                $scanResult['student_name'] = $qrcode->student->masked_display_name;
            }
        }

        return $scanResult;
    }
}
