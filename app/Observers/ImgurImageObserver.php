<?php

namespace App\Observers;

use App\ImgurImage;

class ImgurImageObserver
{
    /**
     * @param ImgurImage $imgurImage
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function deleted(ImgurImage $imgurImage)
    {
        //檢查該圖片是最後一次被使用
        $countOfSameImgurId = ImgurImage::whereImgurId($imgurImage->imgur_id)->count();
        if ($countOfSameImgurId <= 1) {
            //透過Delete Hash實際刪除在imgur的圖片
            $client = app()->make('Imgur\Client');
            $client->api('image')->deleteImage($imgurImage->delete_hash);
        }
    }
}
