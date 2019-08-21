<?php

namespace App\CustomFacades\Classes;

use App\ApiKey;
use Log;

class GoogleApi
{
    /**
     * 取得一組GoogleAPI金鑰
     *
     * @return string
     */
    public function getKey()
    {
        // 取得目前使用最少次的ApiKey
        // 24000 是免費上限 25000 - 1000
        // https://developers.google.com/maps/documentation/javascript/usage?hl=zh-tw
        /** @var ApiKey $apiKey */
        $apiKey = ApiKey::where('count', '<', 24000)->orderBy('count')->first();
        if (!$apiKey) {
            Log::error('No Google api key can be used.');

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
