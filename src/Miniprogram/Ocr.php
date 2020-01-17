<?php


namespace Xcrms\Wx\Miniprogram;


use Xcrms\Wx\Api;

class Ocr extends MiniBase
{

    public static function driverLicenseByUrl($token,$img_url)
    {
        $url = "https://api.weixin.qq.com/cv/ocr/drivinglicense?access_token=".$token;
        $data = [
            'img_url'=>$img_url
        ];
        $response = Api::postCurl($data,$url);
        if(!$response){
            return false;
        }

        $result =  json_decode($response,true);

        if($result['errcode'] == 0){
            return $result;
        }
        return false;
    }
    public static function driverLicenseByFile($token,$path)
    {
        $url = "https://api.weixin.qq.com/cv/ocr/drivinglicense?access_token=".$token;
        $data = [
            'img'=>new \CURLFile($path)
        ];
        $response = Api::uploadCurl($data, $url);
        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode'] == 0){
            return $result;
        }
        return false;
    }

    public static function businessLicenseByFile($token,$path)
    {
        $url = "https://api.weixin.qq.com/cv/ocr/bizlicense?access_token=".$token;
        $data = [
            'img'=> new \CURLFile($path)
        ];
        $response = Api::uploadCurl($data,$url);
        if(!$response){
            return false;
        }
        $result =  json_decode($response,true);

        if($result['errcode'] == 0){
            return $result;
        }
        return false;

    }

    public static function businessLicenseByUrl($token, $img_url)
    {

        $url = "https://api.weixin.qq.com/cv/ocr/bizlicense?access_token=".$token;
        $data = [
            'img_url'=>$img_url
        ];
        $response = Api::postCurl($data,$url);
        if(!$response){
            return false;
        }

        $result =  json_decode($response,true);

        if($result['errcode'] == 0){
            return $result;
        }
        return false;
    }

    public static function bankcardByUrl($token,$img_url)
    {
        $url = "https://api.weixin.qq.com/cv/ocr/bankcard?access_token=".$token;
        $data = [
            'img_url'=>$img_url
        ];
        $response = Api::postCurl($data,$url);
        if(!$response){
            return false;
        }
        $result =  json_decode($response,true);

        if($result['errcode'] == 0){
            return $result['number'];
        }
        return false;
    }

    public static function bankcardByFile($token,$path)
    {
        $url = "https://api.weixin.qq.com/cv/ocr/bankcard?access_token=".$token;
        $data = [
            'img'=> new \CURLFile($path)
        ];
        $response = Api::uploadCurl($data,$url);
        if(!$response){
            return false;
        }
        $result =  json_decode($response,true);

        if($result['errcode'] == 0){
            return $result['number'];
        }
        return false;
    }

}