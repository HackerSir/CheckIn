<?php

namespace App\Http\Controllers;

use App\Http\Requests\MyContactInformationRequest;
use App\User;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function createOrEdit()
    {
        /** @var User $user */
        $user = auth()->user();

        $contactInformation = $user->student->contactInformation;

        return view('contact-information.my.edit', compact('contactInformation'));
    }

    /**
     * @param Request $request
     * @return  \Illuminate\Http\Response
     */
    public function store(MyContactInformationRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $user->student->contactInformation()->updateOrCreate([], $request->except('student_nid'));

        return redirect()->route('contact-information.my.index')->with('success', '聯絡資料已更新');
    }
}
