<?php


namespace Xcrms\Wx\Miniprogram;


use Xcrms\Wx\Api;

class User extends MiniBase
{
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