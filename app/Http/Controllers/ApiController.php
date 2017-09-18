<?php

namespace App\Http\Controllers;

use App\Booth;
use App\Club;
use App\ClubType;
use App\User;
use DB;
use Gravatar;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Searchy;

class ApiController extends Controller
{
    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:club.manage')->only(['userList']);
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
        //總數
        $totalCount = $BoothsQuery->count();
        //分頁
        $page = $request->get('page', 1);
        $perPage = 10;
        $BoothsQuery->limit($perPage)->skip(($page - 1) * $perPage);
        //取得資料
        /** @var \Illuminate\Database\Eloquent\Collection|User[] $booths */
        $booths = $BoothsQuery->get();
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
            'total_count' => $totalCount,
            'items'       => $items,
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
        //總數
        $totalCount = $usersQuery->count();
        //分頁
        $page = $request->get('page', 1);
        $perPage = 10;
        $usersQuery->limit($perPage)->skip(($page - 1) * $perPage);
        //取得資料
        /** @var \Illuminate\Database\Eloquent\Collection|User[] $users */
        $users = $usersQuery->get();
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
            'total_count' => $totalCount,
            'items'       => $items,
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
        $clubQuery = Club::with('clubType', 'imgurImage');
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
        /** @var Club[]|Collection $clubs */
        $clubs = $clubQuery->get();
        //整理資料
        $result = [];
        foreach ($clubs as $club) {
            $result[] = [
                'id'      => $club->id,
                'name'    => $club->name,
                'image'   => $club->imgurImage ? $club->imgurImage->thumbnail('b') : null,
                'tag'     => [
                    'name'  => $club->clubType ? $club->clubType->name : null,
                    'color' => $club->clubType ? $club->clubType->color : null,
                ],
                'excerpt' => str_limit($club->description, 100, '...'),
            ];
        }

        return $result;
    }
}
