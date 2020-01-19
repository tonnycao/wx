<?php


namespace Xcrms\Wx\Mp;


use Xcrms\Wx\Api;

class Image extends MpBase
{
    /***
     * @todo 二维码识别
     * @param $token
     * @param $img_url
     * @return bool|mixed
     */
    public static function qrcodeWithUrl($token,$img_url)
    {
        $url = "https://api.weixin.qq.com/cv/img/qrcode?img_url=".urlencode($img_url)."&access_token=".$token;
        $response = Api::getCurl($url);
        if(!$response){
            return false;
        }
        return json_decode($response,true);
    }

    /***
     * @todo 二维码识别
     * @param $token
     * @param $path
     * @return bool|mixed
     */
    public static function qrcodeWithPath($token,$path)
    {
        $url = "https://api.weixin.qq.com/cv/img/qrcode?access_token=".$token;
        $data = [
            'img'=>new \CURLFile($path)
        ];
        $response = Api::uploadCurl($data,$url);

        if(!$response){
            return false;
        }
        return json_decode($response,true);
    }

    /***
     * @todo 图片高清化
     * @param $token
     * @param $img_url
     * @return bool|mixed
     */
    public static function hdWithUrl($token,$img_url)
    {
        $url = "https://api.weixin.qq.com/cv/img/superresolution?img_url=".urlencode($img_url)."&access_token=".$token;
        $response = Api::getCurl($url);
        if(!$response){
            return false;
        }
        return json_decode($response,true);
    }

    /***
     * @todo 图片高清化
     * @param $token
     * @param $path
     * @return bool|mixed
     */
    public static function hdWithFile($token,$path)
    {
        $url = "https://api.weixin.qq.com/cv/img/superresolution?access_token=".$token;
        $data = [
            'img'=>new \CURLFile($path)
        ];

        $response = Api::uploadCurl($data,$url);

        if(!$response){
            return false;
        }
        return json_decode($response,true);
    }

    /***
     * @todo 下载资源
     * @param $token
     * @param $media_id
     * @param $abs_path
     * @param int $time_out
     * @return bool
     */
    public static function download($token,$media_id,$abs_path,$time_out=2)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/media/get?access_token=".$token."&media_id=".$media_id;
        return Api::downloadCurl($url,$abs_path,$time_out);
    }

    /***
     * @todo 图片裁剪
     * @param $token
     * @param $img_url
     * @param null $options
     * @return bool|mixed
     */
    public static function cropWithUrl($token,$img_url,$options=NULL)
    {
        $url = "http://api.weixin.qq.com/cv/img/aicrop?img_url=".urlencode($img_url)."&access_token=".$token;
        $data = [];
        if(!empty($options)){
            $data = $options;
        }
        if(empty($data)){
            $response = Api::getCurl($url);
        }else{
            $response = Api::postCurl($data,$url);
        }

        if(!$response){
            return false;
        }
        return json_decode($response,true);
    }

    /***
     * @todo 图片裁剪
     * @param $token
     * @param $path
     * @param null $options
     * @return bool|mixed
     */
    public static function cropWithFile($token,$path,$options=NULL)
    {
        $url = "http://api.weixin.qq.com/cv/img/aicrop?access_token=".$token;
        $data = [
            'img'=>\CURLFile($path)
        ];
        if(!empty($options)){
            $data = array_merge($data,$options);
        }
        $response = Api::uploadCurl($data,$url);
        if(!$response){
            return false;
        }
        return json_decode($response,true);
    }
}