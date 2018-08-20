<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Hash;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /**
     * PasswordController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 密碼修改頁面
     *
     * @return \Illuminate\View\View
     */
    public function getChangePassword()
    {
        $user = auth()->user();

        return view('auth.passwords.change-password', compact('user'));
    }

    /**
     * 修改密碼
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function putChangePassword(Request $request)
    {
        /* @var User $user */
        $user = auth()->user();
        //檢查原密碼
        if (!Hash::check($request->input('password'), $user->getAuthPassword())) {
            return redirect()->route('password.change')->withErrors(['password' => '輸入有誤，請重新輸入。']);
        }
        //檢查新密碼
        $this->validate($request, [
            'new_password' => 'required|confirmed|min:6',
        ]);
        //更新密碼
        $user->update([
            'password' => bcrypt($request->input('new_password')),
        ]);

        return redirect()->route('profile')->with('success', '密碼修改完成。');
    }
}
