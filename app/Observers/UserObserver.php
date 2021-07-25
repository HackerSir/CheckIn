<?php

namespace App\Observers;

use App\Models\User;
use Carbon\Carbon;

class UserObserver
{
    /**
     * Handle the user "creating" event.
     *
     * @param \App\User $user
     * @return void
     */
    public function creating(User $user)
    {
        $user->register_at = Carbon::now();
        $user->register_ip = request()->getClientIp();
        $user->last_login_at = Carbon::now();
        $user->last_login_ip = request()->getClientIp();
    }

    /**
     * Handle the user "saving" event.
     *
     * @param User $user
     * @return void
     */
    public function saving(User $user)
    {
        $user->nid = trim(strtoupper($user->nid));
    }
}
