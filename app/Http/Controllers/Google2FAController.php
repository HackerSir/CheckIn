<?php

namespace App\Http\Controllers;

use App\Support\Google2FAAuthenticator;
use App\User;
use Illuminate\Http\Request;

class Google2FAController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        if (!$user->google2fa_secret) {
            $google2fa = app('pragmarx.google2fa');
            //產生隨機SecretKey，暫存60分鐘
            $secretKey = \Cache::remember('2faSecretKey' . $user->id, 60, function () use ($google2fa) {
                $secretKey = $google2fa->generateSecretKey();

                return $secretKey;
            });
            session(['2faSecretKey' => $secretKey]);

            $google2faQRCodeUrl = $google2fa->getQRCodeGoogleUrl(
                'CheckIn2017',
                $user->email,
                $secretKey
            );

            view()->share(compact('google2faQRCodeUrl'));
        }

        return view('profile.2fa.index', compact('user'));
    }

    public function toggle(Request $request)
    {
        $this->validate($request, [
            'one_time_password' => 'required',
        ]);

        /** @var User $user */
        $user = auth()->user();

        //強制登出OTP
        (new Google2FAAuthenticator($request, $user))->logout();

        $toggleOn = $request->exists('toggle');

        if ($toggleOn) {
            //啟用
            $user->google2fa_secret = session('2faSecretKey');
        }

        //檢查OTP
        $valid = (new Google2FAAuthenticator($request, $user))->isAuthenticated();
        if (!$valid) {
            return back()->withErrors(['one_time_password' => '驗證碼無效']);
        }

        \Cache::forget('2faSecretKey' . $user->id);
        session(['2faSecretKey' => null]);

        //更新資料
        if ($toggleOn) {
            //啟用
            $user->save();

            return redirect()->route('profile')->with('global', '已啟用兩步驟驗證');
        } else {
            //停用
            $user->google2fa_secret = null;
            $user->save();

            return redirect()->route('profile')->with('global', '已停用兩步驟驗證');
        }
    }
}
