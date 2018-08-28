<?php

namespace App\Http\Controllers;

use App\Club;
use App\DataTables\FeedbackDataTable;
use App\DataTables\Scopes\FeedbackFilterScope;
use App\Feedback;
use App\Record;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Setting;

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
        $feedbackQuery = Feedback::query();
        $recordQuery = Record::query();
        /** @var User $user */
        $user = auth()->user();
        //無管理權限，無社團
        if (!\Laratrust::can('feedback.manage') && !$user->club) {
            if ($user->student) {
                //有學生帳號，直接跳轉至「我的回饋資料」
                return redirect()->route('feedback.my');
            } else {
                //無學生帳號
                abort(403);
            }
        }
        //無管理權限，僅有社團
        if (!\Laratrust::can('feedback.manage')) {
            //檢查檢視與下載期限
            $feedbackDownloadExpiredAt = new Carbon(Setting::get('feedback_download_expired_at'));
            if (Carbon::now()->gt($feedbackDownloadExpiredAt)) {
                if ($user->student) {
                    //若有學生，跳轉至「我的回饋資料」
                    return redirect()->route('feedback.my')->with('warning', '已超過檢視期限，若需查看資料，請聯繫各委會輔導老師');
                } else {
                    //若無學生，直接返回
                    return back()->with('warning', '已超過檢視期限，若需查看資料，請聯繫各委會輔導老師');
                }
            }
            //只能看到自己社團的
            $dataTable->addScope(new FeedbackFilterScope($user->club, null));
            //社團統計資料
            $feedbackQuery->where('club_id', $user->club->id);
            $recordQuery->where('club_id', $user->club->id);
        }
        $feedbackCount = $feedbackQuery->count();
        $recordCount = $recordQuery->count();
        $countProportion = $recordCount > 0 ? round($feedbackCount / $recordCount * 100, 2) : 0;

        return $dataTable->render('feedback.index', compact('user', 'feedbackCount', 'recordCount', 'countProportion'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function my()
    {
        /** @var User $user */
        $user = auth()->user();
        //檢查是否為學生帳號
        if (!$user->student) {
            return back()->with('warning', '此功能限學生帳號使用');
        }

        return view('feedback.my', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Club $club
     * @return \Illuminate\Http\Response
     */
    public function create(Club $club)
    {
        /** @var User $user */
        $user = auth()->user();
        //檢查是否為學生帳號
        if (!$user->student) {
            return back()->with('warning', '此功能限學生帳號使用');
        }

        //檢查是否填寫過回饋給該社團
        $feedback = Feedback::whereClubId($club->id)->whereStudentId($user->student->id)->first();
        if ($feedback) {
            return redirect()->route('feedback.show', $feedback)
                ->with('warning', '已填寫過給該社團的回饋資料');
        }

        //檢查填寫期限
        $feedbackCreateExpiredAt = new Carbon(Setting::get('feedback_create_expired_at'));
        if (Carbon::now()->gt($feedbackCreateExpiredAt)) {
            return back()->with('warning', '回饋資料填寫已截止');
        }

        $lastFeedback = $user->student->feedback()->orderBy('created_at', 'desc')->first();

        return view('feedback.create', compact('user', 'club', 'lastFeedback'));
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
        /** @var User $user */
        $user = auth()->user();
        //檢查是否為學生帳號
        if (!$user->student) {
            return back()->with('warning', '此功能限學生帳號使用');
        }

        //檢查是否填寫過回饋給該社團
        $existFeedback = Feedback::whereClubId($club->id)->whereStudentId($user->student->id)->first();
        if ($existFeedback) {
            return redirect()->route('feedback.show', $existFeedback)
                ->with('warning', '已填寫過給該社團的回饋資料');
        }

        //檢查填寫期限
        $feedbackCreateExpiredAt = new Carbon(Setting::get('feedback_create_expired_at'));
        if (Carbon::now()->gt($feedbackCreateExpiredAt)) {
            return back()->with('warning', '回饋資料填寫已截止');
        }

        $this->validate($request, [
            'phone'   => [
                'nullable',
                'required_without_all:email,message',
                'max:255',
                'regex:/^[\d-+()#\s]+$/',
            ],
            'email'   => 'nullable|required_without_all:phone,message|max:255|email',
            'message' => 'nullable|required_without_all:email,phone|max:255',
        ]);

        $feedback = Feedback::create(array_merge($request->only(['phone', 'email', 'message']), [
            'club_id'    => $club->id,
            'student_id' => $user->student->id,
        ]));

        return redirect()->route('feedback.show', $feedback)
            ->with('warning', '回饋資料已送出');
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
            //檢查檢視與下載期限
            $feedbackDownloadExpiredAt = new Carbon(Setting::get('feedback_download_expired_at'));
            if (Carbon::now()->gt($feedbackDownloadExpiredAt)) {
                return back()->with('warning', '已超過檢視期限，若需查看資料，請聯繫各委會輔導老師');
            }
        }
        //打卡紀錄
        $record = Record::whereClubId($feedback->club_id)
            ->whereStudentId($feedback->student_id)
            ->first();

        return view('feedback.show', compact('feedback', 'record'));
    }
}
