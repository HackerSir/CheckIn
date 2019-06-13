<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class NIDAccount
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();
        if (!$user || !$user->student) {
            return back()->with('warning', '此功能限NID帳號使用');
        }

        return $next($request);
    }
}
