<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class EmailConfirm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = auth()->user();
        if (!$user->is_confirmed) {
            //跳轉至重送驗證信頁面
            return redirect()->route('confirm-mail.resend')->with('warning', '尚未完成信箱驗證');
        }

        return $next($request);
    }
}
