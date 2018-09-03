<?php

namespace App\Services;

use App\Student;
use App\User;
use Carbon\Carbon;

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
        $email = $nid . '@fcu.edu.tw';
        /** @var User $user */
        $user = User::query()->firstOrCreate([
            'email' => $email,
        ], [
            'name'        => $nid,
            'password'    => '',
            'confirm_at'  => Carbon::now(),
            'register_at' => Carbon::now(),
            'register_ip' => request()->getClientIp(),
        ]);

        return $user;
    }
}
