<?php
/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-27
 * Time: 10:25
 */

namespace Activity\Controller;


use Think\Controller;
use Think\Model;

import('@.Model.WeChatPayMent');

class WxpayController extends   Controller {

    public function index() {
        $nonce_str = md5(time() . mt_rand(1,1000000));  //随机字符串 调用随机数函数生成，将得到的值转换为字符串
        $postData = array(
            'mch_id' => C('TYXD_MCH_ID'),  //商户号
            'appid' => C('APP_ID'),  //小程序ID
            'nonce_str' => $nonce_str,  //随机字符串 调用随机数函数生成，将得到的值转换为字符串
            'body' => '中铠街区-比赛报名费',  //商品简单描述，该字段须严格按照规范传递，具体请见参数规定
            'out_trade_no' => md5(time() . mt_rand(1,1000000)),  //商户订单号
            'total_fee' => 1,  //订单总金额，单位为分
            'spbill_create_ip' => '117.84.239.13',  //APP和网页支付提交用户端ip，Native支付填调用微信支付API的机器IP。
            'notify_url' => 'https://api.mch.weixin.qq.com/pay/unifiedorder',  //接收微信支付异步通知回调地址，通知url必须为直接可访问的url，不能携带参数
            'trade_type' => 'JSAPI',  //交易类型
            'attach' => '篮球比赛',  //附加数据
            'openid' => 'oUpv60E98MOGnr9Z9Ele1UYroiLQ',  //用户身份标识
        );

        //获取sign签名算法
        $signValue = signature($postData);
        $postData['sign'] = $signValue;
        //将数据转换我xml格式
        $postDataXML = arrayToXML($postData);
        //请求微信API
        $tyxd = D('Common')->http(C('TYXD_URL'),$postDataXML,'POST',array("Content-Type: text/html"),true);
        //将结果xml转换为array
        $tyxd_json = json_decode( json_encode( simplexml_load_string($tyxd,'SimpleXMLElement',LIBXML_NOCDATA)),true);


        $paySignData = array(
            'appId' => C('APP_ID'),  //小程序ID
            'timeStamp' => time(),   //时间戳
            'nonceStr' => $tyxd_json['nonce_str'],  //随机字符串
            'package' => 'prepay_id=' . $tyxd_json['prepay_id'],  //数据包
            'signType' => 'MD5', //签名算法，暂支持 MD5
        );

        $paySign = signature($paySignData);
        $this->ajaxReturn(array(
            'paySign' => $paySign,
            'packages' => 'prepay_id=' . $tyxd_json['prepay_id'],
            'nonceStr' => $tyxd_json['nonce_str'],
            'timeStamp' => time(),
        ));

    }

    public function getRequestPayment() {

        $skey = json_decode(I('post.skey','',''),true);
        $total_fee = I('post.total_fee','','trim,string');
        $body = I('post.body','','trim,string');

        $session_array = D('Session')->findSessionByConditionArray($skey);

        $wechatPay = new \Activity\Model\WeChatPayMent(C('APP_ID'),C('TYXD_MCH_ID'));
        $requestPayment = $wechatPay->getRequestPayment($total_fee,$body,$session_array['openid']);

        $this->ajaxReturn($requestPayment);
    }

    public function wxcallback() {
        print_r($_REQUEST);
    }

    public function setPayStatus() {
        $skey = json_decode(I('post.skey','',''),true);
        $session_array = D('Session')->findSessionByConditionArray($skey);
        $user_array = D('User')->findUserByCondition('openid',$session_array['openid']);
        $total_fee = I('post.total_fee','','trim,string');
        $tasks_id = I('post.tasks_id',0,'intval');
        $project_id = I('post.project_id',0,'intval');
        $out_trade_no = I('post.out_trade_no','','trim,string');

        $payrecordData = array(
            'total_fee' => $total_fee / 100,
            'open_id' => $session_array['openid'],
            'out_trade_no' => $out_trade_no,
            'tasks_id' => $tasks_id,
            'project_id' => $project_id,
            'create_time' => time(),
        );
        $payrecord = D('Payrecord')->addOnePayrecord($payrecordData);
        $enrol = D('Enrol')->changePayStatus($tasks_id,$project_id,$user_array['user_id'],1);
    }
}