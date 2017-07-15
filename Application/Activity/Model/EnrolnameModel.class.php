<?php
/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-15
 * Time: 9:10
 */

namespace Activity\Model;


use Think\Model;

class EnrolnameModel extends Model {
    private $_db = '';

    public function __construct() {
        $this->_db = M('enrol_name');
    }

    public function selectAttributeEnrolName() {
        return $this->_db->where('attribute = 1')->select();
    }

    public function addOneName($data = array()) {
        if(!$data || !is_array($data)) {
            throw_exception('数据不存在！');
        }
        return $this->_db->add($data);
    }
}