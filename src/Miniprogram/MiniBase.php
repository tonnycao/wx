<?php


namespace Xcrms\Wx\Miniprogram;


use Xcrms\Wx\Api;

class MiniBase
{
    public static function getAccessToken($appid,$appsecret)
    {
        if(empty($appid) || empty($appsecret)){
            return false;
        }
        $response = Api::getAccessToken($appid,$appsecret);
        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode'] !=0){
            return false;
        }
        return $result;
    }
}