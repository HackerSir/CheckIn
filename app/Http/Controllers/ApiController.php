<?php

namespace App\Http\Controllers;

use App\Booth;
use App\Club;
use App\ClubType;
use App\Feedback;
use App\Student;
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
            'clubStudentList',
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
                $disabled = true;
                $otherClub = $booth->club->name;
            } else {
                $disabled = false;
                $otherClub = null;
            }
            $items[] = [
                'id'       => $booth->id,
                'name'     => $booth->name,
                'disabled' => $disabled,
                'club'     => $otherClub,
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
            /** @var Club $club */
            $club = $user->club;
            if ($club && $club->id != $clubId) {
                $disabled = true;
                $otherClub = $club->name;
            } else {
                $disabled = false;
                $otherClub = null;
            }
            $items[] = [
                'id'       => $user->id,
                'name'     => $user->name,
                'email'    => $user->email,
                'gravatar' => Gravatar::src($user->email, 40),
                'disabled' => $disabled,
                'club'     => $otherClub,
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

    public function clubStudentList(Request $request)
    {
        /** @var Builder|Student $studentsQuery */
        $studentsQuery = Student::with('clubs');
        //搜尋關鍵字
        if ($request->has('q')) {
            $searchPattern = '%' . $request->input('q') . '%';
            //搜尋學生名稱或NID
            $studentsQuery->where(function ($query) use ($searchPattern) {
                /** @var Builder|Student $query */
                $query->where('name', 'like', $searchPattern)
                    ->orWhere('nid', 'like', $searchPattern);
            });
        }
        //分頁
        $perPage = 10;
        //取得資料
        /** @var LengthAwarePaginator|Collection|Student[] $students */
        $students = $studentsQuery->paginate($perPage);
        //轉換陣列內容
        $items = [];
        $clubId = $request->get('club');
        foreach ($students as $student) {
            //檢查是否為其他社團之負責人
            /** @var Club $club */
            $club = $student->clubs->first();
            if ($club && $club->id != $clubId) {
                $disabled = true;
                $otherClub = $club->name;
            } else {
                $disabled = false;
                $otherClub = null;
            }
            $items[] = [
                'id'       => $student->nid,
                'name'     => $student->name,
                'disabled' => $disabled,
                'club'     => $otherClub,
            ];
        }
        //建立JSON
        $json = [
            'current_page' => $students->currentPage(),
            'last_page'    => $students->lastPage(),
            'items'        => $items,
        ];

        return response()->json($json);
    }

    public function studentList(Request $request)
    {
        /** @var Builder|Student $studentsQuery */
        $studentsQuery = Student::with('clubs');
        //搜尋關鍵字
        if ($request->has('q')) {
            $searchPattern = '%' . $request->input('q') . '%';
            //搜尋學生名稱或NID
            $studentsQuery->where(function ($query) use ($searchPattern) {
                /** @var Builder|Student $query */
                $query->where('name', 'like', $searchPattern)
                    ->orWhere('nid', 'like', $searchPattern);
            });
        }
        //分頁
        $perPage = 10;
        //取得資料
        /** @var LengthAwarePaginator|Collection|Student[] $students */
        $students = $studentsQuery->paginate($perPage);
        //轉換陣列內容
        $items = [];
        foreach ($students as $student) {
            $items[] = [
                'id'       => $student->nid,
                'name'     => $student->name,
                'disabled' => false,
            ];
        }
        //建立JSON
        $json = [
            'current_page' => $students->currentPage(),
            'last_page'    => $students->lastPage(),
            'items'        => $items,
        ];

        return response()->json($json);
    }

    public function clubTypeList()
    {
        $clubTypes = ClubType::orderBy('id')->pluck('name', 'id');

        return $clubTypes;
    }

    public function clubList()
    {
        /** @var User $user */
        $user = auth()->user();
        /** @var Club|\Illuminate\Database\Eloquent\Builder $clubs */
        if ($user && request()->exists('favorite')) {
            $clubQuery = $user->favoriteClubs();
        } else {
            $clubQuery = Club::with('clubType', 'imgurImage', 'booths');
        }

        //過濾
        /** @var ClubType $clubType */
        $clubType = ClubType::find(request()->get('clubType'));
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

        //使用者收藏社團
        $userFavoriteClubIds = $user ? $user->favoriteClubs()->pluck('id') : collect();

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
                'id'         => $club->id,
                'name'       => $club->name,
                'image'      => $club->imgurImage ? $club->imgurImage->thumbnail('b') : null,
                'tag'        => [
                    'name'  => $club->clubType ? $club->clubType->name : null,
                    'color' => $club->clubType ? $club->clubType->color : null,
                ],
                'excerpt'    => str_limit(strip_tags($club->description), 100, '...'),
                'booth'      => $booth ? [
                    'longitude' => $booth->longitude,
                    'latitude'  => $booth->latitude,
                ] : null,
                'isFavorite' => $userFavoriteClubIds->contains($club->id),
            ];
        }
        $result = [
            'current_page' => $clubs->currentPage(),
            'last_page'    => $clubs->lastPage(),
            'data'         => $data,
        ];

        return $result;
    }

    public function myFavoriteClubIds()
    {
        /** @var User $user */
        $user = auth()->user();
        //非會員
        if (!$user) {
            return response()->json([]);
        }

        return response()->json($user->favoriteClubs()->pluck('id')->toArray());
    }

    public function myFeedbackList()
    {
        /** @var User $user */
        $user = auth()->user();
        //非會員或無學生資料
        if (!$user || !$user->student) {
            abort(403);
        }
        $student = $user->student;

//        $contentPresenter = app(ContentPresenter::class);
        /** @var LengthAwarePaginator|Collection|Feedback[] $feedback */
        $feedback = $student->feedback()->with('club.clubType')->paginate(10);
        $data = [];
        foreach ($feedback as $feedbackItem) {
            $data[] = array_merge(
                array_only(
                    $feedbackItem->toArray(),
                    [
                        'id',
                        'student_nid',
                        'message',
                        'phone',
                        'email',
                        'facebook',
                        'line',
                        'custom_question',
                        'answer_of_custom_question',
                    ]
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

    public function storeFeedback(Request $request, Club $club)
    {
        /** @var User $user */
        $user = auth()->user();
        //非會員或無學生資料
        if (!$user || !$user->student) {
            abort(403);
        }
        $student = $user->student;

        try {
            Feedback::updateOrCreate([
                'student_nid' => $student->nid,
                'club_id'     => $club->id,
            ], [
                'join_club_intention'      => $request->get('join_club_intention'),
                'join_tea_party_intention' => $request->get('join_tea_party_intention'),
            ]);
        } catch (\Exception $exception) {
            return ['success' => false];
        }

        return ['success' => true];
    }

    public function myRecordList()
    {
        /** @var User $user */
        $user = auth()->user();
        //非會員或無學生資料
        if (!$user || !$user->student) {
            abort(403);
        }
        //學生資料
        $student = $user->student;
        $student->load('records.club:id,name,club_type_id', 'records.club.clubType');
        //相關的回饋資料
        $feedback = Feedback::where('student_nid', $student->nid)->select('id', 'club_id')->get()->keyBy('club_id');

        $data = [];
        foreach ($student->records as $record) {
            $data[] = [
                'club_id'       => $record->club->id,
                'club'          => $record->club->name,
                'club_type_tag' => $record->club->clubType->tag ?? null,
                'is_counted'    => $record->club->is_counted,
                'created_at'    => $record->created_at,
                'feedback_id'   => $feedback->has($record->club->id) ? $feedback->get($record->club->id)->id : null,
            ];
        }

        return $data;
    }

    public function addFavoriteClub(Club $club)
    {
        /** @var User $user */
        $user = auth()->user();
        //非會員
        if (!$user) {
            abort(403);
        }

        $user->addFavoriteClub($club);

        return response()->json([
            'success' => true,
            'club_id' => $club->id,
        ]);
    }

    public function removeFavoriteClub(Club $club)
    {
        /** @var User $user */
        $user = auth()->user();
        //非會員
        if (!$user) {
            abort(403);
        }

        $user->removeFavoriteClub($club);

        return response()->json([
            'success' => true,
            'club_id' => $club->id,
        ]);
    }
}
