<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * 查看會員資料
     *
     * @return View
     */
    public function getProfile()
    {
        $user = auth()->user();

        return view('profile.index', compact('user'));
    }

    /**
     * 個人資料編輯頁面
     *
     * @return View
     */
    public function getEditProfile()
    {
        $user = auth()->user();

        return view('profile.edit', compact('user'));
    }

    /**
     * 編輯個人資料
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        /* @var User $user */
        $user = auth()->user();
        $user->update([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('profile')->with('success', '資料修改完成。');
    }
}
