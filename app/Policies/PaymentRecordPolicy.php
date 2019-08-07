<?php

namespace App\Policies;

use App\PaymentRecord;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentRecordPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param $ability
     * @return bool|null
     */
    public function before(User $user, $ability)
    {
        //若有權限，直接允許使用所有功能
        if ($user->can('payment-record.manage')) {
            return true;
        }
        //無社團
        if (!$user->club) {
            return false;
        }

        return null;
    }

    public function index(User $user)
    {
        return $user->club != null;
    }

    /**
     * Determine whether the user can view the payment record.
     *
     * @param \App\User $user
     * @param \App\PaymentRecord $paymentRecord
     * @return mixed
     */
    public function view(User $user, PaymentRecord $paymentRecord)
    {
        return $user->club->id == $paymentRecord->club_id;
    }

    /**
     * Determine whether the user can create payment records.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the payment record.
     *
     * @param \App\User $user
     * @param \App\PaymentRecord $paymentRecord
     * @return mixed
     */
    public function update(User $user, PaymentRecord $paymentRecord)
    {
        return $user->club->id == $paymentRecord->club_id;
    }

    /**
     * Determine whether the user can delete the payment record.
     *
     * @param \App\User $user
     * @param \App\PaymentRecord $paymentRecord
     * @return mixed
     */
    public function delete(User $user, PaymentRecord $paymentRecord)
    {
        return $user->club->id == $paymentRecord->club_id;
    }
}
