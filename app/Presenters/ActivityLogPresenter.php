<?php

namespace App\Presenters;

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
        $route = array_get(config('activity-type.route'), $type);
        if (!$route) {
            return $id;
        }

        return link_to_route($route, $id, $id);
    }
}
