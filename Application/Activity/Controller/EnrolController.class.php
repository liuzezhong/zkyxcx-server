<?php
/**
 * Created by PhpStorm.
 * User: liuzezhong
 * Date: 2017/9/4
 * Time: 16:47
 */

namespace Activity\Controller;


use Think\Controller;

class EnrolController extends Controller {
    public function index() {
        $tasks_id = I('get.tasks_id',0,'intval');
        $all_tasks = D('Activity')->getAllTasks();

        if($tasks_id == 0) {
            $tasks_id = $all_tasks[0]['tasks_id'];
        }

        $tasks = D('Activity')->getOneTasksByID($tasks_id);
        //赛事分类
        $projects = D('Project')->selectProjectByTasksID($tasks_id);

        //报名信息
        $enrols = D('Enrol')->selectEnrolByTasksID($tasks_id);
        $enrol_ids = array_column($enrols,'enrol_id');
        //报名字段信息
        $enrols_k = D('Enrolk')->selectEnrolkByTasksID($tasks_id);
        $name_id = array_column($enrols_k,'name_id');
        $enrol_name = D('Enrolname')->selectEnrolNameByNameID($name_id);
        $name = array_column($enrol_name,'name');

        //报名值的信息
        $enrol_values = D('Enrolvalue')->selectEnrolValueByEnrolID($enrol_ids);

        foreach($enrols as $key => $value) {
            $project_id = $value['project_id'];
            foreach($projects as $p => $q) {
                if($project_id == $q['project_id']) {
                    $project = $projects[$p];
                }
            }
            $enrols[$key]['title'] = $project['title'];
            $enrols[$key]['price'] = $project['price'];
            foreach($enrol_values as $p => $q) {
                if($value['enrol_id'] == $q['enrol_id']) {
                    $enrols[$key]['value'][] = $q['value'];
                }
            }
            $enrols[$key]['pay_status'] = $value['pay_status'] ? '已支付' : '未支付';
            $enrols[$key]['id'] = $key+1;
            $enrols[$key]['create_time'] = date('Y-m-d H:i:s',$value['create_time']);

        }

        $this->assign(array(
            'enrols' => $enrols,
            'tasks' => $tasks,
            'name' => $name,
            'alltasks' => $all_tasks,
        ));
        $this->display();
    }

    public function export() {
        $tasks_id = I('get.tasks_id',0,'intval');

        $tasks = D('Activity')->getOneTasksByID($tasks_id);
        //赛事分类
        $projects = D('Project')->selectProjectByTasksID($tasks_id);

        //报名信息
        $enrols = D('Enrol')->selectEnrolByTasksID($tasks_id);
        $enrol_ids = array_column($enrols,'enrol_id');
        //报名字段信息
        $enrols_k = D('Enrolk')->selectEnrolkByTasksID($tasks_id);
        $name_id = array_column($enrols_k,'name_id');
        $enrol_name = D('Enrolname')->selectEnrolNameByNameID($name_id);
        $name = array_column($enrol_name,'name');

        //报名值的信息
        $enrol_values = D('Enrolvalue')->selectEnrolValueByEnrolID($enrol_ids);

        foreach($enrols as $key => $value) {
            $project_id = $value['project_id'];
            foreach($projects as $p => $q) {
                if($project_id == $q['project_id']) {
                    $project = $projects[$p];
                }
            }
            $enrols[$key]['title'] = $project['title'];
            $enrols[$key]['price'] = $project['price'];
            foreach($enrol_values as $p => $q) {
                if($value['enrol_id'] == $q['enrol_id']) {
                    $enrols[$key][$q['name_id']] = $q['value'];
                }
            }
            $enrols[$key]['pay_status'] = $value['pay_status'] ? '已支付' : '未支付';
            $enrols[$key]['id'] = $key+1;
            $enrols[$key]['create_time'] = date('Y-m-d H:i:s',$value['create_time']);

        }


        $xlsName  = $tasks['title'];
        $xlsCell  = array(
            array('id','报名序列'),
            array('title','项目名称'),
            array('price','报名费用(元)'),
            array('pay_status','支付状态'),
        );

        foreach ($enrol_name as $key => $value) {
            array_push($xlsCell,array($value['name_id'],$value['name']));
        }
        array_push($xlsCell,array('create_time','报名时间'));
        $xlsData = $enrols;
        D('Phpexcel')->exportExcel($xlsName,$xlsCell,$xlsData);

    }

}