<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class TermMiddleware
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
        $user = auth()->user();
        if ($user && !$user->agree_terms_at) {
            //登入，但未同意服務條款
            if (!in_array($request->route()->getName(), ['terms', 'terms.agree', 'logout'])) {
                // 若非服務條款相關頁面或登出，直接跳轉至該頁面
                return redirect()->route('terms');
            }
        }

        return $next($request);
    }
}
