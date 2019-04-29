<?php

namespace App\Policies;

use App\Student;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param string $ability
     * @return bool
     */
    public function before(User $user, $ability)
    {
        //若無權限，直接阻止使用所有功能
        if (!$user->can('student.manage')) {
            return false;
        }

        return null;
    }

    public function index(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the student.
     *
     * @param  \App\User $user
     * @param  \App\Student $student
     * @return mixed
     */
    public function view(User $user, Student $student)
    {
        return true;
    }

    /**
     * Determine whether the user can create students.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the student.
     *
     * @param  \App\User $user
     * @param  \App\Student $student
     * @return mixed
     */
    public function update(User $user, Student $student)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the student.
     *
     * @param  \App\User $user
     * @param  \App\Student $student
     * @return mixed
     */
    public function delete(User $user, Student $student)
    {
        //僅限於操作虛構資料
        return $student->is_dummy;
    }

    public function import(User $user)
    {
        return true;
    }
}
