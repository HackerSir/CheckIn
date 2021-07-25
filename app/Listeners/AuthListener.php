<?php

namespace App\Listeners;

use App\Services\LogService;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Events\Dispatcher;

class AuthListener
{
    protected $logService;

    /**
     * Create the event listener.
     * @param LogService $logService
     */
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    /**
     * 註冊監聽器的訂閱者。
     *
     * @param Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\AuthListener@onLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\AuthListener@onLogout'
        );
    }

    /**
     * 使用者登入
     *
     * @param Login $event
     */
    public function onLogin(Login $event)
    {
        /* @var User $user */
        $user = $event->user;
        $ip = request()->getClientIp();
        //更新最後登入時間與IP
        $user->update([
            'last_login_at' => Carbon::now(),
            'last_login_ip' => $ip,
        ]);

        //寫入紀錄
        activity('auth')->by($user)->log(':causer.name (:causer.nid_or_email) 登入');
//        $this->logService->info('[Auth][Login] ' . $user->name . ' (' . $user->email . ')' . PHP_EOL, [
//            'user' => [
//                'id'    => $user->id,
//                'email' => $user->email,
//                'name'  => $user->name,
//            ],
//            'ip'   => $ip,
//        ]);
    }

    /**
     * 使用者登出
     *
     * @param Logout $event
     */
    public function onLogout(Logout $event)
    {
        /* @var User $user */
        $user = $event->user;
        if (!$user) {
            return;
        }
//        $ip = request()->getClientIp();
        //寫入紀錄
        activity('auth')->by($user)->log(':causer.name (:causer.nid_or_email) 登出');
//        $this->logService->info('[Auth][Logout] ' . $user->name . ' (' . $user->email . ')' . PHP_EOL, [
//            'user' => [
//                'id'    => $user->id,
//                'email' => $user->email,
//                'name'  => $user->name,
//            ],
//            'ip'   => $ip,
//        ]);
    }
}
