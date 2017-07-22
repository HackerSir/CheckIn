<?php

namespace App\Http\Middleware;

use Closure;
use Laratrust;
use Menu;

class LaravelMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //左側
        Menu::make('left', function ($menu) {
            /* @var \Lavary\Menu\Builder $menu */
            //$menu->add('Home', ['route' => 'index']);
            //$menu->add('About', 'javascript:void(0)');
            //$menu->add('Contact', 'javascript:void(0)');
        });
        //右側
        Menu::make('right', function ($menu) {
            /* @var \Lavary\Menu\Builder $menu */
            //會員
            if (auth()->check()) {
                if (!auth()->user()->is_confirmed) {
                    $menu->add('尚未完成信箱驗證', ['route' => 'confirm-mail.resend'])
                        ->link->attr(['class' => 'text-danger']);
                }
                //活動選單
                if (Laratrust::can('activity-menu.view') and auth()->user()->isConfirmed) {
                    /** @var \Lavary\Menu\Builder $activityMenu */
                    $activityMenu = $menu->add('活動選單', 'javascript:void(0)');
                }
                //管理員
                if (Laratrust::can('menu.view') and auth()->user()->isConfirmed) {
                    /** @var \Lavary\Menu\Builder $adminMenu */
                    $adminMenu = $menu->add('管理選單', 'javascript:void(0)');

                    if (Laratrust::can(['user.manage', 'user.view'])) {
                        $adminMenu->add('會員清單', ['route' => 'user.index'])->active('user/*');
                    }

                    if (Laratrust::can('student.manage')) {
                        $adminMenu->add('學生管理', ['route' => 'student.index']);
                    }

                    if (Laratrust::can('qrcode.manage')) {
                        $adminMenu->add('QR Code', ['route' => 'qrcode.index']);
                        $adminMenu->add('QR Code 集', ['route' => 'qrcode-set.index']);
                    }

                    if (Laratrust::can('role.manage')) {
                        $adminMenu->add('角色管理', ['route' => 'role.index']);
                    }

                    if (Laratrust::can('log-viewer.access')) {
                        $adminMenu->add(
                            '記錄檢視器 <i class="fa fa-external-link" aria-hidden="true"></i>',
                            ['route' => 'log-viewer::dashboard']
                        )->link->attr('target', '_blank');
                    }
                }
                /** @var \Lavary\Menu\Builder $userMenu */
                $userMenu = $menu->add(auth()->user()->name, 'javascript:void(0)');
                $userMenu->add('個人資料', ['route' => 'profile'])->active('profile/*');
                $userMenu->add('登出', ['route' => 'logout']);
            } else {
                //遊客
                $menu->add('登入', ['route' => 'oauth.index']);
            }
        });

        return $next($request);
    }
}
