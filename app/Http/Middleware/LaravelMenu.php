<?php

namespace App\Http\Middleware;

use App\Models\ContactInformation;
use App\Models\Student;
use App\Models\User;
use Closure;
use Gate;
use Illuminate\Http\Request;
use Laratrust;
use Lavary\Menu\Builder;
use Lavary\Menu\Item;
use Menu;

class LaravelMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //左側
        Menu::make('left', function ($menu) {
            /* @var Builder $menu */
            $menu->add('我的條碼', ['route' => 'my-qrcode'])->active('my-qrcode');
            $menu->add('社團介紹', ['route' => 'clubs.index'])->active('clubs');
            $menu->add('攤位地圖', ['route' => ['clubs.map.static']])->active('map');
            $menu->add('迎新茶會', ['route' => ['tea-party.list']])->active('tea-parties');
            if (auth()->check()) {
                $menu->add('收藏社團', ['route' => ['clubs.index', 'favorite']]);
            }
        });
        //右側
        Menu::make('right', function ($menu) {
            /* @var Builder $menu */
            //會員
            if (auth()->check()) {
                /** @var User $user */
                $user = auth()->user();
                if (!$user->is_confirmed) {
                    $menu->add('尚未完成信箱驗證', ['route' => 'confirm-mail.resend'])
                        ->link->attr(['class' => 'text-danger']);
                } else {
                    $menu->add('平台問卷', ['route' => 'survey.index'])->active('survey/*');
                    //負責的社團
                    if ($user->club) {
                        $myClubMenu = $menu->add('我的社團', 'javascript:void(0)');
                        $myClubMenu->add($user->club->name, ['route' => ['clubs.show', $user->club]]);
                        $myClubMenu->add('條碼掃描', ['route' => ['qrcode.web-scan']]);
//                        $myClubMenu->add('繳費紀錄', ['route' => 'payment-record.index'])
//                            ->active('payment-record/*');
                    }
                    if ($user->student || $user->club) {
                        $menu->add('回饋資料', ['route' => 'feedback.index'])->active('feedback/*');
                    }
                    //活動選單
                    if (Laratrust::isAbleTo('activity-menu.view')) {
                        /** @var Item $activityMenu */
                        $activityMenu = $menu->add('活動', 'javascript:void(0)');

                        if (Gate::allows('viewAny', Student::class)) {
                            $activityMenu->add('學生管理', ['route' => 'student.index'])->active('student/*');
                        }

                        if (Laratrust::isAbleTo('qrcode.manage')) {
                            $activityMenu->add('QR Code', ['route' => 'qrcode.index'])->active('qrcode/*');
                        }

                        $this->addDivider($activityMenu);

                        if (Laratrust::isAbleTo('booth.manage')) {
                            $activityMenu->add('攤位管理', ['route' => 'booth.index'])->active('booth/*');
                        }

                        if (Laratrust::isAbleTo('club.manage')) {
                            $activityMenu->add('社團管理', ['route' => 'club.index'])->active('club/*');
                            $activityMenu->add('社團資料更新請求管理', ['route' => 'data-update-request.index'])
                                ->active('club/data-update-request/*');
                        }

                        if (Laratrust::isAbleTo('tea-party.manage')) {
                            $activityMenu->add('迎新茶會管理', ['route' => 'tea-party.index'])->active('tea-party/*');
                        }

                        if (Laratrust::isAbleTo('club-type.manage')) {
                            $activityMenu->add('社團類型管理', ['route' => 'club-type.index'])->active('club-type/*');
                        }

                        if (Laratrust::isAbleTo('record.manage')) {
                            $activityMenu->add('打卡紀錄管理', ['route' => 'record.index'])->active('record/*');
                        }

//                        if (Laratrust::isAbleTo('payment-record.manage')) {
//                            $activityMenu->add('繳費紀錄管理', ['route' => 'payment-record.index'])
//                                ->active('payment-record/*');
//                        }

                        $this->addDivider($activityMenu);

                        if (Laratrust::isAbleTo('ticket.manage')) {
                            $activityMenu->add('抽獎編號管理', ['route' => 'ticket.index'])->active('ticket/*');
                        } elseif (Laratrust::isAbleTo('ticket.show-ticket')) {
                            $activityMenu->add('抽獎編號展示', ['route' => 'ticket.ticket']);
                        }

                        if (Laratrust::isAbleTo('extra-ticket.manage')) {
                            $activityMenu->add('工作人員抽獎編號管理', ['route' => 'extra-ticket.index'])
                                ->active('extra-ticket/*');
                        } elseif (Laratrust::isAbleTo('extra-ticket.show-ticket')) {
                            $activityMenu->add('工作人員抽獎編號展示', ['route' => 'extra-ticket.ticket']);
                        }

                        if (Laratrust::isAbleTo('student-ticket.manage')) {
                            $activityMenu->add('學生抽獎編號管理', ['route' => 'student-ticket.index'])
                                ->active('student-ticket/*');
                        } elseif (Laratrust::isAbleTo('student-ticket.show-ticket')) {
                            $activityMenu->add('學生抽獎編號管理', ['route' => 'student-ticket.ticket']);
                        }

                        $this->addDivider($activityMenu);

                        if (Gate::allows('viewAny', ContactInformation::class)) {
                            $activityMenu->add('聯絡資料管理', ['route' => 'contact-information.index'])
                                ->active('contact-information/*');
                        }

                        if (Laratrust::isAbleTo('feedback.manage')) {
                            $activityMenu->add('回饋資料管理', ['route' => 'feedback.index'])->active('feedback/*');
                        }
                        if (Laratrust::isAbleTo('survey.manage')) {
                            $activityMenu->add('學生問卷管理', ['route' => 'student-survey.index'])
                                ->active('student-survey/*');
                            $activityMenu->add('社團問卷管理', ['route' => 'club-survey.index'])
                                ->active('club-survey/*');
                        }

                        $this->addDivider($activityMenu);

                        if (Laratrust::isAbleTo('setting.manage')) {
                            $activityMenu->add('活動設定', ['route' => 'setting.edit']);
                        }
                    }

                    //統計
                    if (Laratrust::isAbleTo('stats.access')) {
                        /** @var Item $statsMenu */
                        $statsMenu = $menu->add('統計', 'javascript:void(0)')->active('stats/*');
                        $statsMenu->add('統計', ['route' => 'stats.index']);
                        $statsMenu->add('熱度地圖', ['route' => 'stats.heatmap']);
                    }

                    //管理員
                    if (Laratrust::isAbleTo('menu.view')) {
                        /** @var Item $adminMenu */
                        $adminMenu = $menu->add('管理', 'javascript:void(0)');

                        if (Laratrust::isAbleTo(['user.manage', 'user.view'])) {
                            $adminMenu->add('會員清單', ['route' => 'user.index'])->active('user/*');
                        }

                        if (Laratrust::isAbleTo('role.manage')) {
                            $adminMenu->add('角色管理', ['route' => 'role.index'])->active('role/*');
                        }

                        if (Laratrust::isAbleTo('api-key.manage')) {
                            $adminMenu->add('API Key 管理', ['route' => 'api-key.index'])->active('api-key/*');
                        }

                        if (Laratrust::isAbleTo('broadcast.manage')) {
                            $adminMenu->add('Broadcast Test', ['route' => 'broadcast-test'])
                                ->active('broadcast-test/*');
                        }

                        if (Laratrust::isAbleTo('activity-log.access')) {
                            $adminMenu->add('活動紀錄', ['route' => 'activity-log.index'])->active('activity-log/*');
                        }

                        if (Laratrust::isAbleTo('horizon.manage')) {
                            $adminMenu->add(
                                'Horizon<i class="fa fa-external-link-alt ml-2"></i>',
                                ['route' => 'horizon.index']
                            )->link->attr('target', '_blank');
                        }

                        if (Laratrust::isAbleTo('log-viewer.access')) {
                            $adminMenu->add(
                                '記錄檢視器<i class="fa fa-external-link-alt ml-2"></i>',
                                ['route' => 'log-viewer::dashboard']
                            )->link->attr('target', '_blank');
                        }
                    }
                }
                /** @var Item $userMenu */
                $userMenu = $menu->add($user->name, 'javascript:void(0)');
                $userMenu->add('個人資料', ['route' => 'profile'])->active('profile/*');
                if ($user->student) {
                    $userMenu->add('聯絡資料', ['route' => 'contact-information.my.index'])
                        ->active('my-contact-information/*');
                }
                $userMenu->add('登出', ['route' => 'logout']);
            } else {
                //遊客
                $menu->add('登入', ['route' => 'oauth.index']);
            }
        });

        return $next($request);
    }

    protected function addDivider(Item $subMenu)
    {
        $lastItem = $subMenu->children()->last();
        if ($lastItem) {
            $lastItem->divide();
        }
    }
}
