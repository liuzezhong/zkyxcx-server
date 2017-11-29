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
                'gmt_modified' => date('Y-m-d H:i:s',time()),
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
            $sessionKey = json_decode($_POST['sessionKey'],true);
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

        // 数据库查找团队信息
        $teams = D('Team')->listTeamByUserID($user['user_id']);
        $this->ajaxReturn(array(
            'status' => 1,
            'message' => '用户信息查找成功',
            'userInfo' => $user,
            'teams' => $teams,
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

    /**
     * 功能：创建团队信息
     */
    public function createTeam() {
        if(!$_POST['sessionKey'] || !$_POST['formArray']) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => 'post数据不存在',
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

        // 获取form内容并进行json解析
        $formArray = json_decode($_POST['formArray'],true);

        // 取出团队的信息
        $teamArray = array(
            'team_name' => $formArray['team_name'],
            'user_id' => $user['user_id'],
        );

        // 取出队长的数据
        $leaderArray = array(
            'real_name' => $formArray['leader_name'],
            'phone_number' => $formArray['leader_phone'],
            'id_card' => $formArray['leader_idcard'],
            'real_sex' => $formArray['leader_sex'],
            'is_leader' => 1,
            'gmt_create' => date('Y-m-d H:i:s',time()),
        );

        // 删除无用数据
        unset($formArray['leader_name']);
        unset($formArray['leader_phone']);
        unset($formArray['leader_idcard']);
        unset($formArray['leader_sex']);
        unset($formArray['team_name']);

        // 整理成员数据
        $newFormArray = array();
        foreach ($formArray as $key => $item) {
            $newKey = $key[strlen(trim($key))-1];
            $newFormArray[$newKey][substr($key,0,strlen(trim($key))-1)] = $item;
        }

        try {
            $team_id = I('post.team_id',0,'intval');

            if($team_id) {
                // 已经存在team信息，是修改信息，不是新增信息

                $team = D('Team')->getTeamByID($team_id);
                if($team['team_name'] != $teamArray['team_name']) {
                    $teamName = D('Team')->getTeamByTeamName($teamArray['team_name'],$user['user_id']);
                    if($teamName) {
                        $this->ajaxReturn(array(
                            'status' => 0,
                            'message' => '已有此团队名称',
                        ));
                    }
                }
                // 团队信息更新
                $teamArray['gmt_modifiy'] = date('Y-m-d H:i:s',time());
                $teamUpdata = D('Team')->updataTeam($team_id,$teamArray);
                if(!$teamUpdata) {
                    $this->ajaxReturn(array(
                        'status' => 0,
                        'message' => '团队信息更新失败',
                    ));
                }

                // 删除所有团队成员信息
                $deleteTeamUser = D('Teamuser')->deleteTeamUserByTeamID($team_id);
                if(!$deleteTeamUser) {
                    $this->ajaxReturn(array(
                        'status' => 0,
                        'message' => '团队成员删除失败',
                    ));
                }
            }else {

                // 查看团队名称是否重复
                $teamName = D('Team')->getTeamByTeamName($teamArray['team_name'],$user['user_id']);
                if($teamName) {
                    $this->ajaxReturn(array(
                        'status' => 0,
                        'message' => '已有此团队名称',
                    ));
                }
                // 团队信息写入数据库
                $teamArray['gmt_create'] = date('Y-m-d H:i:s',time());
                $team_id = D('Team')->createTeam($teamArray);
                if(!$team_id) {
                    $this->ajaxReturn(array(
                        'status' => 0,
                        'message' => '团队信息创建失败',
                    ));
                }
            }

            // 队长信息写入数据库
            $leaderArray['team_id'] = $team_id;
            $teamLeader = D('Teamuser')->createTeamUser($leaderArray);
            if(!$teamLeader) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '队长信息写入失败',
                ));
            }
            // 队员信息写入数据库
            foreach ($newFormArray as $key => $item) {
                $item['team_id'] = $team_id;
                $item['gmt_create'] = date('Y-m-d H:i:s',time());
                $teamUser = D('Teamuser')->createTeamUser($item);
                if(!$teamUser) {
                    $this->ajaxReturn(array(
                        'status' => 0,
                        'message' => '队员信息写入失败',
                    ));
                }
            }
        }catch (Exception $exception) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => $exception->getMessage(),
            ));
        }
        $this->ajaxReturn(array(
            'status' => 1,
            'message' => 'form信息保存成功',
            'teamName' => $teamName,
        ));
    }

    /**
     * 功能：获取团队信息
     */
    public function getTeamInfo() {
        $team_id = I('post.team_id',0,'intval');
        if(!$team_id) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '团队ID不存在！'
            ));
        }
        try{
            // 获取团队信息
            $team = D('Team')->getTeamByID($team_id);
            if(!$team) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '团队信息不存在',
                ));
            }
            // 获取团队成员信息
            $teamUser = D('Teamuser')->getTeamUserByTeamID($team_id);
            if(!$teamUser) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '团队信息不存在',
                ));
            }

            $memberArray = array();
            $newTeamUser = array();
            $sexIndexArray = array();
            $memberNumber = 1;
            foreach ($teamUser as $key => $item) {
                if($item['is_leader'] == 1) {
                    $team['leader'] = $item;
                    unset($teamUser[$key]);
                }else {
                    $memberArray[] = $memberNumber++;
                    $newTeamUser[] = $item;
                    $sexIndexArray[] = $item['real_sex'];
                }
            }
        }catch (Exception $exception) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => $exception->getMessage(),
            ));
        }

        $this->ajaxReturn(array(
            'status' => 1,
            'message' => '团队信息查找成功',
            'teamInfo' => $team,
            'memberArray' => $memberArray,
            'memberNumber' => $memberNumber,
            'newTeamUser' => $newTeamUser,
            'sexIndexArray' => $sexIndexArray,
        ));
    }

    /**
     * 功能：获取用户是否创建团队信息的结果
     */
    public function getUserTeam() {
        if(!$_POST['sessionKey']) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => 'post数据不存在！',
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

        $userTeam = D('Team')->listTeamByUserID($user['user_id']);
        if(!$userTeam) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '用户没有创建团队！',
            ));
        }
        $this->ajaxReturn(array(
            'status' => 1,
            'message' => '用户已创建团队！',
        ));
    }
}