<?php
/**
 * 功能：赛事信息控制模块类
 * Created by PhpStorm.
 * User: liuzezhong
 * Date: 2017/10/23
 * Time: 10:32
 */
namespace Weapp\Controller;
use Think\Exception;

class MatchController  extends BaseController
{
    /**
     * 功能：获取所有的未结束的比赛信息
     * 需改进：取消一次性读取，采用分页读取方式
     */
    public function listAllMatchInfoUnfinished() {
        // 初始化比赛信息列表
        $matchs = array();
        try {
            // 数据库查找所有未结束的比赛信息
            $matchs = D('Match')->listAllMatchRecordsUnfinished();
            // 比赛信息为空或数据查找失败
            if(!$matchs) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '未结束的比赛信息为空或数据查找失败!',
                ));
            }

            foreach ($matchs as $key => $item) {
                // 时间格式转换：2017-10-22 14:22:34 => 10-22
                $matchs[$key]['gmt_create'] = date('m-d',strtotime($item['gmt_create']));

                // 运动类别转换：将项目ID转换为名称（2 => 羽毛球）
                $event_name = D('Event')->getEventName($item['event_id']);
                if(!$event_name) {
                    // 若不存在此类别ID
                    $matchs[$key]['event_name'] = '其它类型';
                }else {
                    $matchs[$key]['event_name'] = $event_name['name'];
                }

                // 获取比赛图片信息地址，如果有多张选第一张作为封面
                $image_url = D('image')->getImageOfMatch($item['match_id']);
                if(!$image_url) {
                    // 若无图片，则使用默认图片
                    $matchs[$key]['image_url'] = 'http://img.hongtongad.com/20160315/118_20160315104203_64332.jpg';
                } else {
                    $matchs[$key]['image_url'] = $image_url['image_url'];
                }

                // 获取已经报名的人数
                /*$countRegister = D('Register')->countRegisterByMatchID($item['match_id']);
                $matchs[$key]['countRegister'] = $countRegister;*/

                $registers = D('Register')->getRegisterByMatchID($item['match_id']);
                $matchs[$key]['countRegister'] = count(array_unique(array_column($registers,'user_id')));
            }
            // 返回比赛信息
            $this->ajaxReturn(array(
                'status' => 1,
                'message' => '未结束的比赛信息查找成功!',
                'matchs' => $matchs,
            ));
            
        } catch (Exception $exception) {
            // 抛出异常信息
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => $exception->getMessage(),
            ));
        }
    }

    /**
     * 功能：根据比赛ID获取比赛相关数据，包括图片信息及类目信息
     */
    public function getMatchInfoByID() {
        // 数据初始化
        $match_id = I('post.match_id',0,'intval');
        $images = array();
        $match = array();
        $categoryName = array();
        $categoryID = array();
        try {
            // 根据比赛ID数据库查找比赛信息
            $match = D('Match')->getMatchInfoByID($match_id);
            // 如果比赛信息不存在，返回结果
            if(!$match) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '比赛信息不存在，请重试!',
                ));
            }

            // 根据比赛ID数据库查找关联的图片信息
            $images = D('Image')->listImageOfMatch($match_id);
            if(!$images) {
                $images = 'http://img.hongtongad.com/20160315/118_20160315104203_64332.jpg';
            }

            // 根据比赛ID数据库查找关联类目信息
            $category = D('Category')->listCategoryOfMatch($match_id);
            if($category) {
                // 将类目信息整理成：男子单打(¥12.00)
                $categoryType = array();
                foreach ($category as $key => $value) {
                    $categoryType[] = $value['type'];
                    if($value['money'] == '0.00') {
                        $categoryName[$key] = $value['category_name'].'（免费）';
                    }else {
                        $categoryName[$key] = $value['category_name'].'（¥'.$value['money'].'）';
                    }
                }
                // 取出类目信息ID号
                $categoryID = array_column($category,'category_id');
            } else {
                $categoryName[0] = '个人参赛(¥20)';
                $categoryID[0] = 1;
            }

            // 根据赛事信息查找已经报名信息
            $register = D('Register')->getRegisterByMatchID($match_id);
            if($register) {
                // 统计已报名人数
                $userArray = array_column($register,'user_id');
                $userArray = array_unique($userArray);
                $countRegister = count($userArray);
                // 查找用户信息
                $registerUserInfo = D('Wxuser')->getUserInfoByIDArray($userArray);
            }else {
                $countRegister = 0;
                $registerUserInfo = array();
            }


            //

        } catch (Exception $exception) {
            // 抛出异常信息
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => $exception->getMessage(),
            ));
        }
        // 返回数据信息和结果
        $this->ajaxReturn(array(
            'status' => 1,
            'message' => '比赛信息查找成功！',
            'match' => $match,
            'images' => $images,
            'categoryName' => $categoryName,
            'categoryID' => $categoryID,
            'registerUserInfo' => $registerUserInfo,
            'countRegister' => $countRegister,
            'categoryType' => $categoryType,
        ));
    }

    /**
     * 功能：增加查看次数
     */
    public function increaseViewTimes () {
        // 获取传递过来的比赛ID
        $match_id = I('post.match_id',0,'intval');
        try {
            // 数据库操作将查看次数字段加1
            $viewTimes = D('Match')->increaseViewTimes($match_id);
            // 返回结果
            if(!$viewTimes) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '查看次数新增失败！',
                ));
            } else {
                $this->ajaxReturn(array(
                    'status' => 1,
                    'message' => '查看次数增加成功！',
                ));
            }
        } catch (Exception $exception) {
            // 抛出异常信息
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => $exception->getMessage(),
            ));
        }
    }

    /**
     * 功能：获取报名比赛的信息（比赛信息、比赛项目信息、用户信息）
     */
    public function getSignInfo() {
        // 验证数据有效性
        if(!$_POST['sessionKey'] || !$_POST['match_id'] || !$_POST['category_id']) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => 'POST数据不存在！'
            ));
        }
        // 获取比赛ID和比赛项目ID
        $match_id = $_POST['match_id'];
        $category_id = $_POST['category_id'];

        // 用sessionkey换取openid
        $openArray = $this->getOpenidBySessionKey($_POST['sessionKey']);
        if($openArray['status'] == 0) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => $openArray['message'],
            ));
        }
        // 数据库查找用户信息
        $user = D('Wxuser')->getUserByOpenID($openArray['openid']);
        if(!$user) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '用户信息不存在！',
            ));
        }

        // 根据比赛ID数据库查找比赛信息
        $match = D('Match')->getMatchInfoByID($match_id);
        if(!$match) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '比赛信息不存在，请重试!',
            ));
        }

        // 根据比赛项目ID查找比赛项目信息
        $category = D('Category')->getCategoryOfMatch($category_id);
        if(!$category) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '比赛项目信息不存在，请重试!',
            ));
        }

        //查找是否已经报名
        $register = D('Register')->isRegister($match_id,$category_id,$user['user_id']);
        //查找是否已经支付
        $payrecords = D('Payrecords')->isPayrecords($match_id,$category_id,$user['user_id']);

        $leaderArray = array();
        $teamUserArray = array();
        $teamInfo = array();
        if($register || $payrecords) {
            // 已经报名
            $is_register = 1;
            if($register['team_id'] != 0) {

                // 搜索团队信息
                $teamInfo = D('Team')->getTeamByID($register['team_id']);
                // 获取团队成员信息
                $teamUser = D('Teamuser')->getTeamUserByTeamID($teamInfo['team_id']);

                foreach($teamUser as $key => $item) {
                    if($item['is_leader'] == 1) {
                        $leaderArray = $item;
                    }else {
                        $teamUserArray[] = $item;
                    }
                }
                $teamInfo['leader'] = $leaderArray;
                $teamInfo['user'] = $teamUserArray;
            }
        }else {
            // 未报名
            $is_register = 0;
        }

        // 查找团队信息
        $userTeam = D('Team')->listTeamByUserID($user['user_id']);
        if(!$userTeam) {
            $userTeam[0]['team_id'] = 0;
        }

        // 返回结果
        $this->ajaxReturn(array(
            'status' => 1,
            'message' => '用户信息查找成功',
            'userInfo' => $user,
            'match' => $match,
            'category' => $category,
            'is_register' => $is_register,
            'register' => $register,
            'userTeam' => $userTeam,
            'teamInfo' => $teamInfo,
        ));
    }

    /**
     * 功能：调用微信支付类，获取发起微信支付所需的必要参数
     */
    public function getWxRequestPayment() {
        // 用sessionkey换取openid
        $openArray = $this->getOpenidBySessionKey($_POST['sessionKey']);
        if($openArray['status'] == 0) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => $openArray['message'],
            ));
        }

        // 总金额 单位为分
        $total_fee = I('post.total_fee','','trim,string');
        // 商品描述
        $body = I('post.body','','trim,string');
        // new一个微信支付类

        // 比赛记录ID
        $match_id = I('post.match_id',0,'intval');
        // 比赛项目ID
        $category_id = I('post.category_id',0,'intval');
        // 用户ID
        $user_id = I('post.user_id',0,'intval');


        //查找是否已经报名
        $register = D('Register')->isRegister($match_id,$category_id,$user_id);
        if($register) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '请勿重复报名'
            ));
        }

        //查找是否已经支付
        $payrecords = D('Payrecords')->isPayrecords($match_id,$category_id,$user_id);
        if($payrecords) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '请勿重复支付'
            ));
        }

        $wxpay = new WxPayMent(C('WECHAT_SMALL_APPLICATION')['APPID'],C('WECHAT_SMALL_APPLICATION')['TYXD_MCH_ID']);
        // 调用获取微信支付基础参数方法
        $requestPayment = $wxpay->getRequestPayment($total_fee,$body,$openArray['openid']);
        // 返回到前台
        $this->ajaxReturn(array(
            'status' => 1,
            'message' => '基础参数返回成功',
            'requestPayment' => $requestPayment,
        ));
    }

    /**
     * 功能：微信支付成功后，保存报名信息和支付记录
     */
    public function createRegisterAndPayrecords() {
        if(!$_POST['match_id'] || !$_POST['category_id'] || !$_POST['user_id'] || !$_POST['total_fee'] || !$_POST['out_trade_no']) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => 'Post信息不存在！',
            ));
        }
        // 比赛记录ID
        $match_id = I('post.match_id',0,'intval');
        // 比赛项目ID
        $category_id = I('post.category_id',0,'intval');
        // 用户ID
        $user_id = I('post.user_id',0,'intval');
        // 总金额
        $total_fee = I('post.total_fee',0,'float');
        // 商户订单号
        $out_trade_no = I('post.out_trade_no','','trim');
        // 备注信息
        $remark = I('post.remark','','trim');

        // 个人报名还是团队报名 0是个人报名，1是团队报名
        $category_type = I('post.category_type',0,'intval');
        // 选择的团队ID号码
        $team_id = I('post.checkTeamID',0,'intval');

        // 创建报名信息数组
        $registerArray = array(
            'match_id' => $match_id,
            'category_id' => $category_id,
            'user_id' => $user_id,
            'gmt_create' => date('Y-m-d H:i:s',time()),
            'team_id' => $team_id,
        );

        try {
            // 调用方法，写入报名信息
            $register = $this->createRegister($registerArray);
            if(!$register['status']) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '报名信息写入失败！' .  $register['message'],
                ));
            }
        } catch (Exception $exception) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => $exception->getMessage(),
            ));
        }

        // 创建交易记录信息数组
        $payrecordsArray = array(
            'user_id' => $user_id,
            'total_fee' => $total_fee,
            'out_trade_no' => $out_trade_no,
            'match_id' => $match_id,
            'category_id' => $category_id,
            'remark' => $remark,
            'register_id' => $register['register_id'],
            'gmt_create' => date('Y-m-d H:i:s',time()),
        );

        try {
            // 调用方法，写入交易信息
            $payrecords = $this->createPayrecords($payrecordsArray);
            if(!$payrecords['status']) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '交易记录写入失败！' . $payrecords['message'],
                ));
            }

            // 将交易记录ID写入报名表
            $registerNewArray = array(
                'payrecords_id' => $payrecords['payrecords_id'],
                'gmt_modify' => date('Y-m-d H:i:s',time()),
            );
            $newRegister = D('Register')->updateRegisterByID($register['register_id'],$registerNewArray);
            if(!$newRegister) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => '交易记录ID报名表写入失败！',
                ));
            }
        } catch (Exception $exception) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => $exception->getMessage(),
            ));
        }

        $this->ajaxReturn(array(
            'status' => 1,
            'message' => '报名信息和交易记录写入成功！',
            'register_id' => $register['register_id'],
            'team_id' => $team_id,
        ));
    }

    /**
     * 功能：将传递的数据写入报名信息表，并生成签到码
     * @param array $registerArray
     * @return array
     */
    private function createRegister($registerArray = array()) {
        if(!$registerArray || !is_array($registerArray)) {
            return array(
                'status' => 0,
                'message' => 'registerArray不存在！',
            );
        }

        try {
            // 写入数据库
            $register_id = D('Register')->createRegister($registerArray);
            if(!$register_id) {
                return array(
                    'status' => 0,
                    'message' => '数据库写入失败！'
                );
            }

            // 生成签到码
            $codeUrl = generateQrCode($register_id);

            // 将签到码写入数据库
            $registerNewArray = array(
                'sign_qrcode' => $codeUrl,
                'gmt_modify' => date('Y-m-d H:i:s',time()),
            );
            $newRegister = D('Register')->updateRegisterByID($register_id,$registerNewArray);
            if(!$newRegister) {
                return array(
                    'status' => 0,
                    'message' => '签到码写入失败！'
                );
            }
        } catch (Exception $exception) {
            return array(
                'status' => 0,
                'message' => $exception->getMessage(),
            );
        }

        // 返回结果
        return array (
            'status' => 1,
            'message' => '报名信息写入成功！',
            'register_id' => $register_id,
        );
    }

    /**
     * 功能：将交易信息写入数据库
     * @param array $payrecordsArray
     * @return array
     */
    private function createPayrecords($payrecordsArray = array()) {
        // 验证数据
        if(!$payrecordsArray || !is_array($payrecordsArray)) {
            return array(
                'status' => 0,
                'message' => 'payrecordsArray不存在！',
            );
        }
        try {
            // 写入交易记录信息
            $payrecords_id = D('Payrecords')->createPayrecords($payrecordsArray);
            // 验证结果
            if(!$payrecords_id) {
                return array(
                    'status' => 0,
                    'message' => '交易记录写入失败！',
                );
            }
            // 返回结果
            return array(
                'status' => 1,
                'message' => '交易记录写入成功！',
                'payrecords_id' => $payrecords_id,
            );
        } catch (Exception $exception) {
            return array(
                'status' => 0,
                'message' => $exception->getMessage(),
            );
        }
    }
}