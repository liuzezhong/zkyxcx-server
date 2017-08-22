<?php
/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-21
 * Time: 10:48
 */

namespace Home\Controller;


use Think\Controller;

class UserController extends Controller {

    public function index() {
        try {
            $skey = I('post.skey','','string,trim');
            $session_array = D('Session')->findSessionByCondition('skey',$skey);
            $openid = $session_array['openid'];
            $user_array = D('User')->findUserByCondition('openid',$openid);

            unset($user_array['openid']);

            $this->ajaxReturn(array(
                'userInfo' => $user_array,
            ));

        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}