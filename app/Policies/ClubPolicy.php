<?php

namespace App\Policies;

use App\Models\Club;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClubPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param string $ability
     * @return bool
     */
    public function before(User $user, $ability)
    {
        //未登入，禁止所有功能
        if (!$user) {
            return false;
        }
        //若有權限，直接允許使用所有功能
        if ($user->can('club.manage')) {
            return true;
        }

        return null;
    }

    public function asStaff(User $user, Club $club)
    {
        if (!$user->student) {
            return false;
        }

        return $club->students->contains($user->student);
    }

    public function asLeader(User $user, Club $club)
    {
        if (!$user->student) {
            return false;
        }

        return $club->leaders->contains($user->student);
    }
}
