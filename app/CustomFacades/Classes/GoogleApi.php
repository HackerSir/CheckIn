<?php

namespace App\CustomFacades\Classes;

use App\ApiKey;

class GoogleApi
{
    /**
     * 取得一組GoogleAPI金鑰
     *
     * @return string
     */
    public function getKey()
    {
        //取得目前使用最少次的ApiKey
        /** @var ApiKey $apiKey */
        $apiKey = ApiKey::query()->orderBy('count')->first();
        if (!$apiKey) {
            return 'No ApiKey exists';
        }
        //更新使用次數
        $apiKey->update([
            'count'       => $apiKey->count + 1,
            'total_count' => $apiKey->total_count + 1,
        ]);

        return $apiKey->api_key;
    }
}
