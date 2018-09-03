<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Qrcode;
use App\Services\FcuApiService;
use App\Services\StudentService;
use App\Services\UserService;

class OAuthController extends Controller
{
    /**
     * @var FcuApiService
     */
    private $fcuApiService;
    /**
     * @var StudentService
     */
    private $studentService;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * OAuthController constructor.
     * @param FcuApiService $fcuApiService
     * @param StudentService $studentService
     * @param UserService $userService
     */
    public function __construct(FcuApiService $fcuApiService, StudentService $studentService, UserService $userService)
    {
        $this->fcuApiService = $fcuApiService;
        $this->studentService = $studentService;
        $this->userService = $userService;
        $this->middleware('guest');
    }

    public function index()
    {
        //檢查設定
        $OAuthUrl = config('services.fcu-api.url-oauth');
        $clientId = config('services.fcu-api.client-id');
        $clientUrl = config('services.fcu-api.client-url');
        if (!$OAuthUrl || !$clientId || !$clientUrl) {
            return back()->with('warning', '目前未開放');
        }
        $data = [
            'client_id'  => $clientId,
            'client_url' => $clientUrl,
        ];
        //重導向到OAuth登入頁面
        $redirectUrl = $OAuthUrl . '?' . http_build_query($data);

        return redirect($redirectUrl);
    }

    public function login()
    {
        $userCode = \Request::get('user_code');
        if (!$userCode) {
            return redirect()->route('index')->with('warning', '登入失敗(c)');
        }

        //利用User Code取得學號
        $userInfo = $this->fcuApiService->getLoginUser($userCode);
        //檢查登入結果
        if (!is_array($userInfo) || !isset($userInfo['stu_id']) || empty($userInfo['stu_id'])) {
            return redirect()->route('index')->with('warning', '登入失敗(u)');
        }
        $nid = $userInfo['stu_id'];

        //找出使用者
        $user = $this->userService->findOrCreateByNid($userInfo['stu_id']);
        //登入使用者
        auth()->login($user, true);

        //取得學生資料
        $student = $this->studentService->updateOrCreate($nid);
        if (!$student) {
            //無學生資料，直接結束流程
            return redirect()->route('index');
        }
        //使用者未綁定學生
        if (!$user->student) {
            //綁定學生
            $user->student()->save($student);
        }
        //若學生沒有QR Code
        if (!$student->qrcode) {
            //綁定QRCode
            $student->qrcode()->save(Qrcode::create());
        }
        //更新名稱
        $user->update(['name' => $student->name]);

        return redirect()->intended();
    }
}
