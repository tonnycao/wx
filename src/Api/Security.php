<?php


namespace Xcrms\Wx\Api;


use Xcrms\Wx\Curl;

class Security extends Base
{
    public static function imgSecCheck($token,$path){
        $url = "https://api.weixin.qq.com/wxa/img_sec_check?access_token=".$token;
        $data = [
            'media'=> new \CURLFile($path)
        ];
        $response = Curl::uploadCurl($data,$url);
        return json_decode($response,true);
    }

    public static function mediaCheck($token,$path,$type)
    {
        $url = "https://api.weixin.qq.com/wxa/media_check_async?access_token=".$token;
        $data = [
            'media_url'=> new \CURLFile($path),
            'media_type'=>$type
        ];
        $response = Curl::uploadCurl($data,$url);
        return json_decode($response,true);
    }

    public static function MsgCheck($token,$content)
    {
        $url = "https://api.weixin.qq.com/wxa/msg_sec_check?access_token=".$token;
        $data = [
            'content'=>$content
        ];
        $response = Curl::postCurl($data,$url);
        return json_decode($response,true);
    }
}