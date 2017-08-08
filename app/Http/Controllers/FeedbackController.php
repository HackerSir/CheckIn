<?php

namespace App\Http\Controllers;

use App\Club;
use App\DataTables\FeedbackDataTable;
use App\DataTables\Scopes\FeedbackFilterScope;
use App\Feedback;
use App\Record;
use App\User;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param FeedbackDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(FeedbackDataTable $dataTable)
    {
        //若有管理權限，直接顯示全部
        if (!\Laratrust::can('feedback.manage')) {
            //若無管理權限
            /** @var User $user */
            $user = auth()->user();
            if ($user->club || $user->student) {
                //社團負責人看到自己社團的
                //學生看自己填過的
                $dataTable->addScope(new FeedbackFilterScope($user->club, $user->student));
            } else {
                //沒有權限
                abort(403);
            }
        }

        return $dataTable->render('feedback.index');
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
     * @param Club $club
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Club $club)
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
        //根據權限與身分檢查是否能看到
        if (!\Laratrust::can('feedback.manage')) {
            /** @var User $user */
            $user = auth()->user();
            if (($user->club_id != $feedback->club_id)
                && (!$user->student || $user->student->id != $feedback->student_id)) {
                abort(403);
            }
        }
        //打卡紀錄
        $record = Record::whereClubId($feedback->club_id)
            ->whereStudentId($feedback->student_id)
            ->first();

        return view('feedback.show', compact('feedback', 'record'));
    }
}
