<?php


namespace Xcrms\Wx\Miniprogram;


use Xcrms\Wx\Api;

/***
 * @todo 用户有关
 * Class User
 * @package Xcrms\Wx\Miniprogram
 */
class User extends MiniBase
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
        $response = Api::getCurl($url);
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
        $response = Api::getCurl($url);
        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode'] !=0){
            return false;
        }
        return $result['unionid'];
    }


}