<?php

namespace App\Http\Controllers;

use App\User;
use Gravatar;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class ApiController extends Controller
{
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
        /** @var \Illuminate\Database\Eloquent\Collection $users */
        $users = $usersQuery->get();
        //轉換陣列內容
        $items = [];
        foreach ($users as $user) {
            $items[] = [
                'id'       => $user->id,
                'name'     => $user->name,
                'email'    => $user->email,
                'gravatar' => Gravatar::src($user->email, 40),
            ];
        }
        //建立JSON
        $json = [
            'total_count' => $totalCount,
            'items'       => $items,
        ];

        return response()->json($json);
    }
}
