<?php
/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-07
 * Time: 12:07
 */

namespace Home\Controller;


use Think\Controller;
use Think\Exception;

class LoginController extends Controller {
    public function index() {
        if($_POST) {
            $userinfo = json_decode(I('post.res_info','',''),true);
            $url = C('POST_URL_WEIXIN');

            //定义传递的参数数组；
            $data = array(
                'js_code' => I('post.res_code','','trim,string'),
                'appid' => C('APP_ID'),
                'secret' => C('APP_SECRET'),
                'grant_type' => C('GRANT_TYPE'),
            );

            //定义返回值接收变量；
            $httpstr = D('Common')->http($url, $data, 'POST', array("Content-type: text/html; charset=utf-8"));
            $decode_http = json_decode($httpstr,true);
            $session_key = $decode_http['session_key'];
            $openid = $decode_http['openid'];

            //生成3rd_session
            $skey = md5(time() . mt_rand(1,1000000));

            try {
                $is_user = D('Rank')->findUserByCondition('openid',$openid);
                //不存在用户信息，写入用户信息
                if(!$is_user) {
                    //写入用户信息
                    $userData = array(
                        'openid' => $openid,
                        'username' => $userinfo['nickName'],
                        'avatarurl' => $userinfo['avatarUrl'],
                        'rankmoney' => 0,
                        'create_time' => time(),
                    );
                    $res_add = D('Rank')->addOneUserInfo($userData);
                    if(!$res_add) {
                        $this->ajaxReturn(array(
                            'status' => 0,
                            'message' => '用户信息写入失败'
                        ));
                    }

                    //写入session信息
                    $sessionData = array(
                        'openid' => $openid,
                        'session_key' => $session_key,
                        'skey' => $skey,
                        'create_time' => time(),
                        'last_visit_time' => time(),
                    );
                    $res_session = D('Session')->addOneSessionInfo($sessionData);
                    if(!$res_session) {
                        $this->ajaxReturn(array(
                            'status' => 0,
                            'message' => '会话信息写入失败'
                        ));
                    }
                } else if($is_user) {
                    //存在用户信息，则更新session表
                    $sessionData = array(
                        'session_key' => $session_key,
                        'skey' => $skey,
                        'last_visit_time' => time(),
                    );
                    $res_session = D('Session')->updataOneSessionInfo($openid,$sessionData);
                    if(!$res_session) {
                        $this->ajaxReturn(array(
                            'status' => 0,
                            'message' => '会话信息更新失败'
                        ));
                    }
                }

                $this->ajaxReturn(array(
                    'status' => 1,
                    'data' => $skey
                ));
            } catch (Exception $exception) {
                $this->ajaxReturn($exception->getMessage());
            }
        }
    }

    public function checksession() {
        if($_POST) {
            $skey = I('post.skey','','trim,string');
            //判断是否存在这个skey
            $is_skey = D('Session')->findSessionByCondition('skey',$skey);
            if($is_skey) {
                $this->ajaxReturn(array(
                    'status' => 1,
                    'data' => $skey
                ));
            }else if(!$is_skey) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '登录信息失效重新登录'
                ));
            }
        }
    }

    public function getUserInfo() {
        if($_POST) {
            $skey = I('post.skey','','trim,string');
            $session_array = D('Session')->findSessionByCondition('skey',$skey);
            $openid = $session_array['openid'];
            $user_array = D('Rank')->findUserByCondition('openid',$openid);
            unset($user_array['openid']);
            $this->ajaxReturn($user_array);
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