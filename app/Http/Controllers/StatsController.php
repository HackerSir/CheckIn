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

        return view('stats.index', compact('count'));
    }
}
