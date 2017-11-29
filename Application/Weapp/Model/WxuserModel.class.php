<?php
/**
 * Created by PhpStorm.
 * User: liuzezhong
 * Date: 2017/10/24
 * Time: 14:37
 */

namespace Weapp\Model;


use Think\Model;

class WxuserModel extends Model
{
    /**
     * 功能：根据openid查询用户信息
     * @param string $openid
     * @return mixed
     */
    public function getUserByOpenID ($openid = '') {
        if($openid == '' || !$openid) {
            throw_exception('Weapp Model WxuserModel getUserByOpenID openid is null');
        }
        $condition['openid'] = $openid;
        return $this->where($condition)->find();
    }

    /**
     * 功能：新增用户信息
     * @param array $data
     * @return mixed
     */
    public function createUserInfo ($data = array()) {
        if(!$data || !is_array($data)) {
            throw_exception('Weapp Model WxuserModel createUserInfo is null');
        }
        return $this->add($data);
    }

    /**
     * 功能：根据openid写入userinfo信息
     * @param string $openid
     * @param array $userInfo
     */
    public function saveUserInfoByOpenID ($openid = '', $userInfo = array()) {
        if($openid == '' || !$openid) {
            throw_exception('Weapp Model WxuserModel saveUserInfoByOpenID openid is null');
        }
        if(!$userInfo || !is_array($userInfo)) {
            throw_exception('Weapp Model WxuserModel saveUserInfoByOpenID userInfo is null');
        }
        $condition['openid'] = $openid;
        return $this->where($condition)->save($userInfo);
    }

    /**
     * 功能：根据用户ID查找用户信息
     * @param int $user_id
     * @return mixed
     */
    public function getUserInfoByID($user_id = 0) {
        if(!$user_id) {
            throw_exception('Weapp Model WxuserModel getUserInfoByID user_id is null');
        }
        $condition['user_id'] = $user_id;
        return $this->where($condition)->find();
    }

    /**
     * 功能：根据多个用户ID批量查询用户信息
     * @param array $userArray
     * @return mixed
     */
    public function getUserInfoByIDArray($userArray = array()) {
        if(!$userArray || !is_array($userArray)) {
            throw_exception('Weapp Model WxuserModel getUserInfoByIDArray userArray is null');
        }
        $condition['user_id'] = array('IN',$userArray);
        return $this->where($condition)->select();
    }

    /**
     * 获取所有有步数的用户信息，并按步数降序排列
     * @return mixed
     */
    public function listUserOrderStep() {
        $condition['step_sum'] = array('NEQ',0);
        return $this->where($condition)->order('step_sum desc')->select();
    }

    /**
     * 获取所有有身价积分的用户信息，并按身价降序排列
     * @return mixed
     */
    public function listUserOrderWorth() {
        $condition['worth_list'] = array('NEQ',0);
        return $this->where($condition)->order('worth_list desc')->select();
    }
}