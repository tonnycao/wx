<?php


namespace Xcrms\Wx\Api;


use Xcrms\Wx\Curl;

class Qrcode extends Base
{
    public static function create($token,$path,$width=430)
    {
        $url = "POST https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".$token;
        $data = [
            'path'=>$path,
            'width'=>$width
        ];
        $response = Curl::postCurl($data,$url);
        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode']!=0){
            return false;
        }
        return $result;
    }

    public static function get($token,$path,$options)
    {
        $url = "https://api.weixin.qq.com/wxa/getwxacode?access_token=".$token;
        $data = [
            'path'=>$path,
        ];

        if(!empty($options['width']))
        {
            $data['width'] = $options['width'];
        }
        if(isset($options['auto_color']) && is_bool($options['auto_color']))
        {
            $data['auto_color'] = $options['auto_color'];
        }
        if(!empty($options['line_color']))
        {
            $data['line_color'] = json_encode($options['line_color']);
        }
        if(isset($options['is_hyaline']) && is_bool($options['is_hyaline']))
        {
            $data['is_hyaline'] = $options['is_hyaline'];
        }
        $response = Curl::postCurl($data,$url);
        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode']!=0){
            return false;
        }
        return $result;
    }

    public static function getUnLimited($token,$scene,$options)
    {
        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$token;
        $data = [
            'scene'=>$scene,
        ];
        if(!empty($options['page']))
        {
            $data['page'] = $options['page'];
        }
        if(!empty($options['width']))
        {
            $data['width'] = $options['width'];
        }
        if(isset($options['auto_color']) && is_bool($options['auto_color']))
        {
            $data['auto_color'] = $options['auto_color'];
        }
        if(!empty($options['line_color']))
        {
            $data['line_color'] = json_encode($options['line_color']);
        }
        if(isset($options['is_hyaline']) && is_bool($options['is_hyaline']))
        {
            $data['is_hyaline'] = $options['is_hyaline'];
        }
        $response = Curl::postCurl($data,$url);
        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode']!=0){
            return false;
        }
        return $result;
    }
}