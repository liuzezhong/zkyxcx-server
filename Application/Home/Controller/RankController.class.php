<?php
/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-06
 * Time: 15:45
 */

namespace Home\Controller;


use Think\Controller;
use Think\Exception;

class RankController extends Controller {
    public function index() {
        try {
            $skey = I('post.skey','','string,trim');
            $session_array = D('Session')->findSessionByCondition('skey',$skey);
            $openid = $session_array['openid'];
            $user_array = D('Rank')->findUserByCondition('openid',$openid);


            $ranks = D('rank')->selectAllRank();
            $proportion = $ranks[0]['rankmoney'];
            foreach($ranks as $key => $value) {
                if(!$value['username'] || $value['username'] == null || $value['username'] == 'null') {
                    unset($ranks[$key]);
                    continue;
                }
                $ranks[$key]['userName'] = $value['username'];
                unset($ranks[$key]['username']);

                $ranks[$key]['rankMoney'] = $value['rankmoney'];
                unset($ranks[$key]['rankmoney']);

                $ranks[$key]['userAvatarUrl'] = $value['avatarurl'];
                unset($ranks[$key]['avatarurl']);

                $ranks[$key]['percentage'] = number_format($value['rankmoney']/$proportion,2)*100 .'%';

                if($user_array['openid'] == $value['openid']) {
                    $user_array['rankNumber'] = $key;
                }
                unset($ranks[$key]['openid']);
            }
            unset($user_array['openid']);

            $this->ajaxReturn(array(
                'ranks' => $ranks,
                'userInfo' => $user_array,
            ));

        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }

    }
}