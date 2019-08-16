<?php

namespace App\Observers;

use App\Club;

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
    }
}
