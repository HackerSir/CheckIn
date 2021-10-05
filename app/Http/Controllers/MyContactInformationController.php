<?php

namespace App\Http\Controllers;

use App\Http\Requests\MyContactInformationRequest;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Setting;

class MyContactInformationController extends Controller
{
    /**
     * MyContactInformationController constructor.
     */
    public function __construct()
    {
        $this->middleware('nid_account');
    }

    /**
     * @return Response
     */
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        //若未填寫，跳轉至編輯頁面
        if (!$user->student->contactInformation) {
            return redirect()->route('contact-information.my.create-or-edit');
        }

        $contactInformation = $user->student->contactInformation;

        return view('contact-information.my.show', compact('contactInformation'));
    }

    /**
     * @return Response
     *
     * @throws Exception
     */
    public function createOrEdit()
    {
        //檢查填寫期限
        $feedbackCreateExpiredAt = new Carbon(Setting::get('feedback_create_expired_at'));
        if (Carbon::now()->gt($feedbackCreateExpiredAt)) {
            return back()->with('warning', '回饋資料填寫已截止，無法對聯絡資料進行修改');
        }

        /** @var User $user */
        $user = auth()->user();

        $contactInformation = $user->student->contactInformation;

        return view('contact-information.my.edit', compact('contactInformation'));
    }

    /**
     * @param  MyContactInformationRequest  $request
     * @return Response
     *
     * @throws Exception
     */
    public function store(MyContactInformationRequest $request)
    {
        //檢查填寫期限
        $feedbackCreateExpiredAt = new Carbon(Setting::get('feedback_create_expired_at'));
        if (Carbon::now()->gt($feedbackCreateExpiredAt)) {
            return back()->with('warning', '回饋資料填寫已截止，無法對聯絡資料進行修改');
        }

        /** @var User $user */
        $user = auth()->user();

        $user->student->contactInformation()->updateOrCreate([], $request->except('student_nid'));

        return redirect()->route('contact-information.my.index')->with('success', '聯絡資料已更新');
    }
}
