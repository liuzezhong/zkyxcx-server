<?php
/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-06
 * Time: 15:45
 */

namespace Home\Controller;


use Think\Controller;
use Think\Exception;

class RankController extends Controller {
    public function index() {
        try {
            $ranks = D('rank')->selectAllRank();

            $proportion = $ranks[0]['rankmoney'];
            foreach($ranks as $key => $value) {
                $ranks[$key]['userName'] = $value['username'];
                unset($ranks[$key]['username']);

                $ranks[$key]['rankMoney'] = $value['rankmoney'];
                unset($ranks[$key]['rankmoney']);

                $ranks[$key]['userAvatarUrl'] = $value['avatarurl'];
                unset($ranks[$key]['avatarurl']);

                $ranks[$key]['percentage'] = number_format($value['rankmoney']/$proportion,2)*100 .'%';
            }
            $this->ajaxReturn($ranks);
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }

    }
}