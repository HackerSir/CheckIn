<?php

namespace App\Presenters;

use Illuminate\Support\Str;

class ActivityLogPresenter
{
    /**
     * 根據類別和ID取得檢視網址
     *
     * @param string|null $type
     * @param int|null $id
     * @return string|null
     */
    public function getRouteLink(?string $type, ?int $id): ?string
    {
        if (!$type || !$id) {
            return null;
        }
        // 取得 Model 名稱（如：App\TeaParty → TeaParty）
        $modelName = str_replace(['App\\', 'Models\\'], '', $type);
        // 轉換為 kebab case，並加上 .show（如：TeaParty → tea-party.show）
        $routeName = Str::kebab($modelName) . '.show';
        if (!\Route::has($routeName)) {
            // 若該路由不存在，嘗試從特例清單中尋找
            $routeName = array_get(config('activity-type.route'), $type);
            if (!$routeName) {
                return $id;
            }
        }

        return link_to_route($routeName, $id, $id);
    }
}
