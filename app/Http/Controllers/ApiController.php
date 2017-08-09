<?php

namespace App\Http\Controllers;

use App\Club;
use App\User;
use Gravatar;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:club.manage')->only(['userList']);
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

    public function clubList()
    {
        /** @var Club[]|Collection $clubs */
        $clubs = Club::all();
        $result = [];

        foreach ($clubs as $club) {
            $result[] = [
                'id'      => $club->id,
                'name'    => $club->name,
                'tag'     => [
                    'name'  => $club->clubType->name ?? '',
                    'color' => $club->clubType->color ?? '',
                ],
                'excerpt' => str_limit($club->description, 100, '...'),
            ];
        }

        return $result;
    }
}
