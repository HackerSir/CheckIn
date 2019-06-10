<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class ContactInformationReady
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

        if (!$user->student || !$user->student->contactInformation) {
            return redirect()->route('contact-information.my.create-or-edit')
                ->with('warning', '您尚未填寫聯絡資料，填寫完成後，方可使用該功能');
        }

        return $next($request);
    }
}
