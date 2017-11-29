<?php
/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-27
 * Time: 10:59
 */

function arrayToXML($arr){
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
 * 获取签名算法
 */
function signature($arr = array()){
    //print_r($arr);
    //1.1 将集合M内非空参数值的参数按照参数名ASCII码从小到大排序（字典序）
    ksort($arr);
    //1.2 使用URL键值对的格式（即key1=value1&key2=value2…）拼接成字符串stringA
    $stringA = '';
    foreach ($arr as $key => $vaule) {
        if($vaule != '' && !is_null($vaule))
            $stringA = $stringA . $key . '=' . $vaule .'&';
    }
    //1.3 在stringA最后拼接上key得到stringSignTemp字符串
    $stringSignTemp = $stringA . 'key=' . C('TYXD_KEY');

    //print_r($stringSignTemp);
    //1.4 对stringSignTemp进行MD5运算
    $sign = md5($stringSignTemp);
    //1.5 将得到的字符串所有字符转换为大写，得到sign值signValue
    $signValue = strtoupper($sign);

    //print_r($signValue);

    return $signValue;
}

/**
 * 功能：服务器内发送get请求
 * @param $url
 * @return mixed
 */
function curlGet($url) {
    //初始化
    $ch = curl_init();
    //设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    //执行并获取HTML文档内容
    $output = curl_exec($ch);
    //释放curl句柄
    curl_close($ch);
    //打印获得的数据
    return $output;
}

/**
 * 功能： 生成16位随机字符串
 * @param int $length
 * @return string
 */
function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}

/**
 * 功能：生成制定内容的二维码
 * @param string $value
 * @return int|string
 */
function generateQrCode($value = '') {
    //二维码内容
    if(!$value) {
        return 0;
    }
    vendor("Qrcode.phpqrcode");

    $errorCorrectionLevel = 'Q';//容错级别
    $matrixPointSize = 6;//生成图片大小

    //生成二维码图片
    $object = new \QRcode();
    ob_clean();//这个一定要加上，清除缓冲区
    $filename = "Public/image/enrol/".$value.".png";
    $object->png($value, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

    //生成二维码地址
    $codeUrl = "http://".$_SERVER['HTTP_HOST'].'/'.$filename;

    return $codeUrl;
}
