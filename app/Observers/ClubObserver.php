<?php

namespace App\Observers;

use App\Club;
use App\Services\LogService;
use App\User;

class ClubObserver
{
    public function deleting(Club $club)
    {
        //刪除圖片
        if ($club->imgurImage) {
            $club->imgurImage->delete();
        }
    }

    public function updating(Club $club)
    {
        /** @var User $user */
        $user = auth()->user();
        if (!$user) {
            return;
        }
        $logService = app(LogService::class);
        $logService->info(
            "[Club][Update] {$user->name} 更新了 {$club->name} 的資料",
            $club->getOriginal(),
            $club->getAttributes()
        );
    }
}
