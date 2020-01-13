<?php

namespace Xcrms\Wx\Miniprogram;

use Xcrms\Wx\Api;

/***
 * @todo 消息通知有关
 * Class Message
 * @package Xcrms\Wx\Miniprogram
 */
class Message extends MiniBase
{

    public static function addTpl($token,$id,$keywods)
    {
        if(empty($token) || empty($id) || empty($keywods)){
            return false;
        }
        $url = "https://api.weixin.qq.com/cgi-bin/wxopen/template/add?access_token=".$token;
        $data = [
            'id'=>$id,
            'keyword_id_list'=>$keywods
        ];
        $response = Api::postCurl($data, $url);

        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode'] !=0){
            return false;
        }
        return $result;

    }

    public static function delTpl($token,$id)
    {
        if(empty($token) || empty($id))
        {
            return false;
        }
        $url = "https://api.weixin.qq.com/cgi-bin/wxopen/template/del?access_token=".$token;
        $data = [
            'template_id'=>$id
        ];
        $response = Api::postCurl($data, $url);

        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode'] !=0){
            return false;
        }
        return $result;
    }

    public static function send($token,$id,$openid,$options)
    {
        if(empty($token) || empty($id) || empty($openid)){
            return false;
        }
        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token;
        $data = [
            'template_id'=>$id,
            'touser'=>$openid,
        ];
        if(!empty($options['page'])){
            $data['page'] = $options['page'];
        }
        if(!empty($options['form_id'])){
            $data['form_id'] = $options['form_id'];
        }
        if(!empty($options['data'])){
            $data['data'] = $options['data'];
        }

        if(!empty($options['emphasis_keyword'])){
            $data['emphasis_keyword'] = $options['emphasis_keyword'];
        }
        $response = Api::postCurl($data, $url);

        if(!$response){
            return false;
        }
        $result = json_decode($response,true);
        if($result['errcode'] !=0){
            return false;
        }
        return $result;
    }
}