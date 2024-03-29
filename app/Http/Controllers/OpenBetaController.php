<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\User;

class OpenBetaController extends Controller
{
    /**
     * OpenBetaController constructor.
     */
    public function __construct()
    {
        $this->middleware('nid_account');
    }

    public function promoteToStaff(Club $club)
    {
        $openBeta = config('app.open_beta');
        if (!$openBeta) {
            return back()->with('error', '此功能限測試期間使用');
        }
        /** @var User $user */
        $user = auth()->user();
        $student = $user->student;
        //檢查是否已是該社團工作人員
        /** @var Club $originalClub */
        $originalClub = $student->clubs()->first();
        if ($originalClub && $originalClub->id == $club->id) {
            return back()->with('warning', '原本就是 ' . $club->name . ' 的工作人員囉');
        }
        //若已有社團，先清空
        if ($student->clubs()->count() > 0) {
            $student->clubs()->sync([]);
        }
        $student->clubs()->sync([$club->id]);

        activity('open-beta')->by($user)->on($club)->log('成為了 ' . $club->name . ' 的工作人員');

        return back()->with('success', '已成為 ' . $club->name . ' 的工作人員');
    }
}
