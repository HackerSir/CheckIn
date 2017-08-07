<?php

namespace App\Observers;

use App\Club;

class ClubObserver
{
    public function deleting(Club $club)
    {
        //刪除圖片
        if ($club->imgurImage) {
            $club->imgurImage->delete();
        }
    }
}
