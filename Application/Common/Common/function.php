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

