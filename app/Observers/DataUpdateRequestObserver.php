<?php

namespace App\Observers;

use App\Models\DataUpdateRequest;
use Exception;

class DataUpdateRequestObserver
{
    /**
     * @param  DataUpdateRequest  $dataUpdateRequest
     *
     * @throws Exception
     */
    public function deleting(DataUpdateRequest $dataUpdateRequest)
    {
        //刪除圖片
        if ($dataUpdateRequest->originalImgurImage) {
            $dataUpdateRequest->originalImgurImage->delete();
        }
        if ($dataUpdateRequest->imgurImage) {
            $dataUpdateRequest->imgurImage->delete();
        }
    }
}
