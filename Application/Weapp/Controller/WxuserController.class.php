<?php
/**
 * Created by PhpStorm.
 * User: liuzezhong
 * Date: 2017/10/24
 * Time: 14:04
 */

namespace Weapp\Controller;

use Think\Exception;

class WxuserController extends BaseController
{
    public function login() {
        // 获取登录凭证（code）
        $code = $_POST['code'];
        // 换取用户登录态信息
        $openArray = $this->getOpenID($code);
        // 生成3rd_session
        $sessionKey = createNonceStr();

        // 根据openid查找是否存在session的值
        $session = D('Sessionkey')->getSessionKeyByOpenID($openArray['openid']);
        // 不存在则新增记录
        if(!$session) {
            $sessionArray = array(
                'session3key' => $sessionKey,
                'openid' => $openArray['openid'],
                'session_key' => $openArray['session_key'],
                'unionid' => $openArray['unionid'],
                'gmt_create' => date('Y-m-d H:i:s',time()),
            );
            // 传递数据array到模型层，保存数据
            $saveSession = D('Sessionkey')->createSessionKey($sessionArray);
        }else {
            // 存在则更新记录
            $sessionArray = array(
                'session3key' => $sessionKey,
                'session_key' => $openArray['session_key'],
                'unionid' => $openArray['unionid'],
                'gmt_create' => date('Y-m-d H:i:s',time()),
            );
            // 传递openid和数据array到模型层，更新数据
            $updateSession = D('Sessionkey')->modifySessionKey($openArray['openid'],$sessionArray);
        }
        // 查找用户信息是否存在
        $user = D('Wxuser')->getUserByOpenID($openArray['openid']);
        if(!$user) {
            // 不存在则写入
            $openArray['gmt_create'] = date('Y-m-d H:i:s',time());
            $saveUserInfo = D('Wxuser')->createUserInfo($openArray);
        }

        $this->ajaxReturn($sessionKey);
    }

    /**
     * 功能：根据用户登陆凭证code获取用户登陆态信息
     * @param string $code
     * @return int|mixed
     */
    public function getOpenID($code = '') {
        if(!$code || $code == '') {
            return 0;
        }
        $apiUrl = 'https://api.weixin.qq.com/sns/jscode2session?appid='.C('WECHAT_SMALL_APPLICATION')['APPID'].'&secret='.C('WECHAT_SMALL_APPLICATION')['APPSECRET'].'&js_code='.$code.'&grant_type=authorization_code';
        return json_decode(curlGet($apiUrl),true);
    }

    /**
     * 功能：根据session3key数据库查找session信息并返回结果
     */
    public function checkSessionkey() {
        // 解析传递过来的session
        if($_POST['sessionKey']) {
            $sessionKey = json_decode($_POST['sessionKey']);
        }
        // 数据库查找session是否存在
        $session = D('Sessionkey')->getSessionKeyBySession3key($sessionKey);
        if($session) {
            $this->ajaxReturn(array(
                'status' => 1,
                'message' => 'session3key存在'
            ));
        }else {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => 'session3key不存在'
            ));
        }
    }

    /**
     * 功能：保存用户基本信息
     */
    public function saveWxUserInfo() {
        // 数据初始化
        $sessionKey = '';
        $userInfo = array();
        // 获取POST数据
        if($_POST['sessionKey']) {
            // 取出session3key换取openid
            $sessionKey = json_decode($_POST['sessionKey'],true);
            // 取出userinfo基本信息
            $userInfo = json_decode($_POST['userInfo'],true);
        } else {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => 'POST数据不存在'
            ));
        }
        try {
            // 根据session3key换取openid值
            $session = D('Sessionkey')->getSessionKeyBySession3key($sessionKey);
            if(!$session) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => 'session数据不能存在！',
                ));
            }
            // 根据openid更新用户基本信息
            $openid = $session['openid'];
            $userInfo['gmt_modified'] = date('Y-m-d H:i:s',time());
            $user = D('Wxuser')->saveUserInfoByOpenID($openid,$userInfo);
            // 判断并返回结果
            if(!$user) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '用户信息新增失败！',
                ));
            }
            $this->ajaxReturn(array(
                'status' => 1,
                'message' => '用户信息新增成功！',
            ));
        } catch (Exception $exception) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => $exception->getMessage(),
            ));
        }
    }

    /**
     * 功能：根据sessionKey换取用户信息
     */
    public function getUserInfo() {
        // 验证数据有效性
        if(!$_POST['sessionKey']) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => 'POST数据不存在！'
            ));
        }
        // 用sessionkey换取openid
        $openArray = $this->getOpenidBySessionKey($_POST['sessionKey']);
        if($openArray['status'] == 0) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => $openArray['message'],
            ));
        }
        // 数据库查找用户信息
        $user = D('Wxuser')->getUserByOpenID($openArray['openid']);
        // 返回结果
        if(!$user) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '用户信息不存在！',
            ));
        }
        $this->ajaxReturn(array(
            'status' => 1,
            'message' => '用户信息查找成功',
            'userInfo' => $user,
        ));
    }

    /**
     * 功能：列出用户已经报名的所有比赛信息
     */
    public function listUserMatch() {
        // 验证数据有效性
        if(!$_POST['sessionKey']) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => 'POST数据不存在！'
            ));
        }
        // 用sessionkey换取openid
        $openArray = $this->getOpenidBySessionKey($_POST['sessionKey']);
        if($openArray['status'] == 0) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => $openArray['message'],
            ));
        }
        // 数据库查找用户信息
        $user = D('Wxuser')->getUserByOpenID($openArray['openid']);
        if(!$user) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '用户信息不存在！',
            ));
        }

        // 查询用户报名记录
        $registers = D('Register')->listRegisterByUserID($user['user_id']);
        if($registers) {
            // 如果存在报名信息
            foreach ($registers as $key => $item) {
                // 查找比赛信息
                $match = D('Match')->getMatchInfoByID($item['match_id']);
                // 查找项目信息
                $category = D('Category')->getCategoryOfMatch($item['category_id']);

                // 查找项目图片信息
                $image = D('Image')->getImageOfMatch($match['match_id']);

                if($item['gmt_complete'] != null) {
                    // 已完成的赛事
                    $register_complete[$key] = $item;
                    $register_complete[$key]['match'] = $match;
                    $register_complete[$key]['category'] = $category;
                    $register_complete[$key]['image'] = $image;

                } else if($item['gmt_complete'] == null) {
                    // 未完成的赛事
                    $registers_new[$key] = $item;
                    $registers_new[$key]['match'] = $match;
                    $registers_new[$key]['category'] = $category;
                    $registers_new[$key]['image'] = $image;
                }
            }
        } else {
            $register_complete = array();
            $registers_new = array();
        }

        $this->ajaxReturn(array(
            'status' => 1,
            'message' => '比赛信息查找成功！',
            'register_complete' => $register_complete,
            'register_new' => $registers_new,
        ));

    }


}