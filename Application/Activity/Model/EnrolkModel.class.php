<?php
/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-15
 * Time: 10:15
 */

namespace Activity\Model;


use Think\Model;

class EnrolkModel extends Model {
    private $_db = '';

    public function __construct() {
        $this->_db = M('enrol_k');
    }

    public function addEnrolK($data = array()) {
        if(!$data || !is_array($data)) {
            throw_exception('数据不存在！');
        }
        return $this->_db->add($data);
    }

    public function selectEnrolByTasksID($tasks_id = 0) {
        if(!$tasks_id) {
            throw_exception('ID不存在！');
        }
        return $this->_db->where('tasks_id = ' . $tasks_id)->select();
    }
}