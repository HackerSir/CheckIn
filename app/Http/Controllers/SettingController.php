<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('setting.edit');
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'start_at'                     => 'required|date|before:end_at',
            'end_at'                       => 'required|date|after:start_at',
            'target'                       => 'required|integer|min:0',
            'feedback_create_expired_at'   => 'required|date',
            'feedback_download_expired_at' => 'required|date',
            'club_edit_deadline'           => 'required|date',
        ]);

        \Setting::set('start_at', $request->get('start_at'));
        \Setting::set('end_at', $request->get('end_at'));
        \Setting::set('target', $request->get('target'));
        \Setting::set('feedback_create_expired_at', $request->get('feedback_create_expired_at'));
        \Setting::set('feedback_download_expired_at', $request->get('feedback_download_expired_at'));
        \Setting::set('club_edit_deadline', $request->get('club_edit_deadline'));

        \Setting::save();

        return redirect()->route('setting.edit')->with('global', '設定已更新');
    }
}
