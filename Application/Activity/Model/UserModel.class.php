<?php
/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-21
 * Time: 10:52
 */

namespace Activity\Model;


use Think\Model;

class UserModel extends Model {
    private $_db = '';

    public function __construct() {
        $this->_db = M('user');
    }

    public function selectAllRank() {

        return $this->_db->where("nick_name != 'null'")->order('rankmoney desc')->select();
    }

    public function findUserByCondition($key = '',$value = '') {
        $findData[$key] = $value;
        return $this->_db->where($findData)->find();
    }

    public function addOneUserInfo($data = array()) {
        if(!$data || !is_array($data)) {
            throw_exception('数据为空！');
        }
        return $this->_db->add($data);
    }

    public function updateUserRankMoney($user_id = 0 ,$rankmoney = 0) {
        if(!$user_id || !is_numeric($user_id)) {
            throw_exception('用户ID为空！');
        }
        if(!$rankmoney || !is_numeric($rankmoney)) {
            throw_exception('铠币为空！');
        }
        $saveData['rankmoney'] = $rankmoney;
        return $this->_db->where('user_id = ' . $user_id)->save($saveData);
    }

    public function updateUserInfoByOpenID($openid = '', $value = array()) {
        $selectData['openid'] = $openid;
        $res = $this->_db->where($selectData)->save($value);
        return $res;
    }

}