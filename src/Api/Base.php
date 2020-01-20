<?php


namespace Xcrms\Wx\Api;


use Xcrms\Wx\Curl;

/***
 * @todo 基类
 * Class Base
 * @package Xcrms\Wx\Miniprogram
 */
class Base
{
    public static function getAccessToken($appid,$appsecret)
    {
        if(empty($appid) || empty($appsecret)){
            return false;
        }
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
        $response = Curl::getCurl($url);
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