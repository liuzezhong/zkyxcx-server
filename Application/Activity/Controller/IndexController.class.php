<?php

/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-12
 * Time: 10:27
 */
namespace Activity\Controller;
use Think\Controller;
use Think\Exception;

class IndexController extends Controller {
    public function index() {
        try {
            $events = D('event')->selectALLEvent();
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }

        if($_GET['tasks_id']) {
            $tasks_id = I('get.tasks_id',0,'intval');
            $project_status = I('get.project_status',0,'intval');
            $registration = I('get.registration',0,'intval');
            try {
                $tasks = D('Activity')->getOneTasksByID($tasks_id);
                $tasks['start_time'] = date('Y年m月d日',$tasks['start_time']);
                $tasks['end_time'] = date('Y年m月d日',$tasks['end_time']);


            } catch (Exception $exception) {
                $this->error($exception->getMessage());
            }
        }
        $this->assign(array(
            'tasks' => $tasks,
            'tasks_id' => $tasks_id,
            'project_status' => $project_status,
            'registration' => $registration,
            'events' => $events,
        ));
        $this->display();
    }

    public function checkActivityBody() {

        $title = I('post.title','','trim,string');
        $category = I('post.category',0,'intval');
        $start_time = I('post.start_time',0,'intval');
        $end_time = I('post.end_time',0,'intval');
        $description = I('post.description','','trim,string');
        $leader = I('post.leader','','trim,string');
        $contact = I('post.contact','','trim,string');
        $tasks_id = I('post.tasks_id',0,'intval');

        if(!$title) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '请输入赛事活动名称！'
            ));
        }

        if($category == 0) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '请选择赛事活动分类！'
            ));
        }

        if(!$start_time) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '请输入赛事活动开始时间！'
            ));
        }

        if(!$end_time) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '请输入赛事活动结束时间！'
            ));
        }

        if($start_time > $end_time) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '赛事活动开始时间不能晚于结束时间！'
            ));
        }

        if(!$description) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '请列出将要举办赛事活动的相关简介或竞赛规程！'
            ));
        }

        if(!$leader) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '请输入举办方负责人姓名！'
            ));
        }

        if(!$contact) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '请输入举办方负责人电话号码！'
            ));
        }
        if($tasks_id) {
            $data = array(
                'title' => $title,
                'category' => $category,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'description' => $description,
                'leader' => $leader,
                'contact' => $contact,
                'update_time' => time(),
                'reward' => 100,
            );
        }else {
            $data = array(
                'title' => $title,
                'category' => $category,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'description' => $description,
                'leader' => $leader,
                'contact' => $contact,
                'create_time' => time(),
                'reward' => 100,
                'user_id' => 0,
            );
        }

        try {
            if($tasks_id != 0) {
                //更新
                $act_res = D('Activity')->updateOneTasks($tasks_id,$data);
                if(!$act_res) {
                    $this->ajaxReturn(array(
                        'status' => 0,
                        'message' => '赛事活动更新失败，请重试！'
                    ));
                }else if($act_res) {
                    $this->ajaxReturn(array(
                        'status' => 1,
                        'message' => '赛事活动保存成功！',
                        'tasks_id' => $tasks_id,
                    ));
                }
            } else {
                //新建
                $act_res = D('Activity')->addOneTasks($data);
                if(!$act_res) {
                    $this->ajaxReturn(array(
                        'status' => 0,
                        'message' => '赛事活动创建失败，请重试！'
                    ));
                }else if($act_res) {
                    $this->ajaxReturn(array(
                        'status' => 1,
                        'message' => '赛事活动创建成功！',
                        'tasks_id' => $act_res,
                    ));
                }
            }

        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }

    }

    public function project() {
        if(!$_GET['tasks_id']) {
            redirect(U('activity/index/index'));
        }
        $tasks_id = I('get.tasks_id',0,'intval');
        $project_status = I('get.project_status',0,'intval');
        $registration = I('get.registration',0,'intval');
        if($tasks_id) {
            try {
                $project = D('Project')->selectProjectByTasksID($tasks_id);
                if($project) {
                    $project_status = 1;
                }
            } catch (Exception $exception) {
                $this->error($exception->getMessage());
            }
        }
        $this->assign(array(
            'tasks_id' => $tasks_id,
            'projects'  => $project,
            'project_status' => $project_status,
            'registration' => $registration,
        ));
        $this->display();
    }

    public function checkProject() {

        $project = $_POST['project'];
        $tasks_id = I('post.tasks_id','','intval');

        $old_project = D('Project')->selectProjectByTasksID($tasks_id);
        if($old_project) {
            $project_id_array = array_column($old_project,'project_id');
            foreach ($project_id_array as $key => $item) {
                $flag = 0;
                foreach ($project as $p => $q) {
                    if($item == $q['project_id']) {
                        $flag = 1;
                        $projectData = array(
                            'title' => $q['title'],
                            'price' => $q['price'],
                            'update_time' => time(),
                        );
                        $res = D('Project')->updateProjectByID($item,$projectData);
                        if($res) {
                            unset($project[$p]);
                        }
                    }
                }
                if($flag == 0) {
                    //没找到匹配ID 删除
                    $res_del = D('Project')->deleteOneProjectByID($item);
                    if($res_del) {
                        $this->error('删除失败!');
                    }
                }
            }
        }
        foreach ($project as $key => $item) {
            if(!$item['title']) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '新的竞赛项目名称不能为空！'
                ));
            }
            if(!is_numeric($item['price'])) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '请输入正确的金额！'
                ));
            }

            $projectData = array(
                'tasks_id' => $tasks_id,
                'title' => $item['title'],
                'price' => $item['price'],
                'create_time' => time(),
            );

            $res_project = D('Project')->addOneProject($projectData);
            if(!$res_project) {
                //写失败
                $this->error('竞赛项目写入失败！');
            }
        }

        $this->ajaxReturn(array(
            'status' => 1,
            'message' => '竞赛项目添加成功！',
            'tasks_id' => $tasks_id,
            'project_status' => 1,
        ));
    }

    public function registration() {
        if(!$_GET['tasks_id']) {
            redirect(U('activity/index/index'));
        }
        $tasks_id = I('get.tasks_id',0,'intval');
        $project_status = I('get.project_status',0,'intval');
        $registration = I('get.registration',0,'intval');
        if($registration) {
            try {
                $tasks = D('Activity')->getOneTasksByID($tasks_id);
                if($tasks) {
                    $tasks['enrol_start_time'] = date('Y年m月d日',$tasks['start_time']);
                    $tasks['enrol_end_time'] = date('Y年m月d日',$tasks['end_time']);
                }
            } catch (Exception $exception) {
                $this->error($exception->getMessage());
            }
        }

        $this->assign(array(
            'tasks_id' => $tasks_id,
            'project_status' => $project_status,
            'registration' => $registration,
            'tasks' => $tasks,
        ));
        $this->display();
    }

    public function checkRegistration() {

        $tasks_id = I('post.tasks_id',0,'intval');
        $enrol_start_time = I('post.enrol_start_time',0,'intval');
        $enrol_end_time = I('post.enrol_end_time',0,'intval');
        $personal_limit = I('post.personal_limit',0,'intval');
        $team_limit = I('post.team_limit',0,'intval');
        $team_personal_limit = I('post.team_personal_limit',0,'intval');
        $total_personal = I('post.total_personal',0,'intval');
        $minimum_age = I('post.minimum_age',0,'intval');
        $maximum_age = I('post.maximum_age',0,'intval');
        $statement = I('post.statement','','trim,string');

        if(!$enrol_start_time || !$enrol_end_time) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '报名开始时间和结束时间不能为空！',
            ));
        }
        if($enrol_start_time > $enrol_end_time) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '报名开始时间不能大于报名结束时间！',
            ));
        }

        try {
            $tasks = D('Activity')->getOneTasksByID($tasks_id);
            if($enrol_start_time > $tasks['end_time']) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '报名开始时间不能晚于活动结束时间！',
                ));
            }
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
        if($minimum_age > $maximum_age) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '最小年龄不能大于最大年龄！',
            ));
        }

        $data = array(
            'enrol_start_time' => $enrol_start_time,
            'enrol_end_time' => $enrol_end_time,
            'personal_limit' => $personal_limit,
            'team_limit' => $team_limit,
            'team_personal_limit' => $team_personal_limit,
            'total_personal' => $total_personal,
            'minimum_age' => $minimum_age,
            'maximum_age' => $maximum_age,
            'statement' => $statement,
        );

        try {
            $res = D('Activity')->updateOneTasks($tasks_id,$data);
            if(!$res) {
                /*$this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '未做任何修改！',
                ));*/
            }else {
                $this->ajaxReturn(array(
                    'status' => 1,
                    'message' => '报名信息保存成功！',
                    'tasks_id' => $tasks_id,
                    'project_status' => 1,
                    'registration' => 1,
                ));
            }
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }

    }

    public function form() {
        if(!$_GET['tasks_id']) {
            redirect(U('activity/index/index'));
        }
        $tasks_id = I('get.tasks_id',0,'intval');
        $project_status = I('get.project_status',0,'intval');
        $registration = I('get.registration',0,'intval');

        try {
            $attribute = D('Enrolname')->selectAttributeEnrolName();
            if($attribute) {
                foreach ($attribute as $key => $item) {
                    if($item['required'] == 1) {
                        $attribute[$key]['name'] = $item['name'] . '（必填）';
                    }
                }
            }
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
        $this->assign(array(
            'tasks_id' => $tasks_id,
            'project_status' => $project_status,
            'registration' => $registration,
            'attributes' => $attribute,
        ));
        $this->display();
    }

    public function checkForm() {
        $postData = $_POST['data'];
        $tasks_id = I('post.tasks_id','0','intval');
        $nameid_array = array();
        if(!$postData) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '数据为空！',
            ));
        }else {
            foreach ($postData as $key => $item) {
                if($item['selected'] == 0) {
                    unset($postData[$key]);
                }
            }
            foreach ($postData as $key => $item) {
                if($item['name_id'] == -1) {
                    try {
                        $nameData = array(
                            'name' => $item['name'],
                            'required' => $item['required'],
                            'attribute' => 0,
                            'create_time' => time(),
                        );
                        $nameid_array[] = D('Enrolname')->addOneName($nameData);
                    } catch (Exception $exception) {
                        $this->error($exception->getMessage());
                    }
                }else {
                    $nameid_array[] = $item['name_id'];
                }
            }

            try {
                $enrol_data = array(
                    'tasks_id' => $tasks_id,
                    'user_id' => 0,
                    'create_time' => time(),
                );
                $enrol_id = D('Enrol')->addOneEnrol($enrol_data);

                if($enrol_id) {
                    foreach ($nameid_array as $key => $item) {
                        $enrol_k_data = array(
                            'enrol_id' => $enrol_id,
                            'name_id' => $item,
                        );
                        $enrolk = D('Enrolk')->addEnrolK($enrol_k_data);
                    }
                }
            } catch (Exception $exception) {
                $this->error($exception->getMessage());
            }

            $this->ajaxReturn(array(
                'status' => 1,
                'message' => '活动发布成功！',
            ));
        }
    }
}