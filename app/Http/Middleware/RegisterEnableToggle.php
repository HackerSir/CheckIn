<?php

namespace App\Http\Middleware;

use Closure;

class RegisterEnableToggle
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
        $allowRegister = env('ALLOW_REGISTER', true);
        if (!$allowRegister) {
            return redirect()->back()->with('warning', '不開放註冊');
        }

        return $next($request);
    }
}
