<?php

namespace App\Http\Controllers;

use App\Student;

class StatsController extends Controller
{
    public function index()
    {
        $count = [];
        //總人數
        $count['total']['freshman'] = Student::freshman()->count();
        $count['total']['non_freshman'] = Student::nonFreshman()->count();
        $count['total']['total'] = $count['total']['freshman'] + $count['total']['non_freshman'];
        //參與人數
        $count['play']['freshman'] = Student::freshman()->has('records')->count();
        $count['play']['non_freshman'] = Student::nonFreshman()->has('records')->count();
        $count['play']['total'] = $count['play']['freshman'] + $count['play']['non_freshman'];
        //完成任務人數
        $target = \Setting::get('target');
        $count['finish']['freshman'] = Student::freshman()->has('records', '>=', $target)->count();
        $count['finish']['non_freshman'] = Student::nonFreshman()->has('records', '>=', $target)->count();
        $count['finish']['total'] = $count['finish']['freshman'] + $count['finish']['non_freshman'];
        //比例
        $data = [];
        foreach (['新生' => 'freshman', '非新生' => 'non_freshman', '全部' => 'total'] as $key => $type) {
            $data[$type] = [
                'name'                => $key,
                'total'               => $count['total'][$type],
                'play'                => $count['play'][$type],
                'finish'              => $count['finish'][$type],
                'play_percent'        => $count['total'][$type] > 0
                    ? round($count['play'][$type] / $count['total'][$type] * 100, 2) : 0,
                'finish_percent'      => $count['total'][$type] > 0
                    ? round($count['finish'][$type] / $count['total'][$type] * 100, 2) : 0,
                'finish_play_percent' => $count['play'][$type] > 0
                    ? round($count['finish'][$type] / $count['play'][$type] * 100, 2) : 0,
            ];
        }

        return view('stats.index', compact('data'));
    }
}
