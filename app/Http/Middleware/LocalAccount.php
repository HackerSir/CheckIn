<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class LocalAccount
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
        $user = $request->user();
        if (!$user || !$user->is_local_account) {
            return back()->with('warning', '您無法使用此功能');
        }

        return $next($request);
    }
}
