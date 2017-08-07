<?php

namespace App\Services;

use App\ImgurImage;
use File;
use Illuminate\Http\UploadedFile;

class ImgurImageService
{
    /**
     * 上傳圖片
     *
     * @param UploadedFile $uploadedFile
     * @return ImgurImage
     * @throws \Exception
     */
    public function upload(UploadedFile $uploadedFile)
    {
        //取得檔案
        $fileContent = File::get($uploadedFile->getPathname());
        //將圖片上傳至Imgur
        //檢查Client ID和Client secret
        if (empty(env('IMGUR_CLIENT_ID')) || empty(env('IMGUR_CLIENT_SECRET'))) {
            throw new \Exception('Missing IMGUR_CLIENT_ID or IMGUR_CLIENT_SECRET in .env');
        }
        /** @var \Imgur\Client $client */
        $client = app()->make('Imgur\Client');
        $imageData = [
            'image' => base64_encode($fileContent),
            'type'  => 'base64',
        ];
        /** @var \Imgur\Api\Image $imageClient */
        $imageClient = $client->api('image');
        $data = $imageClient->upload($imageData);
        //圖檔原始名稱
        $fileOriginalName = $uploadedFile->getClientOriginalName();
        //額外記錄圖片資料（Imgur ID與Delete Hash）
        $imgurImage = ImgurImage::create([
            'imgur_id'    => $data['id'],
            'file_name'   => $fileOriginalName,
            'extension'   => mb_strtolower($uploadedFile->getClientOriginalExtension()),
            'delete_hash' => $data['deletehash'],
        ]);

        return $imgurImage;
    }
}
