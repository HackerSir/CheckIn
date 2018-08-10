<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Yish\Generators\Foundation\Service\Service;

class FcuApiService extends Service
{
    protected $repository;

    /**
     * @param string $nid
     * @return array|null
     */
    public function getStuInfo($nid)
    {
        $nid = strtoupper($nid);
        if (empty(trim($nid))) {
            return null;
        }
        //API資訊
        $apiUrl = config('services.fcu-api.url-get-stu-info');
        $apiClientId = config('services.fcu-api.client-id');
        if (!$apiUrl || !$apiClientId) {
            return null;
        }
        //請求
        $client = new Client();
        $option = [
            'verify' => false,
            'query'  => [
                'client_id' => $apiClientId,
                'id'        => $nid,
            ],
        ];
        try {
            //送出請求並取得結果
            $response = $client->request('GET', $apiUrl, $option);
        } catch (ClientException | GuzzleException $e) {
            //忽略例外
            $response = $e->getResponse();
        }
        //回應
        $responseJson = json_decode($response->getBody());
        //若無法轉成json，表示未順利連上API（API可能回應404，因此無法透過ResponseStatusCode判斷連線成功失敗）
        if (!$responseJson) {
            return null;
        }
        if (!isset($responseJson->UserInfo[0]->status) || $responseJson->UserInfo[0]->status != 1) {
            return null;
        }
        try {
            $userInfo = (array) $responseJson->UserInfo[0];
        } catch (Exception $e) {
            return null;
        }

        return $userInfo;
    }

    public function getLoginUser($userCode)
    {
        if (empty(trim($userCode))) {
            return null;
        }
        //API資訊
        $apiUrl = config('services.fcu-api.url-get-login-user');
        $apiClientId = config('services.fcu-api.client-id');
        if (!$apiUrl || !$apiClientId) {
            return null;
        }
        //請求
        $client = new Client();
        $option = [
            'verify' => false,
            'query'  => [
                'client_id' => $apiClientId,
                'user_code' => $userCode,
            ],
        ];
        try {
            //送出請求並取得結果
            $response = $client->request('GET', $apiUrl, $option);
        } catch (ClientException | GuzzleException $e) {
            //忽略例外
            $response = $e->getResponse();
        }
        //回應
        $responseJson = json_decode($response->getBody());
        //若無法轉成json，表示未順利連上API（API可能回應404，因此無法透過ResponseStatusCode判斷連線成功失敗）
        if (!$responseJson) {
            return null;
        }
        if (!isset($responseJson->UserInfo[0]->status) || $responseJson->UserInfo[0]->status != 1) {
            return null;
        }
        try {
            $userInfo = (array) $responseJson->UserInfo[0];
        } catch (Exception $e) {
            return null;
        }

        return $userInfo;
    }
}
