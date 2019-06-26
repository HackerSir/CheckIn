<?php

namespace App\Policies;

use App\Feedback;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;
use Setting;

class FeedbackPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the feedback.
     *
     * @param \App\User $user
     * @param \App\Feedback $feedback
     * @return mixed
     * @throws \Exception
     */
    public function view(User $user, Feedback $feedback)
    {
        /** @var User $user */
        $user = auth()->user();
        //擁有者
        $isOwner = $user->student && $user->student->nid == $feedback->student_nid;
        //有管理權限，或是擁有者
        if (\Laratrust::can('feedback.manage') || $isOwner) {
            return true;
        }
        //對於加入社團或參與茶會皆無意願
        if (!$feedback->join_club_intention && !$feedback->join_tea_party_intention) {
            return false;
        }
        //非工作人員
        if (\Gate::denies('as-staff', $feedback->club)) {
            return false;
        }
        //檢查檢視與下載期限
        $feedbackDownloadExpiredAt = new Carbon(Setting::get('feedback_download_expired_at'));
        if (Carbon::now()->gt($feedbackDownloadExpiredAt)) {
            return false;
        }
        $endAt = new Carbon(Setting::get('end_at'));
        if (Carbon::now()->gt($endAt)) {
            //活動結束（到檢視與下載期限前），限社長檢視
            $isLeader = $user->student && $user->club && $user->club->pivot->is_leader;
            if (!$isLeader) {
                return false;
            }
        }

        return true;
    }
}
