<?php


namespace Xcrms\Wx;


use Xcrms\Wx\Enums\CurleError;

class Api
{
    const VERSION = 1.0;
    protected static $logger = NULL;

    /***
     * @todo 获取交互凭证
     * @param $appid
     * @param $appsecret
     * @return bool|mixed
     */
    public static function getAccessToken($appid,$appsecret)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
        $response = self::getCurl($url);
        if(!$response){
            return false;
        }
        return json_decode($response,true);
    }

    /***
     * @todo 设置日志引擎
     * @param $logger
     */
    public static function setLogger($logger)
    {
        if(!isset(self::$logger))
        {
            self::$logger = $logger;
        }
    }

    /***
     * @todo 获取日志引擎
     * @return null
     */
    public static function getLogger()
    {
        return self::$logger;
    }

    /***
     * @todo 下载
     * @param $url
     * @param $path
     * @param int $timeout
     * @return bool
     */
    public static function downloadCurl($url,$path,$timeout=5)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $content = curl_exec($ch);
        curl_close($ch);
        if(!$content){
            return false;
        }
        file_put_contents($path, $content);
        return true;
    }

    /***
     * @todo 上传
     * @param $params
     * @param $url
     * @return bool|string
     */
    public static function uploadCurl($params, $url)
    {
        $header = array('Content-Type: multipart/form-data');
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;

    }
    /***
     * @todo GET请求
     * @param $url
     * @param int $second
     * @return bool|string
     */
    public static function getCurl($url, $second=2)
    {
        if(isset(self::$logger))
        {
            self::$logger->debug($url);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);

        //返回结果
        if($data){
            if(isset(self::$logger))
            {
                self::$logger->debug(json_encode($data));
            }
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            $msg = [
                'errorno'=>$error,
                'errormsg'=>CurleError::getMsg($error)
            ];
            if(isset(self::$logger))
            {
                self::$logger->error(json_encode($msg));
            }
            return false;
        }
    }
    /**
     * @todo curl post请求
     * @param $xml
     * @param $url
     * @param int $second
     * @param bool $useCert
     * @param string $sslCertPath
     * @param string $sslKeyPath
     * @return bool|string
     */
    public static function postCurl($data, $url, $second = 2, $useCert = false, $sslCertPath='', $sslKeyPath='')
    {
        $json_data = json_encode($data);
        if(isset(self::$logger))
        {
            self::$logger->debug($json_data);
        }

        $ch = curl_init();
        $curlVersion = curl_version();
        $ua = "WXPay/".self::VERSION." (".PHP_OS.") PHP/".PHP_VERSION." CURL/".$curlVersion['version'];
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);//严格校验
        curl_setopt($ch,CURLOPT_USERAGENT, $ua);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if($useCert == true){
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            //证书文件请放入服务器的非web目录下
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT, $sslCertPath);
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY, $sslKeyPath);
        }
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        //运行curl
        $data = curl_exec($ch);

        //返回结果
        if($data){
            if(isset(self::$logger))
            {
                self::$logger->debug(json_encode($data));
            }
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            $msg = [
                'errorno'=>$error,
                'errormsg'=>CurleError::getMsg($error)
            ];
            if(isset(self::$logger))
            {
                self::$logger->error(json_encode($msg));
            }
            return false;
        }
    }

    /**
     * @todo curl post请求
     * @param $xml
     * @param $url
     * @param int $second
     * @param bool $useCert
     * @param string $sslCertPath
     * @param string $sslKeyPath
     * @return bool|string
     */
    public static function postXmlCurl($xml, $url, $second = 2, $useCert = false, $sslCertPath='', $sslKeyPath='')
    {
        if(isset(self::$logger))
        {
            self::$logger->debug($xml);
        }

        $ch = curl_init();
        $curlVersion = curl_version();
        $ua = "WXPay/".self::VERSION." (".PHP_OS.") PHP/".PHP_VERSION." CURL/".$curlVersion['version'];
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);//严格校验
        curl_setopt($ch,CURLOPT_USERAGENT, $ua);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if($useCert == true){
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            //证书文件请放入服务器的非web目录下
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT, $sslCertPath);
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY, $sslKeyPath);
        }
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);

        //返回结果
        if($data){
            if(isset(self::$logger))
            {
                self::$logger->debug(json_encode($data));
            }
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            $msg = [
                'errorno'=>$error,
                'errormsg'=>CurleError::getMsg($error)
            ];
            if(isset(self::$logger))
            {
                self::$logger->error(json_encode($msg));
            }
            return false;
        }
    }
}