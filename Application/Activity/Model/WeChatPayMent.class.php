<?php
/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-28
 * Time: 13:55
 */

namespace Activity\Model;


class WeChatPayMent {
    private $appid = '';  //小程序ID
    private $mch_id = '';  //商户号
    private $trade_type = '';  //交易类型
    private $notify_url = '';  //接收微信支付异步通知回调地址，通知url必须为直接可访问的url，不能携带参数


    public function __construct($appid= '',$mch_id = '',$trade_type = 'JSAPI',$notify_url='https://api.mch.weixin.qq.com/pay/unifiedorder') {
        $this->appid = $appid;
        $this->mch_id = $mch_id;
        $this->trade_type = $trade_type;
        $this->notify_url = $notify_url;
    }

    /**
     * 获取sign签名加密
     * @param array $arr
     * @return string
     */
    private function getSignature($signArray = array()){
        //1 将集合M内非空参数值的参数按照参数名ASCII码从小到大排序（字典序）
        ksort($signArray);
        //2 使用URL键值对的格式（即key1=value1&key2=value2…）拼接成字符串stringA
        $stringA = '';
        foreach ($signArray as $key => $vaule) {
            if($vaule != '' && !is_null($vaule))
                $stringA = $stringA . $key . '=' . $vaule .'&';
        }
        //3 在stringA最后拼接上key得到stringSignTemp字符串
        $stringSignTemp = $stringA . 'key=' . C('TYXD_KEY');
        //4 对stringSignTemp进行MD5运算
        $sign = md5($stringSignTemp);
        //5 将得到的字符串所有字符转换为大写，得到sign值signValue
        $signValue = strtoupper($sign);
        //6 返回sign签名结果
        return $signValue;
    }

    /**
     * 将数组转换为XML格式
     * @param $arr
     * @return string
     */
    private function arrayToXML($arr = array()){
        $xml = "<xml>";
        foreach ($arr as $key=>$val){
            if(is_array($val)){
                $xml.="<".$key.">".arrayToXml($val)."</".$key.">";
            }else{
                $xml.="<".$key.">".$val."</".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    /**
     * 将XML转换为数组格式
     * @param string $xml
     * @return mixed
     */
    private function xmlToArray($xml = '') {
        $arr = json_decode( json_encode( simplexml_load_string($xml,'SimpleXMLElement',LIBXML_NOCDATA)),true);
        return $arr;
    }

    /**
     * 模拟请求HTTP
     * @param $url
     * @param $params
     * @param string $method
     * @param array $header
     * @param bool $multi
     * @return mixed
     */
    private function HTTP($url, $params, $method = 'GET', $header = array(), $multi = false){
        $opts = array(
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER     => $header
        );
        /* 根据请求类型设置特定参数 */
        switch(strtoupper($method)){
            case 'GET':
                //$opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                $opts[CURLOPT_URL] = $url;
                break;
            case 'POST':
                //判断是否传输文件
                $params = $multi ? $params : http_build_query($params);
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            default:
                throw new Exception('不支持的请求方式！');
        }
        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data  = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if($error)
            throw new Exception('请求发生错误：' . $error);
        return  $data;
    }

    /**
     * 获取发起微信支付所需的必要参数
     * @param int $total_fee
     * @param string $body
     * @param string $openid
     * @param string $attach
     * @return array
     */
    public function getRequestPayment($total_fee = 0,$body = '',$openid = '') {
        $nonce_str = md5(time() . mt_rand(1,1000000));  //随机字符串 调用随机数函数生成，将得到的值转换为字符串
        $out_trade_no = md5(time() . mt_rand(1,1000000));  //商户订单号

        $signData = array(
            'appid' => $this->appid,  //小程序ID
            'mch_id' => $this->mch_id,  //商户号
            'nonce_str' => $nonce_str,  //随机字符串 调用随机数函数生成，将得到的值转换为字符串
            'body' => $body,  //商品简单描述，该字段须严格按照规范传递，具体请见参数规定
            'out_trade_no' => $out_trade_no,  //商户订单号
            'total_fee' => $total_fee,  //订单总金额，单位为分
            'spbill_create_ip' => '117.84.239.13',  //APP和网页支付提交用户端ip，Native支付填调用微信支付API的机器IP。
            'notify_url' => $this->notify_url,  //接收微信支付异步通知回调地址，通知url必须为直接可访问的url，不能携带参数
            'trade_type' => $this->trade_type,  //交易类型
            'openid' => $openid,  //用户身份标识
        );
        // 获取sign签名算法
        $signValue = $this->getSignature($signData);
        // 将sign签名值写入数组
        $signData['sign'] = $signValue;
        // 将数据转换为XML格式
        $postDataXML = $this->arrayToXML($signData);
        // 请求微信支付统一下单API
        $tongyixiadanXML = $this->HTTP(C('TYXD_URL'),$postDataXML,'POST',array("Content-Type: text/html"),true);
        // 将结果XML转换为Array
        $tongyixiadan = $this->xmlToArray($tongyixiadanXML);
        // 打包支付签名参数数据
        $paySignData = array(
            'appId' => $this->appid,  //小程序ID
            'timeStamp' => time(),   //时间戳
            'nonceStr' => $tongyixiadan['nonce_str'],  //随机字符串
            'package' => 'prepay_id=' . $tongyixiadan['prepay_id'],  //数据包
            'signType' => 'MD5', //签名算法，暂支持 MD5
        );
        // 换去支付签名sign值
        $paySign = signature($paySignData);

        $result = array(
            'paySign' => $paySign,   //支付签名
            'packages' => 'prepay_id=' . $tongyixiadan['prepay_id'],  //统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=*
            'nonceStr' => $tongyixiadan['nonce_str'],  //随机字符串，长度为32个字符以下
            'timeStamp' => time(),  //时间戳从1970年1月1日00:00:00至今的秒数,即当前的时间
            'out_trade_no' => $out_trade_no,  //商户订单号
        );

        return $result;
    }
}