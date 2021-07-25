<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Qrcode;
use App\Services\FcuApiService;
use App\Services\StudentService;
use App\Services\UserService;
use Illuminate\Support\Arr;

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
        $userCode = request('user_code');
        if (!$userCode) {
            return redirect()->route('index')->with('warning', '登入失敗(c)');
        }

        //利用User Code取得學號
        $userInfo = $this->fcuApiService->getUserInfo($userCode);
        //檢查登入結果
        if (!is_array($userInfo) || !isset($userInfo['id']) || empty(trim($userInfo['id']))) {
            return redirect()->route('index')->with('warning', '登入失敗(u)');
        }
        $nid = trim(strtoupper($userInfo['id']));

        //嘗試使用 GetStuInfo 取得 GetUserInfo 無法取得之入學年度與性別資訊
        $stuInfo = $this->fcuApiService->getStuInfo($nid);
        if ($stuInfo) {
            //若順利取得資料
            //僅取用入學年度與性別資訊
            $filteredStuInfo = Arr::only($stuInfo, ['in_year', 'stu_sex']);
            //合併到 userInfo 供後續處理
            $userInfo = array_merge($userInfo, $filteredStuInfo);
        }

        //找出使用者
        $user = $this->userService->findOrCreateByNid($nid);

        //取得學生資料
        $student = $this->studentService->updateOrCreateOfUserInfo($userInfo);
        if ($student) {
            //有學生資料
            //由於使用者與學生之間的關聯使用NID判斷，因此不會發生使用者未綁定學生的情況
            //若學生沒有QR Code
            if (!$student->qrcode) {
                //綁定QRCode
                $student->qrcode()->save(Qrcode::create());
            }
        }
        //更新名稱
        $user->update(['name' => $userInfo['name']]);

        //登入使用者
        auth()->login($user, true);

        return redirect()->intended();
    }
}
