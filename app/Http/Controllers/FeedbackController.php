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
     * FeedbackController constructor.
     */
    public function __construct()
    {
        $this->middleware(['nid_account', 'contact_information_ready'])->only([
            'my',
            'createOrEdit',
            'store',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param FeedbackDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     * @throws \Exception
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
                //跳轉至「我的回饋資料」
                return redirect()->route('feedback.my')->with('warning', '已超過檢視期限，若需查看資料，請聯繫各委會輔導老師');
            }
            $endAt = new Carbon(Setting::get('end_at'));
            if (Carbon::now()->gt($endAt)) {
                //活動結束，確認是否為社長
                if (!$user->club->pivot->is_leader) {
                    return back()->route('feedback.my')->with('warning', '活動已結束，僅社長可查看資料');
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

        return view('feedback.my', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Club $club
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function createOrEdit(Club $club)
    {
        /** @var User $user */
        $user = auth()->user();

        //檢查填寫期限
        $feedbackCreateExpiredAt = new Carbon(Setting::get('feedback_create_expired_at'));
        if (Carbon::now()->gt($feedbackCreateExpiredAt)) {
            return back()->with('warning', '回饋資料填寫已截止');
        }

        //曾給該社團的回饋資料
        $feedback = Feedback::whereClubId($club->id)->whereStudentNid($user->student->nid)->first();

        $intentionOptions = [null => null] + Feedback::$intentionText;

        return view(
            'feedback.create-or-edit',
            compact('user', 'club', 'feedback', 'feedbackCreateExpiredAt', 'intentionOptions')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Club $club
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function store(Request $request, Club $club)
    {
        /** @var User $user */
        $user = auth()->user();

        //檢查填寫期限
        $feedbackCreateExpiredAt = new Carbon(Setting::get('feedback_create_expired_at'));
        if (Carbon::now()->gt($feedbackCreateExpiredAt)) {
            return back()->with('warning', '回饋資料填寫已截止');
        }

        $this->validate($request, [
            'include_phone'             => 'nullable|required_without_all:include_email,include_facebook,include_line',
            'include_email'             => 'nullable|required_without_all:include_phone,include_facebook,include_line',
            'include_facebook'          => 'nullable|required_without_all:include_phone,include_email,include_line',
            'include_line'              => 'nullable|required_without_all:include_phone,include_email,include_facebook',
            'message'                   => 'nullable|max:255',
            'answer_of_custom_question' => 'nullable|max:255',
            'join_club_intention'       => 'required|in:0,1,2',
            'join_tea_party_intention'  => 'required|in:0,1,2',
        ]);

        $feedback = Feedback::updateOrCreate([
            'club_id'     => $club->id,
            'student_nid' => $user->student->nid,
        ], array_merge($request->only(['message', 'join_club_intention', 'join_tea_party_intention']), [
            'include_phone'             => $request->has('include_phone'),
            'include_email'             => $request->has('include_email'),
            'include_facebook'          => $request->has('include_facebook'),
            'include_line'              => $request->has('include_line'),
            'custom_question'           => $club->custom_question,
            'answer_of_custom_question' => $club->custom_question ? $request->get('answer_of_custom_question') : null,
        ]));

        return redirect()->route('feedback.show', $feedback)
            ->with('success', '回饋資料已送出');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Feedback $feedback
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function show(Feedback $feedback)
    {
        //根據權限與身分檢查是否能看到
        if (!\Laratrust::can('feedback.manage')) {
            /** @var User $user */
            $user = auth()->user();
            if (\Gate::denies('as-staff', $feedback->club)
                && (!$user->student || $user->student->nid != $feedback->student_nid)) {
                abort(403);
            }
            //檢查檢視與下載期限
            $feedbackDownloadExpiredAt = new Carbon(Setting::get('feedback_download_expired_at'));
            if (Carbon::now()->gt($feedbackDownloadExpiredAt)) {
                return back()->with('warning', '已超過檢視期限，若需查看資料，請聯繫各委會輔導老師');
            }
            $endAt = new Carbon(Setting::get('end_at'));
            if (Carbon::now()->gt($endAt)) {
                //活動結束
                if (!$user->student) {
                    //若無學生，直接返回
                    return back()->with('warning', '已超過檢視期限，若需查看資料，請聯繫各委會輔導老師');
                }
                //確認是否為社長或資料擁有者
                if (!($user->club && $user->club->pivot->is_leader)
                    && ($user->student->nid != $feedback->student_nid)) {
                    return redirect()->route('feedback.my')->with('warning', '活動已結束，僅社長可查看資料');
                }
            }
        }
        //打卡紀錄
        $record = Record::whereClubId($feedback->club_id)
            ->whereStudentNid($feedback->student_nid)
            ->first();

        return view('feedback.show', compact('feedback', 'record'));
    }
}
