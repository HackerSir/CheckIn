<?php

namespace App\Observers;

use App\Models\ImgurImage;
use App\Services\ImgurImageService;

class ImgurImageObserver
{
    /**
     * @param ImgurImage $imgurImage
     */
    public function deleted(ImgurImage $imgurImage)
    {
        //檢查該圖片是最後一次被使用
        $countOfSameImgurId = ImgurImage::whereImgurId($imgurImage->imgur_id)->count();
        if ($countOfSameImgurId <= 1) {
            $imgurImageService = app(ImgurImageService::class);
            //透過Delete Hash實際刪除在imgur的圖片
            $imgurImageService->delete($imgurImage);
        }
    }
}
