<?php


namespace Xcrms\Wx\Api;


use Xcrms\Wx\Curl;

class Ocr extends Base
{

    public static function idCardByFile($token,$path)
    {
        $url =  "https://api.weixin.qq.com/cv/ocr/idcard?access_token=".$token;
        $data = [
            'img'=>new \CURLFile($path)
        ];
        $response = Curl::uploadCurl($data, $url);
        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode'] == 0){
            return $result;
        }
        return false;
    }

    public static function idCardByUrl($token,$img_url)
    {
        $url =  "https://api.weixin.qq.com/cv/ocr/idcard?img_url=".urlencode($img_url)."&access_token=".$token;
        $data = [
            'img_url'=>$img_url
        ];
        $response = Curl::postCurl($data,$url);
        if(!$response){
            return false;
        }

        $result =  json_decode($response,true);

        if($result['errcode'] == 0){
            return $result;
        }
        return false;
    }
    public static function driverLicenseByUrl($token,$img_url)
    {
        $url = "https://api.weixin.qq.com/cv/ocr/drivinglicense?access_token=".$token;
        $data = [
            'img_url'=>$img_url
        ];
        $response = Curl::postCurl($data,$url);
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
        $response = Curl::uploadCurl($data, $url);
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
        $response = Curl::uploadCurl($data,$url);
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
        $response = Curl::postCurl($data,$url);
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
        $response = Curl::postCurl($data,$url);
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
        $response = Curl::uploadCurl($data,$url);
        if(!$response){
            return false;
        }
        $result =  json_decode($response,true);

        if($result['errcode'] == 0){
            return $result['number'];
        }
        return false;
    }

    /***
     * @todo 识别图片文字
     * @param $token
     * @param $img_url
     * @return bool|mixed
     */
    public static function printedTextBYUrl($token,$img_url)
    {
        $url = "https://api.weixin.qq.com/cv/ocr/comm?img_url=".urlencode($img_url)."&access_token=".$token;
        $response = Curl::getCurl($url);
        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode'] == 0){
            return $result;
        }
        return false;
    }

    /***
     * @todo 识别图片文字
     * @param $token
     * @param $path
     * @return bool
     */
    public static function printedTextByFile($token,$path)
    {
        $url = "https://api.weixin.qq.com/cv/ocr/comm?access_token=".$token;

        $data = [
            'img'=> new \CURLFile($path)
        ];
        $response = Curl::uploadCurl($data,$url);
        if(!$response){
            return false;
        }
        $result =  json_decode($response,true);

        if($result['errcode'] == 0){
            return $result['number'];
        }
        return false;
    }

    public static function vehicleLicenseWithUrl($token,$img_url)
    {
        $url = "https://api.weixin.qq.com/cv/ocr/driving?type=MODE&img_url=".urlencode($img_url)."&access_token=".$token;
        $response = Curl::getCurl($url);
        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode'] == 0){
            return $result;
        }
        return false;
    }

    public static function vehicleLicenseWithFile($token,$path)
    {
        $url = "https://api.weixin.qq.com/cv/ocr/driving?type=photo&access_token=".$token;
        $data = [
            'img'=> new \CURLFile($path)
        ];
        $response = Curl::uploadCurl($data,$url);
        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode'] == 0){
            return $result;
        }
        return false;
    }
}