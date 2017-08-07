<?php

namespace App\Observers;

use App\ImgurImage;

class ImgurImageObserver
{
    public function deleted(ImgurImage $imgurImage)
    {
        //透過Delete Hash實際刪除在imgur的圖片
        $client = app()->make('Imgur\Client');
        $client->api('image')->deleteImage($imgurImage->delete_hash);
    }
}
