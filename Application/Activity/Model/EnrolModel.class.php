<?php
/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-15
 * Time: 10:07
 */

namespace Activity\Model;


use Think\Model;

class EnrolModel extends Model {
    private $_db = '';

    public function __construct() {
        $this->_db = M('enrol');
    }

    public function addOneEnrol($data = array()) {
        if(!$data || !is_array($data)) {
            throw_exception('数据不存在！');
        }
        return $this->_db->add($data);
    }

    public function getOneEnrolTasksID($tasks_id = 0) {
        if(!$tasks_id) {
            throw_exception('ID不存在！');
        }
        return $this->_db->where('tasks_id = ' . $tasks_id)->find();
    }

    public function getSomeEnrolByUserID($user_id = 0) {
        if(!$user_id) {
            throw_exception('ID不存在！');
        }
        return $this->_db->where('user_id = ' .$user_id)->order('tasks_id desc')->select();
    }

    public function getOneEnrolByUserIdAndComplete($user_id = 0,$complete = 0) {
        $selectData['user_id'] = $user_id;
        $selectData['complete'] = $complete;
        return $this->_db->where($selectData)->select();
    }

    public function setOneEnrolSignTime($tasks_id = 0 ,$user_id = 0) {

        $selectData['tasks_id'] = $tasks_id;
        $selectData['user_id'] = $user_id;
        $saveData['sign_time'] = time();
        return $this->_db->where($selectData)->save($saveData);
    }

    public function changePayStatus($tasks_id,$project_id,$user_id,$pay_status) {
        $selectData['tasks_id'] = $tasks_id;
        $selectData['project_id'] = $project_id;
        $selectData['user_id'] = $user_id;
        $saveData['pay_status'] = $pay_status;
        return $this->_db->where($selectData)->save($saveData);
    }

    public function getOneEnrolByTaskIDANDUserID($tasks_id = 0 ,$user_id = 0) {
        $selectData['tasks_id'] = $tasks_id;
        $selectData['user_id'] = $user_id;
        return $this->_db->where($selectData)->find();
    }

    public function getOneEnrolByTaskIDANDUserIDANDProjectID($tasks_id = 0 ,$user_id = 0,$project_id = 0) {
        $selectData['tasks_id'] = $tasks_id;
        $selectData['user_id'] = $user_id;
        $selectData['project_id'] = $project_id;
        return $this->_db->where($selectData)->find();
    }

    public function countTasks($tasks_id = 0) {
        if(!$tasks_id) {
            throw_exception('任务ID为空！');
        }
        return $this->_db->where('tasks_id = ' . $tasks_id)->count();
    }

    public function selectEnrolByTasksID($tasks_id = 0) {
        if(!$tasks_id) {
            throw_exception('赛事ID为空！');
        }
        return $this->_db->where('tasks_id = ' . $tasks_id)->select();
    }

    public function updateQrcodebyEnrolID($enrol_id = 0,$data=array()) {
        if(!$enrol_id) {
            throw_exception('报名ID为空！');
        }
        return $this->_db->where('enrol_id = ' .$enrol_id)->save($data);
    }
}