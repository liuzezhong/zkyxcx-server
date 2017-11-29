<?php
/**
 * Created by PhpStorm.
 * User: liuzezhong
 * Date: 2017/11/9
 * Time: 14:07
 */

namespace Weapp\Controller;


class WXBizDataCrypt
{
    private $appid;
    private $sessionKey;

    /**
     * 构造函数
     * @param $sessionKey string 用户在小程序登录后获取的会话密钥
     * @param $appid string 小程序的appid
     */
    public function __construct( $appid, $sessionKey)
    {
        $this->sessionKey = $sessionKey;
        $this->appid = $appid;
    }


    /**
     * 检验数据的真实性，并且获取解密后的明文.
     * @param $encryptedData string 加密的用户数据
     * @param $iv string 与用户数据一同返回的初始向量
     * @param $data string 解密后的原文
     *
     * @return int 成功0，失败返回对应的错误码
     */
    public function decryptData( $encryptedData, $iv)
    {
        if (strlen($this->sessionKey) != 24) {
            return 'encodingAesKey 非法';
        }
        $aesKey=base64_decode($this->sessionKey);


        if (strlen($iv) != 24) {
            return '-41002';
        }
        $aesIV=base64_decode($iv);

        $aesCipher=base64_decode($encryptedData);

        $result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $dataObj=json_decode( $result );
        if( $dataObj  == NULL )
        {
            return 'aes 解密失败';
        }
        if( $dataObj->watermark->appid != $this->appid )
        {
            return 'aes 解密失败';
        }
        return $result;
    }
}