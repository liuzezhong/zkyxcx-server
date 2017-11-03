<?php
/**
 * Created by PhpStorm.
 * User: liuzezhong
 * Date: 2017/10/23
 * Time: 10:32
 */
namespace Weapp\Model;
class MatchModel extends \Think\Model
{
    /**
     * 功能：获取所有赛事信息记录
     * @return mixed
     */
    public function listAllMatchRecords () {
        // 根据创建时间降序查找
        return $this->order('gmt_create desc')->select();
    }

    /**
     * 功能：获取所有未结束（有效）的赛事记录
     * @return mixed
     */
    public function listAllMatchRecordsUnfinished () {
        // 查询条件，0为未完成，1为已完成状态
        $condition['is_finish'] = 0;
        // 根据创建时间降序查找
        return $this->where($condition)->order('gmt_create desc')->select();
    }

    /**
     * 功能：根据比赛ID查找比赛信息
     * @param int $match_id
     * @return mixed
     */
    public function getMatchInfoByID ($match_id = 0) {
        if($match_id == 0) {
            throw_exception('Weapp Model MatchModel getMatchInfoByID match_id is null');
        }
        $condition['match_id'] = $match_id;
        return $this->where($condition)->find();
    }

    /**
     * 功能：根据比赛ID将查看次数字段增1
     * @param int $match_id
     * @return bool
     */
    public function increaseViewTimes ($match_id = 0) {
        if($match_id == 0) {
            throw_exception('Weapp Model MatchModel increaseViewTimes match_id is null');
        }
        $condition['match_id'] = $match_id;
        return $this->where($condition)->setInc("view_times",1);

    }

}