<?php

namespace App\Http\Controllers;

use App\ClubSurvey;
use App\StudentSurvey;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Setting;

class SurveyController extends Controller
{
    /**
     * 主要頁面，可選擇瀏覽或填寫各類型問卷
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        $endAt = new Carbon(Setting::get('end_at'));
        $feedbackCreateExpiredAt = new Carbon(Setting::get('feedback_create_expired_at'));

        return view('survey.index', compact('user', 'endAt', 'feedbackCreateExpiredAt'));
    }

    /**
     * 建立或編輯學生問卷
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function createOrEditStudentSurvey()
    {
        /** @var User $user */
        $user = auth()->user();
        if (!$user->student) {
            return redirect()->route('survey.index')->with('warning', '無法填寫此類型問卷');
        }
        $endAt = new Carbon(\Setting::get('end_at'));
        if (Carbon::now()->gt($endAt)) {
            return redirect()->back()->with('warning', '已超過填寫時間');
        }
        if (!$user->student->has_enough_counted_records) {
            return redirect()->route('index')->with('warning', '請先完成打卡集點');
        }
        $studentSurvey = $user->student->studentSurvey;

        return view('survey.student-edit', compact('user', 'studentSurvey'));
    }

    /**
     * 儲存學生問卷
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function storeStudentSurvey(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        if (!$user->student) {
            return redirect()->route('survey.index')->with('warning', '無法填寫此類型問卷');
        }
        $endAt = new Carbon(\Setting::get('end_at'));
        if (Carbon::now()->gt($endAt)) {
            return redirect()->route('survey.index')->with('warning', '已超過填寫時間');
        }
        if (!$user->student->has_enough_counted_records) {
            return redirect()->route('index')->with('warning', '請先完成打卡集點');
        }

        $this->validate($request, [
            'rating' => 'required|integer|min:1|max:5',
        ]);

        StudentSurvey::updateOrCreate([
            'student_id' => $user->student->id,
        ], $request->all());

        return redirect()->route('survey.student.show')->with('success', '問卷內容已更新');
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

    /**
     * 建立或編輯社團問卷
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function createOrEditClubSurvey()
    {
        /** @var User $user */
        $user = auth()->user();
        if (!$user->club) {
            return redirect()->route('survey.index')->with('warning', '無法填寫此類型問卷');
        }
        $endAt = new Carbon(\Setting::get('feedback_create_expired_at'));
        if (Carbon::now()->gt($endAt)) {
            return redirect()->back()->with('warning', '已超過填寫時間');
        }
        $clubSurvey = $user->clubSurvey;

        return view('survey.club-edit', compact('user', 'clubSurvey'));
    }

    /**
     * 儲存學生問卷
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function storeClubSurvey(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        if (!$user->club) {
            return redirect()->route('survey.index')->with('warning', '無法填寫此類型問卷');
        }
        $endAt = new Carbon(\Setting::get('feedback_create_expired_at'));
        if (Carbon::now()->gt($endAt)) {
            return redirect()->route('survey.index')->with('warning', '已超過填寫時間');
        }

        $this->validate($request, [
            'rating' => 'required|integer|min:1|max:5',
        ]);

        ClubSurvey::updateOrCreate([
            'user_id' => $user->id,
            'club_id' => $user->club->id,
        ], $request->all());

        return redirect()->route('survey.club.show')->with('success', '問卷內容已更新');
    }

    /**
     * 檢視學生問卷
     *
     * @return \Illuminate\Http\Response
     */
    public function showClubSurvey()
    {
        /** @var User $user */
        $user = auth()->user();
        if (!$user->club) {
            return redirect()->route('survey.index')->with('warning', '無法填寫此類型問卷');
        }
        $clubSurvey = $user->clubSurvey;
        //未填寫問卷
        if (!$clubSurvey) {
            return redirect()->route('survey.club.edit');
        }

        return view('survey.club-show', compact('clubSurvey'));
    }
}
