<?php

namespace App\Http\Controllers;

use App\Booth;
use App\Club;
use App\ClubType;
use App\Feedback;
use App\Presenters\ContentPresenter;
use App\User;
use DB;
use Gravatar;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Searchy;

class ApiController extends Controller
{
    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:club.manage')->only([
            'boothList',
            'userList',
        ]);
    }

    public function boothList(Request $request)
    {
        /** @var Builder|Booth $BoothsQuery */
        $BoothsQuery = Booth::query();
        //搜尋關鍵字
        if ($request->has('q')) {
            $searchPattern = '%' . $request->input('q') . '%';
            //搜尋攤位名稱
            $BoothsQuery->where(function ($query) use ($searchPattern) {
                /** @var Builder|Booth $query */
                $query->where('name', 'like', $searchPattern);
            });
        }
        //分頁
        $perPage = 10;
        //取得資料
        /** @var LengthAwarePaginator|Collection|Booth[] $booths */
        $booths = $BoothsQuery->paginate($perPage);
        //轉換陣列內容
        $items = [];
        $clubId = $request->get('club');
        foreach ($booths as $booth) {
            //檢查是否為其他社團之攤位
            if ($booth->club && $booth->club->id != $clubId) {
                $name = $booth->name . '（' . $booth->club->name . '）';
                $disabled = true;
            } else {
                $name = $booth->name;
                $disabled = false;
            }
            $items[] = [
                'id'       => $booth->id,
                'name'     => $name,
                'disabled' => $disabled,
            ];
        }
        //建立JSON
        $json = [
            'current_page' => $booths->currentPage(),
            'last_page'    => $booths->lastPage(),
            'items'        => $items,
        ];

        return response()->json($json);
    }

    public function userList(Request $request)
    {
        /** @var Builder|User $usersQuery */
        $usersQuery = User::query();
        //搜尋關鍵字
        if ($request->has('q')) {
            $searchPattern = '%' . $request->input('q') . '%';
            //搜尋使用者名稱或信箱
            $usersQuery->where(function ($query) use ($searchPattern) {
                /** @var Builder|User $query */
                $query->where('name', 'like', $searchPattern)
                    ->orWhere('email', 'like', $searchPattern);
            });
        }
        //分頁
        $perPage = 10;
        //取得資料
        /** @var LengthAwarePaginator|Collection|User[] $users */
        $users = $usersQuery->paginate($perPage);
        //轉換陣列內容
        $items = [];
        $clubId = $request->get('club');
        foreach ($users as $user) {
            //檢查是否為其他社團之負責人
            if ($user->club && $user->club->id != $clubId) {
                $name = $user->name . '（' . $user->club->name . '）';
                $disabled = true;
            } else {
                $name = $user->name;
                $disabled = false;
            }
            $items[] = [
                'id'       => $user->id,
                'name'     => $name,
                'email'    => $user->email,
                'gravatar' => Gravatar::src($user->email, 40),
                'disabled' => $disabled,
            ];
        }
        //建立JSON
        $json = [
            'current_page' => $users->currentPage(),
            'last_page'    => $users->lastPage(),
            'items'        => $items,
        ];

        return response()->json($json);
    }

    public function clubTypeList()
    {
        $clubTypes = ClubType::query()->orderBy('id')->pluck('name', 'id');

        return $clubTypes;
    }

    public function clubList()
    {
        /** @var Club|\Illuminate\Database\Eloquent\Builder $clubs */
        $clubQuery = Club::with('clubType', 'imgurImage', 'booths');
        //過濾
        /** @var ClubType $clubType */
        $clubType = ClubType::query()->find(request()->get('clubType'));
        if ($clubType) {
            $clubQuery->where('club_type_id', $clubType->id);
        }
        $keyword = request()->get('keyword');
        if ($keyword) {
            //消滅關鍵字中的特殊字元
            $keyword = str_replace(['\\', "\x00", "\n", "\r", "'", '"', "\x1a"], '', $keyword);
            //模糊搜索
            $searchResultIds = Searchy::clubs(['name', 'description'])->query($keyword)->get()->pluck('id')->toArray();
            //過濾
            $clubQuery->whereIn('id', $searchResultIds);
            //根據搜尋結果排序
            if (count($searchResultIds)) {
                $idsOrdered = implode(',', $searchResultIds);
                $clubQuery->orderByRaw(DB::raw("FIELD(id, $idsOrdered)"));
            }
        }

        $clubQuery->orderBy('id');

        //取得社團
        /** @var LengthAwarePaginator|Club[]|Collection $clubs */
        $clubs = $clubQuery->paginate(20);
        //整理資料
        $data = [];
        foreach ($clubs as $club) {
            //取得一個攤位
            /** @var Booth $booth */
            $booth = $club->booths->first();

            $data[] = [
                'id'      => $club->id,
                'name'    => $club->name,
                'image'   => $club->imgurImage ? $club->imgurImage->thumbnail('b') : null,
                'tag'     => [
                    'name'  => $club->clubType ? $club->clubType->name : null,
                    'color' => $club->clubType ? $club->clubType->color : null,
                ],
                'excerpt' => str_limit(strip_tags($club->description), 100, '...'),
                'booth'   => $booth ? [
                    'longitude' => $booth->longitude,
                    'latitude'  => $booth->latitude,
                ] : null,
            ];
        }
        $result = [
            'current_page' => $clubs->currentPage(),
            'last_page'    => $clubs->lastPage(),
            'data'         => $data,
        ];

        return $result;
    }

    public function myFeedbackList()
    {
        /** @var User $user */
        $user = auth()->user();
        $student = $user->student;
        //非會員或無學生資料
        if (!$user || !$student) {
            abort(403);
        }

        $contentPresenter = app(ContentPresenter::class);
        /** @var LengthAwarePaginator|Collection|Feedback[] $feedback */
        $feedback = $student->feedback()->with('club.clubType')->paginate(10);
        $data = [];
        foreach ($feedback as $feedbackItem) {
            $data[] = array_merge(
                array_only(
                    $feedbackItem->toArray(),
                    ['id', 'student_id', 'phone', 'email', 'facebook', 'line', 'message']
                ),
                [
                    'club' => array_merge(
                        array_only($feedbackItem->club->toArray(), ['id', 'name']),
                        [
                            'display_name' => $feedbackItem->club->display_name,
//                            'extra_info'   => $feedbackItem->club->extra_info
//                                ? $contentPresenter->showContent($feedbackItem->club->extra_info) : null,
                            'extra_info'   => $feedbackItem->club->extra_info,
                        ]
                    ),
                ]
            );
        }
        $result = [
            'current_page' => $feedback->currentPage(),
            'last_page'    => $feedback->lastPage(),
            'data'         => $data,
        ];

        return $result;
    }
}
