<?php

namespace App\Observers;

use App\Club;
use App\Services\LogService;
use App\User;

class ClubObserver
{
    /**
     * @param Club $club
     * @throws \Exception
     */
    public function deleting(Club $club)
    {
        //刪除圖片
        if ($club->imgurImage) {
            $club->imgurImage->delete();
        }
        /** @var User $user */
        $user = auth()->user();
        if (!$user) {
            return;
        }
        $logService = app(LogService::class);
        $logService->info(
            "[Club][Delete] {$user->name} 刪除了 {$club->name}",
            $club->getAttributes()
        );
    }

    public function creating(Club $club)
    {
        /** @var User $user */
        $user = auth()->user();
        if (!$user) {
            return;
        }
        $logService = app(LogService::class);
        $logService->info(
            "[Club][Create] {$user->name} 建立了 {$club->name}",
            $club->getAttributes()
        );
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
