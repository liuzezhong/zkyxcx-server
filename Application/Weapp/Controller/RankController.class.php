<?php
/**
 * Created by PhpStorm.
 * User: liuzezhong
 * Date: 2017/11/9
 * Time: 13:50
 */

namespace Weapp\Controller;


use Think\Exception;

class RankController extends BaseController
{
    /**
     * 解密微信运动的数据并写入数据库
     */
    public function decEnData() {
        // 加密数据
        $encryptedData = I('post.encryptedData','','trim,string');
        // 偏移向量
        $iv = I('post.iv','','trim,string');
        // 用户session
        $session3Key = I('post.sessionKey','','trim,string');
        // 根据第三方sessionkey获取session信息
        $session_key = D('Sessionkey')->getSessionKeyBySession3key($session3Key);

        // 调用微信解密类
        $wxCrypt = new WXBizDataCrypt(C('WECHAT_SMALL_APPLICATION')['APPID'],$session_key['session_key']);
        // 用户30天步数列表
        $stepInfoList = $wxCrypt->decryptData($encryptedData, $iv);
        $stepInfoList = json_decode($stepInfoList,true)['stepInfoList'];

        if($stepInfoList) {
            // 累加30天的步数
            $stepSum = 0;
            foreach ($stepInfoList as $key => $item) {
                $stepSum = $stepSum + intval($item['step']);
            }
            // 写入数据库
            try {
                $saveStepSum = D('Wxuser')->saveUserInfoByOpenID($session_key['openid'],array('step_sum' => $stepSum));

                $this->ajaxReturn(array(
                    'status' => 1,
                    'message' => '微信步数写入成功',
                ));
            } catch (Exception $exception) {
                $this->ajaxReturn(array(
                    'status' => 0,
                    'message' => $exception->getMessage(),
                ));
            }
        }else {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '微信步数获取失败',
            ));
        }
    }

    /**
     * 获取所有排行榜，包括30天运动步数，群排行，身价排行
     */
    public function getRankList() {
        // 用户session
        $session3Key = I('post.sessionKey','','trim,string');
        // 根据第三方sessionkey获取session信息
        if(!$session3Key) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '用户session为空',
            ));
        }
        $session_key = D('Sessionkey')->getSessionKeyBySession3key($session3Key);
        if(!$session_key) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => 'session_key不存在',
            ));
        }

        // 获取当前用户信息
        $user = D('Wxuser')->getUserByOpenID($session_key['openid']);
        if(!$user) {
            $this->ajaxReturn(array(
                'status' => 0,
                'message' => '用户信息不存在',
            ));
        }

        // 获取30天运动步数排行信息
        $userStepList = D('Wxuser')->listUserOrderStep();
        // 获取有身价的排行信息
        $userWorthList = D('Wxuser')->listUserOrderWorth();
        // 计算当前用户的微信步数排行
        $user['step_rank'] = 0;
        $user['worth_rank'] = 0;
        foreach ($userStepList as $key => $value) {
            if($value['step_sum'] <= $user['step_sum']) {
                $user['step_rank'] = $key+1;
                break;
            }
        }
        if($user['step_rank'] == 0) {
            $user['step_rank'] = count($userStepList) + 1;
        }
        // 计算当前用户的身价信息排行
        foreach ($userWorthList as $key => $value) {
            if($value['worth_list'] <= $user['worth_list']) {
                $user['worth_rank'] = $key+1;
                break;
            }
        }
        if($user['worth_rank'] == 0) {
            $user['worth_rank'] = count($userWorthList) + 1;
        }

        $this->ajaxReturn(array(
           'status' => 1,
           'message' => '排行信息查找成功',
           'user' => $user,
           'userStepList' => $userStepList,
           'userWorthList'  => $userWorthList,
        ));
    }
}