<?php

namespace App\Http\Controllers;

use App\Student;

class StatsController extends Controller
{
    public function index()
    {
        $count = [];
        //總人數
        $count['total'] = Student::query()->count();
        //參與人數
        $count['play']['freshman'] = Student::freshman()->has('records')->count();
        $count['play']['non_freshman'] = Student::nonFreshman()->has('records')->count();
        //完成任務人數
        $target = \Setting::get('target');
        $count['finish']['freshman'] = Student::freshman()->has('records', '>=', $target)->count();
        $count['finish']['non_freshman'] = Student::nonFreshman()->has('records', '>=', $target)->count();

        return view('stats.index', compact('count'));
    }
}
