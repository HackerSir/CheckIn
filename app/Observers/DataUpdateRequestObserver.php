<?php

namespace App\Observers;

use App\DataUpdateRequest;
use App\Services\LogService;
use App\User;

class DataUpdateRequestObserver
{
    public function creating(DataUpdateRequest $dataUpdateRequest)
    {
        /** @var User $user */
        $user = auth()->user();
        if (!$user) {
            return;
        }
        $logService = app(LogService::class);
        $logService->info(
            "[Club][Request] {$user->name} 請求更新 {$dataUpdateRequest->club->name} 的資料",
            $dataUpdateRequest->getAttributes()
        );
    }

    public function updating(DataUpdateRequest $dataUpdateRequest)
    {
        /** @var User $user */
        $user = auth()->user();
        if (!$user) {
            return;
        }
        $logService = app(LogService::class);
        $logService->info(
            "[Club][Review] {$user->name} 審核了 {$dataUpdateRequest->club->name} 的資料更新申請",
            $dataUpdateRequest->getAttributes()
        );
    }
}
