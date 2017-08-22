<?php
/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-21
 * Time: 10:48
 */

namespace Activity\Controller;


use Think\Controller;

class UserController extends Controller {

    public function index() {
        try {
            $skey = json_decode(I('post.skey','',''),true);
            $session_array = D('Session')->findSessionByConditionArray($skey);
            $openid = $session_array['openid'];
            $user_array = D('User')->findUserByCondition('openid',$openid);

            $enrol = D('enrol')->getSomeEnrolByUserID($user_array['user_id']);
            $user_tasks = array();
            foreach ($enrol as $key => $value) {
                $one_tasks = D('Activity')->getOneTasksByID($value['tasks_id']);
                $one_tasks['start_time'] = date('Y-m-d',$one_tasks['start_time']);
                if($value['complete'] == 0) {
                    $user_tasks[] = $one_tasks;
                }else if($value['complete'] == 1) {
                    $user_tasks_already[] = $one_tasks;
                }
            }

            $ranks = D('User')->selectAllRank();
            foreach($ranks as $key => $value) {
                if($user_array['openid'] == $value['openid']) {
                    $user_array['rankNumber'] = $key + 1;
                }

            }

            unset($user_array['openid']);

            $userTasksStatus = $user_tasks ? 1 : 0;
            $userTasksAlreadyStatus = $user_tasks_already ? 1 : 0;
            $this->ajaxReturn(array(
                'userInfo' => $user_array,
                'userTasksStatus' => $userTasksStatus,
                'userTasks' => $user_tasks,
                'userTasksAlready' => $user_tasks_already,
                'userTasksAlreadyStatus' => $userTasksAlreadyStatus,
            ));

        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    public function addRankMoney() {
        $skey = json_decode(I('post.skey','',''),true);
        $reward = I('post.reward',0,'intval');

        try {
            $session_array = D('Session')->findSessionByConditionArray($skey);
            $openid = $session_array['openid'];
            $user_array = D('User')->findUserByCondition('openid',$openid);
            if($user_array) {
                $reward = $reward + $user_array['rankmoney'];
                $user = D('User')->updateUserRankMoney($user_array['user_id'],$reward);
                if(!$user) {
                    $this->ajaxReturn(array(
                        'status' => 0,
                        'message' => '铠币领取失败！',
                    ));
                }
                $this->ajaxReturn(array(
                    'status' => 1,
                    'message' => '铠币领取成功！',
                    'user' => $user,
                ));
            }else {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '用户信息不存在！',
                ));
            }

        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    public function rank() {
        try {
            $skey = json_decode(I('post.skey','',''),true);
            $session_array = D('Session')->findSessionByConditionArray($skey);
            $openid = $session_array['openid'];
            $user_array = D('User')->findUserByCondition('openid',$openid);


            $ranks = D('User')->selectAllRank();
            $proportion = $ranks[0]['rankmoney'];
            foreach($ranks as $key => $value) {
                $ranks[$key]['userName'] = $value['nick_name'];
                unset($ranks[$key]['username']);

                $ranks[$key]['rankMoney'] = $value['rankmoney'];
                unset($ranks[$key]['rankmoney']);

                $ranks[$key]['userAvatarUrl'] = $value['avatarurl'];
                unset($ranks[$key]['avatarurl']);

                $ranks[$key]['percentage'] = number_format($value['rankmoney']/$proportion,2)*100 .'%';

                if($user_array['openid'] == $value['openid']) {
                    $user_array['rankNumber'] = $key + 1;
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

    public function saveUserInfo() {
        //用户信息
        $userInfo = json_decode(I('post.userInfo','',''),true);
        //session信息
        $sessionArray = json_decode(I('post.sessionArray','',''),true);
        $session = D('Session')->findSessionByConditionArray($sessionArray);

        if($session) {
            //如果存在对应的session数据
            //写入用户信息

            //判断用户是否存在
            $user = D('User')->findUserByCondition('openid',$session['openid']);

            if($user) {
                //更新用户信息
                $updataData = array(
                    'avatarurl' => $userInfo['avatarUrl'],
                    'nick_name' => $userInfo['nickName'],
                );
                $user = D('User')->updateUserInfoByOpenID($session['openid'],$updataData);
                if($user) {
                    $this->ajaxReturn(array(
                        'status' => 1,
                        'message' => '用户信息更新成功！',
                    ));
                }
            }else {
                //不存在用户信息，写入用户信息
                $userData = array(
                    'openid' => $session['openid'],
                    'avatarurl' => $userInfo['avatarUrl'],
                    'nick_name' => $userInfo['nickName'],
                    'rankmoney' => 0,
                    'user_type' => 0,
                    'user_status' => 0,
                    'create_time' => time(),
                );
                $res_add = D('User')->addOneUserInfo($userData);
                if($res_add) {
                    $this->ajaxReturn(array(
                        'status' => 1,
                        'message' => '用户信息新建成功！'
                    ));
                }
            }

        }

    }

}