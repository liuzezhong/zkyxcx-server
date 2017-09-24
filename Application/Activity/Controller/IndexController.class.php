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

    public function getActivity() {
        $tasks = D('Activity')->getAllTasks();
        foreach($tasks as $key => $item) {
            $create_time = $item['create_time'];
            $now_time = time();

            $year = date('Y',$now_time) - date('Y',$create_time);
            $month = date('m',$now_time) - date('m',$create_time);
            $day = date('d',$now_time) - date('d',$create_time);
            $hour = date('h',$now_time) - date('h',$create_time);
            $minute = date('i',$now_time) - date('i',$create_time);
            $second = date('s',$now_time) - date('s',$create_time);

            if($year == 0) {
                //同年
                if($month == 0) {
                    //同月
                    if($day == 0) {
                        //同日
                        if($hour == 0) {
                            //同小时
                            if($minute == 0) {
                                $fabu = $second . '秒前';
                            }else if($minute > 0) {
                                $fabu = $minute . '分钟前';
                            }
                        }else if($hour > 0) {
                            $fabu = $hour . '小时前';
                        }
                    }else if($day > 0) {
                        $fabu = $day . '天前';
                    }
                }else if($month > 0) {
                    $fabu = $month . '个月前';
                }
            }else if($year > 0) {
                if($month < 0 && $year == 1) {
                    //1年内
                    $fabu = 12 - $month . '个月前';
                }else {
                   $fabu = $year . '年前';
                }
            }

            $tasks[$key]['fabu'] = $fabu;

            //查找有多少人报名
            $count = D('Enrol')->countTasks($item['tasks_id']);
            $tasks[$key]['count'] = $count;

        }
        $this->ajaxReturn($tasks);
    }

    public function getActivityDetails() {

        $tasks_id = I('post.tasks_id',0,'intval');
        $skey = json_decode(I('post.skey','',''),true);
        if($tasks_id) {
            $inc = D('Activity')->addViewTimes($tasks_id);
        }
        if($skey) {
            $session_array = D('Session')->findSessionByConditionArray($skey);
            $openid = $session_array['openid'];
            $user_array = D('User')->findUserByCondition('openid',$openid);
            $user_id = $user_array['user_id'];

            $enrol = D('Enrol')->getOneEnrolByTaskIDANDUserID($tasks_id,$user_id);

            if($enrol) {
                $enrol_flag = 1;
            }else if(!$enrol) {
                $enrol_flag = 0;
            }
        }


        $project_value = array();
        $project_key = array();
        if($tasks_id) {
            $tasks = D('Activity')->getOneTasksByID($tasks_id);
            if($tasks) {
                $tasks['start_time'] = date('Y-m-d',$tasks['start_time']);
                $tasks['end_time'] = date('Y-m-d',$tasks['end_time']);
                $tasks['enrol_start_time'] = date('Y-m-d',$tasks['enrol_start_time']);
                $tasks['enrol_end_time'] = date('Y-m-d',$tasks['enrol_end_time']);

                //查找有多少人报名
                $count = D('Enrol')->countTasks($tasks_id);
                $tasks['count'] = $count;
            }
            $project = D('Project')->selectProjectByTasksID($tasks_id);
            if($project) {
                foreach($project as $key => $item) {
                    $project_key[] = $item['project_id'];
                    $project_value[] = $item['title'].'（报名费：'.$item['price'].'元）';
                }
            }
        }
        $this->ajaxReturn(array(
            'tasks' => $tasks,
            'project_key' => $project_key,
            'project_value' => $project_value,
            'enrol_flag' => $enrol_flag,
        ));
    }

    public function getActivityForms() {
        $tasks_id = I('post.tasks_id',0,'intval');
        $project_id = I('post.project_id',0,'intval');

        if($tasks_id) {
            $tasks = D('Activity')->getOneTasksByID($tasks_id);
            if($tasks) {
                $tasks['start_time'] = date('Y-m-d',$tasks['start_time']);
                $tasks['end_time'] = date('Y-m-d',$tasks['end_time']);
                $tasks['enrol_start_time'] = date('Y-m-d',$tasks['enrol_start_time']);
                $tasks['enrol_end_time'] = date('Y-m-d',$tasks['enrol_end_time']);
            }
            $enrol_k = D('Enrolk')->selectEnrolkByTasksID($tasks_id);
            $enrol_name = D('Enrolname')->selectEnrolNameByNameID(array_column($enrol_k,'name_id'));
        }
        if($project_id) {
            $project = D('Project')->getOneProjectByID($project_id);
        }

        $this->ajaxReturn(array(
            'tasks_id' => $tasks_id,
            'tasks' => $tasks,
            'project' => $project,
            'enrol_name' => $enrol_name,
        ));

    }

    public function getActivityFormsReport() {
        $tasks_id = I('post.tasks_id',0,'intval');

        $skey = json_decode(I('post.skey','',''),true);
        if($skey) {
            $session_array = D('Session')->findSessionByConditionArray($skey);
            $openid = $session_array['openid'];
            $user_array = D('User')->findUserByCondition('openid',$openid);
            $user_id = $user_array['user_id'];

            $enrol = D('Enrol')->getOneEnrolByTaskIDANDUserID($tasks_id,$user_id);
            $enrol_id = $enrol['enrol_id'];
            $project_id = $enrol['project_id'];
            $pay_status = $enrol['pay_status'];

            if($tasks_id) {
                $tasks = D('Activity')->getOneTasksByID($tasks_id);
                if($tasks) {
                    $tasks['start_time'] = date('Y-m-d',$tasks['start_time']);
                    $tasks['end_time'] = date('Y-m-d',$tasks['end_time']);
                    $tasks['enrol_start_time'] = date('Y-m-d',$tasks['enrol_start_time']);
                    $tasks['enrol_end_time'] = date('Y-m-d',$tasks['enrol_end_time']);
                }
                $enrol_k = D('Enrolk')->selectEnrolkByTasksID($tasks_id);
                $enrol_name = D('Enrolname')->selectEnrolNameByNameID(array_column($enrol_k,'name_id'));
            }
            if($project_id) {
                $project = D('Project')->getOneProjectByID($project_id);
            }

            if($enrol_id) {
                $enrol_vlaue = D('Enrolvalue')->selectEnrolByEnrolID($enrol_id);
                foreach ($enrol_vlaue as $key => $item) {
                    if($item['name_id'] == 7 || $item['name_id'] == 18) {
                        $enrol_vlaue[$key]['value'] = json_decode($item['value'],true);
                    }
                }
            }
        }

        $this->ajaxReturn(array(
            'tasks_id' => $tasks_id,
            'project_id' => $project_id,
            'pay_status' => $pay_status,
            'tasks' => $tasks,
            'project' => $project,
            'enrol_name' => $enrol_name,
            'enrol_value' => $enrol_vlaue,
        ));



    }

    public function saveForms() {
        $tasks_id = I('post.tasks_id',0,'intval');
        $project_id = I('post.project_id',0,'intval');
        $formData = json_decode(I('post.formData','',''),true);
        $skey = json_decode(I('post.skey','',''),true);



        foreach ($formData as $key => $item) {
            if($key == 5) {
                //血型
                $formData[$key] = C('BLOOD_TYPE')[$item];
            }else if($key == 7){
                //住址
                $formData[$key] = json_encode($item);
            }else if($key == 14) {
                //身高
                $formData[$key] = C('HEIGHT')[$item];
            }else if($key == 15) {
                //体重
                $formData[$key] = C('WEIGHT')[$item];
            }else if($key == 16) {
                //衣服尺码
                $formData[$key] = C('CLOTHING_SIZE')[$item];
            }else if($key == 17) {
                //学历
                $formData[$key] = C('EUDCATION')[$item];
            }else if($key == 18) {
                //职业
                //$zhi = C('OCCUPATION')[$item[0]][0];
                //$ye = C('OCCUPATION')[$item[0]][1][$item[1]];
                //$formData[$key] = $zhi . '/' . $ye;
                $formData[$key] = json_encode($item);
            }
        }

        if($_POST) {

            $session_array = D('Session')->findSessionByConditionArray($skey);
            $openid = $session_array['openid'];
            $user_array = D('User')->findUserByCondition('openid',$openid);


            $enrolData = array(
                'tasks_id' => $tasks_id,
                'project_id' => $project_id,
                'user_id' => $user_array['user_id'],
                'create_time' => time(),
            );
            $enrol_id = D('Enrol')->addOneEnrol($enrolData);
            if($enrol_id) {
                foreach ($formData as $key => $item) {
                    $enrolValue = array(
                        'enrol_id' => $enrol_id,
                        'name_id' => $key,
                        'value' => $item,
                        'create_time' => time(),
                    );
                    $res_enrolValue = D('Enrolvalue')->addOneEnrolValue($enrolValue);
                }

                $this->ajaxReturn(array(
                    'status' => 1,
                    'message' => '活动报名成功！',
                    ''
                ));

            }else {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '数据写入失败，请重试！',
                ));
            }
        }else {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '数据写入失败，请重试！',
            ));
        }
    }


    public function updateForms() {

        $tasks_id = I('post.tasks_id',0,'intval');
        $project_id = I('post.project_id',0,'intval');
        $formData = json_decode(I('post.formData','',''),true);
        $skey = json_decode(I('post.skey','',''),true);


        foreach ($formData as $key => $item) {
            if($key == 5) {
                //血型
                $formData[$key] = C('BLOOD_TYPE')[$item];
            }else if($key == 7){
                //住址
                $formData[$key] = json_encode($item);
            }else if($key == 14) {
                //身高
                $formData[$key] = C('HEIGHT')[$item];
            }else if($key == 15) {
                //体重
                $formData[$key] = C('WEIGHT')[$item];
            }else if($key == 16) {
                //衣服尺码
                $formData[$key] = C('CLOTHING_SIZE')[$item];
            }else if($key == 17) {
                //学历
                $formData[$key] = C('EUDCATION')[$item];
            }else if($key == 18) {
                //职业
                //$zhi = C('OCCUPATION')[$item[0]][0];
                //$ye = C('OCCUPATION')[$item[0]][1][$item[1]];
                //$formData[$key] = $zhi . '/' . $ye;
                $formData[$key] = json_encode($item);
            }
        }

        $session_array = D('Session')->findSessionByConditionArray($skey);
        $openid = $session_array['openid'];
        $user_array = D('User')->findUserByCondition('openid',$openid);
        $user_id = $user_array['user_id'];

        $enrol_array = D('Enrol')->getOneEnrolByTaskIDANDUserIDANDProjectID($tasks_id,$user_id,$project_id);

        $enrol_id = $enrol_array['enrol_id'];

        foreach ($formData as $key => $item) {
            $enrolValue = array(
                'value' => $item,
            );
            $res_enrolValue = D('Enrolvalue')->updateEnrolByEnrolID($enrol_id,$key,$enrolValue);

        }

        $this->ajaxReturn(array(
            'status' => 1,
            'message' => '修改成功！',
        ));

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
                foreach ($nameid_array as $key => $item) {
                    $enrol_k_data = array(
                        'tasks_id' => $tasks_id,
                        'name_id' => $item,
                    );
                    $enrolk = D('Enrolk')->addEnrolK($enrol_k_data);
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

    public function generateProgramCode() {
        $tasks_id = I('get.tasks_id',0,'intval');

        $access_token_url = C('ACCESS_TOKEN_URL') . '&appid=' . C('APP_ID') . '&secret=' . C('APP_SECRET');
        $access_token_array = D('Common')->http($access_token_url, array(), 'GET', array("Content-type: text/html; charset=utf-8"));
        $access_token_array = json_decode($access_token_array,true);
        $access_token = $access_token_array['access_token'];

        $small_program_code_url = C('SMALL_PROGRAM_CODE_URL') . $access_token;

        $small_program_code_data = array(
            'scene' => $tasks_id,
        );
        $small_program_code_data = json_encode($small_program_code_data);
        $samll_program_code = D('Common')->http($small_program_code_url, $small_program_code_data, 'POST', array("Content-type: application/json;"),true);

        $imagePath = 'Public/image/program/';
        $imageName = $tasks_id . '.png';
        $imageUrl = $imagePath . $imageName;
        $programImage = fopen($imageUrl, "w") or die("Unable to open file!");
        fwrite($programImage, $samll_program_code);
        fclose($programImage);

        $imageUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/' .$imageUrl;

        try {
            $res = D('Activity')->updateOneTasks($tasks_id,array('program_code' => $imageUrl));
            if(!$res) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '任务小程序二维码保存失败！',
                ));
            }

            $this->assign(array(
                'imageUrl' => $imageUrl,
            ));
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
        $this->display();



    }

    public function setSign() {
        $skey = json_decode(I('post.skey','',''),true);
        $session_array = D('Session')->findSessionByConditionArray($skey);
        $openid = $session_array['openid'];
        $user_array = D('User')->findUserByCondition('openid',$openid);
        $user_id = $user_array['user_id'];
        $tasks_id = I('post.tasks_id',0,'intval');

        try {
            $enrol = D('Enrol')->setOneEnrolSignTime($tasks_id,$user_id);
            if(!$enrol) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '签到失败！',
                ));
            }
            $tasks = D('Activity')->getOneTasksByID($tasks_id);
            $this->ajaxReturn(array(
                'status' => 1,
                'message' => '签到成功！',
                'sign_task' => $tasks,
            ));
        }catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}