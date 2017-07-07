<?php
/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-07
 * Time: 12:07
 */

namespace Home\Controller;


use Think\Controller;

class LoginController extends Controller {
    public function index() {
        if($_POST) {
            $js_code = I('post.res_code','','trim,string');
            $appid = C('APP_ID');
            $secret = C('APP_SECRET');
            $grant_type = C('GRANT_TYPE');

            $url = C('POST_URL_WEIXIN');
            //定义传递的参数数组；
            $data['js_code'] = $js_code;
            $data['appid'] = $appid;
            $data['secret'] = $secret;
            $data['grant_type'] = $grant_type;
            //定义返回值接收变量；
            $httpstr = D('Common')->http($url, $data, 'POST', array("Content-type: text/html; charset=utf-8"));
            $this->ajaxReturn($httpstr);
        }
    }
    public function decryptUserInfo() {

        $sessionKey = I('post.sessionKey','','trim,string');
        $appid = C('APP_ID');
        $encryptedData = I('post.encryptedData','','trim,string');
        $iv = I('post.iv','','trim,string');

        $data = array();

        if (strlen($sessionKey) != 24) {
            return -41001; //$IllegalAesKey
        }
        $aesKey=base64_decode($sessionKey);


        if (strlen($iv) != 24) {
            return -41002; //$IllegalIv
        }
        $aesIV=base64_decode($iv);

        $aesCipher=base64_decode($encryptedData);


        $result = D('Login')->decrypt($aesKey,$aesCipher,$aesIV);

        if ($result[0] != 0) {
            return $result[0];
        }

        $dataObj=json_decode( $result[1] );
        if( $dataObj  == NULL )
        {
            return -41003; //$IllegalBuffer
        }
        if( $dataObj->watermark->appid != $appid )
        {
            return -41003; //$IllegalBuffer
        }
        $data = $result[1];
        $this->ajaxReturn($data);
    }
}