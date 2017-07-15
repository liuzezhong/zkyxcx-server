<?php
/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-10
 * Time: 10:39
 */

namespace Home\Model;


use Think\Model;

class SessionModel extends Model {
    private $_db = '';

    public function __construct() {
        $this->_db = M('session');
    }

    public function addOneSessionInfo($data = array()) {
        if(!$data || !is_array($data)) {
            throw_exception('数据为空！');
        }
        return $this->_db->add($data);
    }

    public function updataOneSessionInfo($openid = '' ,$data = array()) {
        $upData[$openid] = $openid;
        return $this->_db->where($upData)->save($data);
    }

    public function findSessionByCondition($key = '',$value = '') {
        $findData[$key] = $value;
        return $this->_db->where($findData)->find();
    }
}