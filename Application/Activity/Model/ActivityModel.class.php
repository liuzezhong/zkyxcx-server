<?php

/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-12
 * Time: 17:18
 */
namespace Activity\Model;
use Think\Model;

class ActivityModel extends Model {
    private $_db = '';

    public function __construct() {
        $this->_db = M('tasks');
    }

    public function addOneTasks($data = array()) {
        if(!$data || !is_array($data)) {
            throw_exception('数据为空！');
        }
        return $this->_db->add($data);
    }

    public function getOneTasksByID($tasks_id = 0) {
        if($tasks_id == 0) {
            throw_exception('ID为0！');
        }
        return $this->_db->where('tasks_id = ' . $tasks_id)->find();
    }

    public function updateOneTasks($tasks_id = 0, $data = array()) {
        if(!$tasks_id || !is_numeric($tasks_id)) {
            throw_exception('任务ID为空！');
        }
        if(!$data || !is_array($data)) {
            throw_exception('数据为空！');
        }
        return $this->_db->where('tasks_id = ' . $tasks_id)->save($data);
    }
}