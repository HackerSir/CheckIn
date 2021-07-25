<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RegisterEnableToggle
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $allowRegister = config('app.allow_register');
        if (!$allowRegister) {
            return redirect()->back()->with('warning', '不開放註冊');
        }

        return $next($request);
    }
}
