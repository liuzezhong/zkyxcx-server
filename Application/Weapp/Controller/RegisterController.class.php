<?php
/**
 * Created by PhpStorm.
 * User: liuzezhong
 * Date: 2017/11/1
 * Time: 14:55
 */

namespace Weapp\Controller;


use Think\Controller;
use Think\Exception;

class RegisterController extends BaseController
{
    /**
     * 功能：获取用户报名信息
     */
    public function getRegisterInfo() {
        $register_id = I('post.register_id',0,'intval');
        if(!$register_id) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '报名ID不存在！',
            ));
        }

        // 用户报名信息
        $register = D('Register')->getRegisterByID($register_id);
        if(!$register) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '用户报名信息不存在！',
            ));
        }

        // 查找比赛信息
        $match = D('Match')->getMatchInfoByID($register['match_id']);
        if(!$match) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '比赛信息不存在！',
            ));
        }
        // 查找项目信息
        $category = D('Category')->getCategoryOfMatch($register['category_id']);
        if(!$category) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '比赛项目信息不存在！',
            ));
        }
        // 用户信息
        $user = D('Wxuser')->getUserInfoByID($register['user_id']);
        if(!$user) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '用户信息不存在！',
            ));
        }

        $is_team = 0;
        // 判断是否团队报名
        if($register['team_id'] != 0) {
            $is_team = 1;
            // 搜索团队信息
            $teamInfo = D('Team')->getTeamByID($register['team_id']);
            // 获取团队成员信息
            $teamUser = D('Teamuser')->getTeamUserByTeamID($teamInfo['team_id']);

            $leaderArray = array();
            $teamUserArray = array();
            foreach($teamUser as $key => $item) {
              if($item['is_leader'] == 1) {
                  $leaderArray = $item;
              }else {
                  $teamUserArray[] = $item;
              }
            }

            $teamInfo['leader'] = $leaderArray;
            $teamInfo['user'] = $teamUserArray;
        }
        $this->ajaxReturn(array(
            'status' => 1,
            'message' => '用户报名信息查找成功！',
            'match' => $match,
            'category' => $category,
            'user' => $user,
            'register' => $register,
            'teamInfo' => $teamInfo,
            'is_team' => $is_team,
        ));
    }

    public function checkRegisterMax() {
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

        // 比赛记录ID
        $match_id = I('post.match_id',0,'intval');
        $category_id = I('post.category_id',0,'intval');

        // 查找用户是否已经报名此项
        $category = D('Register')->getRegisterByID($category_id);
        if($category) {
            // 已经报名此项目，就算了
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '已经报名',
            ));
        } else {
            // 没有报名呢，判断一下子
            // 数据库查找该比赛用户报名的项目数
            $register_num = D('Register')->countRegisterByUserID($user['user_id'],$match_id);

            // 数据库搜索比赛信息
            $match = D('Match')->getMatchInfoByID($match_id);
            if(!$match) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '赛事数据不存在！',
                ));
            }

            if($match['register_max'] < $register_num) {
                $this->ajaxReturn(array(
                    'status' => 1,
                    'message' => '已经超过最大报名项',
                ));
            } else {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '未超过最大报名项',
                ));
            }
        }
    }

    /**
     * 功能：获取已经报名比赛的用户信息
     */
    public function getMatchRegister() {
        $registers = array();
        $match_id = I('post.match_id',0,'intval');
        if(!$match_id) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '比赛ID不存在！',
            ));
        }

        try {
            $registers = D('Register')->getRegisterByMatchID($match_id);

            if($registers) {
               foreach ($registers as $key => $item) {
                   $user = D('Wxuser')->getUserInfoByID($item['user_id']);
                   $category = D('Category')->getCategoryOfMatch($item['category_id']);
                   $registers[$key]['user'] = $user;
                   $registers[$key]['category'] = $category;
               }
            }
        } catch (Exception $exception) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => $exception->getMessage(),
            ));
        }
        $this->ajaxReturn(array(
            'status' => 1,
            'message' => '用户信息查找成功呃',
            'registers' => $registers,
        ));

    }
}