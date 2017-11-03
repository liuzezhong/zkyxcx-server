<?php
/**
 * 功能：基类Controller
 * Created by PhpStorm.
 * User: liuzezhong
 * Date: 2017/10/23
 * Time: 11:20
 */

namespace Weapp\Controller;

use Think\Controller;

class BaseController extends Controller
{
    /**
     * 功能：用sessionKey换取openid
     * @param array $postSession
     * @return array
     */
    public function getOpenidBySessionKey($postSession = '') {
        if(!$postSession) {
            return array(
                'status' => 0,
                'message' => 'postSession信息不存在',
            );
        }
        // 将json数据解析
        $sessionKey = json_decode($postSession);
        // 数据库查找session记录
        $session = D('Sessionkey')->getSessionKeyBySession3key($sessionKey);
        if(!$session) {
            return array(
                'status' => 0,
                'message' => 'session信息不存在'
            );
        }
        // 数组中取出openid
        $openID = $session['openid'];
        return array(
            'status' => 1,
            'message' => 'openid查找成功！',
            'openid' => $openID,
        );
    }
}