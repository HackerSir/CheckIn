<?php

namespace App\Http\Middleware;

use App\User;
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
            $menu->add('社團攤位', ['route' => 'clubs.index'])->active('clubs');

            $menu->add('攤位地圖', ['route' => ['clubs.map', 'type' => 'static']])->active('map');
        });
        //右側
        Menu::make('right', function ($menu) {
            /* @var \Lavary\Menu\Builder $menu */
            //會員
            if (auth()->check()) {
                /** @var User $user */
                $user = auth()->user();
                if (!$user->is_confirmed) {
                    $menu->add('尚未完成信箱驗證', ['route' => 'confirm-mail.resend'])
                        ->link->attr(['class' => 'text-danger']);
                } else {
                    $menu->add('問卷', ['route' => 'survey.index'])->active('survey/*');
                    //負責的社團
                    if ($user->club) {
                        $menu->add($user->club->name, ['route' => ['clubs.show', $user->club]]);
                    }
                    if ($user->student || $user->club) {
                        $menu->add('回饋資料', ['route' => 'feedback.index'])->active('feedback/*');
                    }
                    //活動選單
                    if (Laratrust::can('activity-menu.view')) {
                        /** @var \Lavary\Menu\Item $activityMenu */
                        $activityMenu = $menu->add('活動選單', 'javascript:void(0)');

                        if (Laratrust::can('student.manage')) {
                            $activityMenu->add('學生管理', ['route' => 'student.index'])->active('student/*');
                        }

                        if (Laratrust::can('qrcode.manage')) {
                            $activityMenu->add('QR Code', ['route' => 'qrcode.index'])->active('qrcode/*');
                        }

                        $this->addDivider($activityMenu);

                        if (Laratrust::can('booth.manage')) {
                            $activityMenu->add('攤位管理', ['route' => 'booth.index'])->active('booth/*');
                        }

                        if (Laratrust::can('club.manage')) {
                            $activityMenu->add('社團管理', ['route' => 'club.index'])->active('club/*');
                            $activityMenu->add('社團資料更新請求管理', ['route' => 'data-update-request.index'])
                                ->active('club/data-update-request/*');
                        }

                        if (Laratrust::can('club-type.manage')) {
                            $activityMenu->add('社團類型管理', ['route' => 'club-type.index'])->active('club-type/*');
                        }

                        if (Laratrust::can('record.manage')) {
                            $activityMenu->add('打卡紀錄管理', ['route' => 'record.index'])->active('record/*');
                        }

                        $this->addDivider($activityMenu);

                        if (Laratrust::can('ticket.manage')) {
                            $activityMenu->add('抽獎編號管理', ['route' => 'ticket.index'])->active('ticket/*');
                        }

                        if (Laratrust::can('extra-ticket.manage')) {
                            $activityMenu->add('工作人員抽獎編號管理', ['route' => 'extra-ticket.index'])
                                ->active('extra-ticket/*');
                        }

                        $this->addDivider($activityMenu);

                        if (Laratrust::can('feedback.manage')) {
                            $activityMenu->add('回饋資料管理', ['route' => 'feedback.index'])->active('feedback/*');
                        }
                        if (Laratrust::can('survey.manage')) {
                            $activityMenu->add('學生問卷管理', ['route' => 'student-survey.index'])
                                ->active('student-survey/*');
                        }

                        $this->addDivider($activityMenu);

                        if (Laratrust::can('setting.manage')) {
                            $activityMenu->add('活動設定', ['route' => 'setting.edit']);
                        }
                    }

                    //統計
                    if (Laratrust::can('stats.access')) {
                        /** @var \Lavary\Menu\Item $statsMenu */
                        $statsMenu = $menu->add('統計', 'javascript:void(0)')->active('stats/*');
                        $statsMenu->add('統計', ['route' => 'stats.index']);
                        $statsMenu->add('熱度地圖', ['route' => 'stats.heatmap']);
                    }

                    //管理員
                    if (Laratrust::can('menu.view')) {
                        /** @var \Lavary\Menu\Item $adminMenu */
                        $adminMenu = $menu->add('管理選單', 'javascript:void(0)');

                        if (Laratrust::can(['user.manage', 'user.view'])) {
                            $adminMenu->add('會員清單', ['route' => 'user.index'])->active('user/*');
                        }

                        if (Laratrust::can('role.manage')) {
                            $adminMenu->add('角色管理', ['route' => 'role.index'])->active('role/*');
                        }

                        if (Laratrust::can('api-key.manage')) {
                            $adminMenu->add('API Key 管理', ['route' => 'api-key.index'])->active('api-key/*');
                        }

                        if (Laratrust::can('broadcast.manage')) {
                            $adminMenu->add('Broadcast Test', ['route' => 'broadcast-test'])->active('broadcast-test/*');
                        }

                        if (Laratrust::can('horizon.manage')) {
                            $adminMenu->add(
                                'Horizon <i class="fa fa-external-link-alt" aria-hidden="true"></i>',
                                ['route' => 'horizon.index']
                            )->link->attr('target', '_blank');
                        }

                        if (Laratrust::can('log-viewer.access')) {
                            $adminMenu->add(
                                '記錄檢視器 <i class="fa fa-external-link-alt" aria-hidden="true"></i>',
                                ['route' => 'log-viewer::dashboard']
                            )->link->attr('target', '_blank');
                        }
                    }
                }
                /** @var \Lavary\Menu\Item $userMenu */
                $userMenu = $menu->add($user->name, 'javascript:void(0)');
                $userMenu->add('個人資料', ['route' => 'profile'])->active('profile/*');
                $userMenu->add('登出', ['route' => 'logout']);
            } else {
                //遊客
                $menu->add('登入', ['route' => 'oauth.index']);
            }
        });

        return $next($request);
    }

    protected function addDivider(\Lavary\Menu\Item $subMenu)
    {
        $lastItem = $subMenu->children()->last();
        if ($lastItem) {
            $lastItem->divide();
        }
    }
}
