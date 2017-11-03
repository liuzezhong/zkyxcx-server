<?php
return array(
	//'配置项'=>'配置值'
    'URL_MODEL' => 0,    //PATHINFO模式为1，0为默认模式
    'LOAD_EXT_CONFIG' => 'db,predefined',
    'APP_ID' => 'wx25ea2cea38cdfd37',
    'APP_SECRET' => '60da1a9da38298f655f5ae2738612afc',
    'GRANT_TYPE' => 'authorization_code',
    'POST_URL_WEIXIN' => 'https://api.weixin.qq.com/sns/jscode2session?appid=APPID&secret=SECRET&js_code=JSCODE&grant_type=authorization_code',
    'ACCESS_TOKEN_URL' => 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential',
    'SMALL_PROGRAM_CODE_URL' => 'http://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=',
    'TYXD_URL' => 'https://api.mch.weixin.qq.com/pay/unifiedorder',  //微信支付统一下单地址
    'TYXD_MCH_ID' => '1374113102',  //微信支付商户号
    'TYXD_KEY' => 'F0DD18E107E1448133E10AAB9AA337E3', //微信商户平台(pay.weixin.qq.com)-->账户设置-->API安全-->密钥设置

    'WECHAT_SMALL_APPLICATION' => array(
        'APPID' => 'wx25ea2cea38cdfd37',
        'APPSECRET' => '60da1a9da38298f655f5ae2738612afc',
        'TYXD_MCH_ID' => '1374113102',  //微信支付商户号
    ),

);