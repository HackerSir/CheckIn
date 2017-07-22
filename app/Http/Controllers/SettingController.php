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
            'start_at' => 'required|date',
            'end_at'   => 'required|date',
        ]);

        \Setting::set('start_at', $request->get('start_at'));
        \Setting::set('end_at', $request->get('end_at'));

        \Setting::save();

        return redirect()->route('setting.edit')->with('global', '設定已更新');
    }
}
