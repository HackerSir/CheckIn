<?php

namespace App\Policies;

use App\ContactInformation;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactInformationPolicy
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

    /**
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the contact information.
     *
     * @param \App\User $user
     * @param \App\ContactInformation $contactInformation
     * @return bool
     */
    public function view(User $user, ContactInformation $contactInformation)
    {
        return true;
    }

    /**
     * Determine whether the user can create contact information.
     *
     * @param \App\User $user
     * @return bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the contact information.
     *
     * @param \App\User $user
     * @param \App\ContactInformation $contactInformation
     * @return bool
     */
    public function update(User $user, ContactInformation $contactInformation)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the contact information.
     *
     * @param \App\User $user
     * @param \App\ContactInformation $contactInformation
     * @return bool
     */
    public function delete(User $user, ContactInformation $contactInformation)
    {
        return true;
    }
}
