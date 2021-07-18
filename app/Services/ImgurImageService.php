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
    public function upload(UploadedFile $uploadedFile): ImgurImage
    {
        //取得檔案
        $fileContent = File::get($uploadedFile->getPathname());
        //將圖片上傳至Imgur
        //檢查Client ID和Client secret
        if (empty(config('imgur.client_id')) || empty(config('imgur.client_secret'))) {
            throw new \Exception('Missing IMGUR_CLIENT_ID or IMGUR_CLIENT_SECRET in .env');
        }
        $imageClient = $this->getImgurImageClient();
        $imageData = [
            'image' => base64_encode($fileContent),
            'type'  => 'base64',
        ];
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

    /**
     * 透過 Delete Hash 實際刪除在 Imgur 的圖片
     * @param ImgurImage $imgurImage
     */
    public function delete(ImgurImage $imgurImage)
    {
        $imageClient = $this->getImgurImageClient();
        $imageClient->deleteImage($imgurImage->delete_hash);
    }

    /**
     * @return  \Imgur\Api\Image
     */
    private function getImgurImageClient(): \Imgur\Api\Image
    {
        $client = new \Imgur\Client();
        $client->setOption('client_id', config('imgur.client_id'));
        $client->setOption('client_secret', config('imgur.client_secret'));
        /** @var \Imgur\Api\Image $imageClient */
        $imageClient = $client->api('image');

        return $imageClient;
    }
}
