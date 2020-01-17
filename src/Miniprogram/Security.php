<?php


namespace Xcrms\Wx\Miniprogram;


use Xcrms\Wx\Api;

class Security extends MiniBase
{
    public static function imgSecCheck($token,$path){
        $url = "https://api.weixin.qq.com/wxa/img_sec_check?access_token=".$token;
        $data = [
            'media'=> new \CURLFile($path)
        ];
        $response = Api::uploadCurl($data,$url);
        return json_decode($response,true);
    }

    public static function mediaCheck($token,$path,$type)
    {
        $url = "https://api.weixin.qq.com/wxa/media_check_async?access_token=".$token;
        $data = [
            'media_url'=> new \CURLFile($path),
            'media_type'=>$type
        ];
        $response = Api::uploadCurl($data,$url);
        return json_decode($response,true);
    }

    public static function MsgCheck($token,$content)
    {
        $url = "https://api.weixin.qq.com/wxa/msg_sec_check?access_token=".$token;
        $data = [
            'content'=>$content
        ];
        $response = Api::postCurl($data,$url);
        return json_decode($response,true);
    }
}