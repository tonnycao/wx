<?php


namespace Xcrms\Wx\Api;


use Xcrms\Wx\Curl;

class Voice2Text extends Base
{
    public static function uploadVoice($token,$voice_id,$path,$lang='zh_CN')
    {
        $url = "http://api.weixin.qq.com/cgi-bin/media/voice/addvoicetorecofortext?access_token=".$token."&format=mp3&voice_id=".$voice_id."&lang=".$lang;
        $param = [
            'file'=>new \CURLFile($path)
        ];
        $response = Curl::uploadCurl($param,$url);
        if(!$response){
            return false;
        }
        return json_decode($response,true);
    }

    public static function getResult($token,$voice_id,$lang='zh_CN')
    {
        $url = "http://api.weixin.qq.com/cgi-bin/media/voice/queryrecoresultfortext?access_token=".$token."&voice_id=".$voice_id."&lang=".$lang;
        $param = [];
        $response = Curl::postCurl($param,$url);
        if(!$response){
            return false;
        }
        return json_decode($response,true);
    }

    public static function translate($token,$text,$form='zh_CN',$to='en_US')
    {
        $url = "http://api.weixin.qq.com/cgi-bin/media/voice/translatecontent?access_token=".$token."&lfrom=".$form."&lto=".$to;
        $param = $text;
        $response = Curl::postCurl($param,$url);
        if(!$response){
            return false;
        }
        return json_decode($response,true);
    }

}