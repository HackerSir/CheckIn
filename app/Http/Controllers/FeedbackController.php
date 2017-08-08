<?php

namespace App\Http\Controllers;

use App\Club;
use App\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODO 若有管理權限，直接顯示全部
        //TODO 若無管理權限，社團負責人看到自己社團的
        //TODO 若無管理權限，學生看自己填過的
        //TODO 顯示
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Club $club
     * @return \Illuminate\Http\Response
     */
    public function create(Club $club)
    {
        //TODO 檢查是否為學生帳號
        //TODO 檢查是否填寫過回饋給該社團
        //TODO 顯示表單
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Feedback $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        //TODO 根據權限與身分檢查是否能看到
    }
}
