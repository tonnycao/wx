<?php


namespace Xcrms\Wx\Api;


use Xcrms\Wx\Curl;

/***
 * @todo 用户有关
 * Class User
 * @package Xcrms\Wx\Miniprogram
 */
class User extends Base
{
    /***
     * @todo 获取用户openid
     * @param $appid
     * @param $appsecret
     * @param $jscode
     * @return bool|mixed
     */
    public static function code2Session($appid,$appsecret,$jscode)
    {
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$appsecret."&js_code=".$jscode."&grant_type=authorization_code";
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

    /***
     * @todo 获取用户的unionid
     * @param $access_token
     * @param $openid
     * @param $param
     * @return bool
     */
    public static function getPaidUnionid($access_token,$openid,$param)
    {
        $url = "https://api.weixin.qq.com/wxa/getpaidunionid?access_token=".$access_token."&openid=".$openid;
        if(!empty($param['transaction_id'])){
            $url .='&transaction_id='.$param['transaction_id'];
        }elseif(!empty($param['mch_id'])&& !empty($param['out_trade_no'])){
            $url .='&mch_id='.$param['mch_id'].'&out_trade_no='.$param['out_trade_no'];
        }
        $response = Curl::getCurl($url);
        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode'] !=0){
            return false;
        }
        return $result['unionid'];
    }

    public static function creatTag($token,$name)
    {
        $url = " https://api.weixin.qq.com/cgi-bin/tags/create?access_token=".$token;
        $data = [
            'tag'=>$name
        ];
        $response = Curl::postCurl($url,$data);
        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode']==0){
            return $result;
        }
        return false;
    }

    public static function getInfo($token,$openid,$lang='zh_CN')
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$token."&openid=".$openid."&lang=".$lang;
        $response = Curl::getCurl($url);
        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode']==0){
            return $result;
        }
        return false;
    }

    public static function batchGetInfo($token,$openids)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token=".$token;
        $users = [];
        foreach ($openids as $openid)
        {
            $users[] = [
                'openid'=>$openid,
                'lang'=>'zh_CN'
            ];
        }
        $data = [
            'user_list'=>$users
        ];
        $response = Curl::postCurl($data,$url,5);
        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode']==0){
            return $result;
        }
        return false;
    }

    public static function getList($token,$openid='')
    {
        if(empty($openid)){
            $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$token;
        }else{
            $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$token."&next_openid=".$openid;
        }

        $response = Curl::getCurl($url,5);
        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode']==0){
            return $result;
        }
        return false;
    }

    public static function getBlack($token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/tags/members/getblacklist?access_token=".$token;
        $response = Curl::getCurl($url,5);
        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode']==0){
            return $result;
        }
        return false;
    }
}