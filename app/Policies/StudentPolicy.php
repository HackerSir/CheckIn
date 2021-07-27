<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;
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
        if (!$user->isAbleTo('student.manage')) {
            return false;
        }

        return null;
    }

    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the student.
     *
     * @param User $user
     * @param Student $student
     * @return mixed
     */
    public function view(User $user, Student $student)
    {
        return true;
    }

    /**
     * Determine whether the user can create students.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the student.
     *
     * @param User $user
     * @param Student $student
     * @return mixed
     */
    public function update(User $user, Student $student)
    {
        return true;
    }

    /**
     * Determine whether the user can fetch the student.
     *
     * @param User $user
     * @param Student $student
     * @return mixed
     */
    public function fetch(User $user, Student $student)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the student.
     *
     * @param User $user
     * @param Student $student
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
