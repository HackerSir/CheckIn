<?php

namespace App\Services;

use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserService
{
    /**
     * 尋找使用者，若找不到，則建立使用者並綁定
     *
     * @param Student $student
     * @return User
     */
    public function findOrCreateAndBind(Student $student)
    {
        $user = $student->user;
        if (!$user) {
            $user = $this->findOrCreateByNid($student->nid);
            $user->student()->save($student);
        }

        return $user;
    }

    /**
     * @param string $nid
     * @return User
     */
    public function findOrCreateByNid($nid)
    {
        $nid = trim(Str::upper($nid));
        /** @var User $user */
        $user = User::firstOrCreate([
            'nid' => $nid,
        ], [
            'name'        => $nid,
            'email'       => $nid . '@fcu.edu.tw',
            'password'    => '',
            'confirm_at'  => Carbon::now(),
            'register_at' => Carbon::now(),
            'register_ip' => request()->getClientIp(),
        ]);

        return $user;
    }
}
