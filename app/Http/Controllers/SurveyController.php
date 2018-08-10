<?php

namespace App\Http\Controllers;

use App\StudentSurvey;
use App\User;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * 主要頁面，可選擇瀏覽或填寫各類型問卷
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        return view('survey.index', compact('user'));
    }

    /**
     * 建立或編輯學生問卷
     *
     * @return \Illuminate\Http\Response
     */
    public function createOrEditStudentSurvey()
    {
        /** @var User $user */
        $user = auth()->user();
        if (!$user->student) {
            return redirect()->route('survey.index')->with('warning', '無法填寫此類型問卷');
        }
        if (!$user->student->has_enough_counted_records) {
            return redirect()->route('index')->with('warning', '請先完成集點任務');
        }
        $studentSurvey = $user->student->studentSurvey;

        return view('survey.student-edit', compact('user', 'studentSurvey'));
    }

    /**
     * 儲存學生問卷
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeStudentSurvey(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        if (!$user->student) {
            return redirect()->route('survey.index')->with('warning', '無法填寫此類型問卷');
        }
        if (!$user->student->has_enough_counted_records) {
            return redirect()->route('index')->with('warning', '請先完成集點任務');
        }

        $this->validate($request, [
            'rating' => 'required|integer|min:1|max:5',
        ]);

        StudentSurvey::updateOrCreate([
            'student_id' => $user->student->id,
        ], $request->all());

        return redirect()->route('survey.student.show')->with('global', '問卷內容已更新');
    }

    /**
     * 檢視學生問卷
     *
     * @return \Illuminate\Http\Response
     */
    public function showStudentSurvey()
    {
        /** @var User $user */
        $user = auth()->user();
        if (!$user->student) {
            return redirect()->route('survey.index')->with('warning', '無法填寫此類型問卷');
        }
        $studentSurvey = $user->student->studentSurvey;
        //未填寫問卷
        if (!$studentSurvey) {
            return redirect()->route('survey.student.edit');
        }

        return view('survey.student-show', compact('studentSurvey'));
    }
}
