<?php
/**
 * Created by PhpStorm.
 * User: liuzezhong
 * Date: 2017/11/6
 * Time: 15:02
 */

namespace Weapp\Model;


use Think\Model;

class TeamuserModel extends Model
{
    /**
     * 功能：新增团队用户信息
     * @param array $teamUserArray
     * @return mixed
     */
    public function createTeamUser($teamUserArray = array()) {
        if(!$teamUserArray || !is_array($teamUserArray)) {
            throw_exception('Weapp Model TeamuserModel createTeamUser teamUserArray is null');
        }
        return $this->add($teamUserArray);
    }

    /**
     * 功能：获取团队成员信息
     * @param int $team_id
     * @return mixed
     */
    public function getTeamUserByTeamID($team_id = 0) {
        if(!$team_id) {
            throw_exception('Weapp Model TeamuserModel getTeamUserByTeamID team_id is null');
        }
        $condition['team_id'] = $team_id;
        return $this->where($condition)->select();
    }

    /**
     * 功能：删除团队成员信息
     * @param int $team_id
     * @return mixed
     */
    public function deleteTeamUserByTeamID($team_id = 0) {
        if(!$team_id) {
            throw_exception('Weapp Model TeamuserModel deleteTeamUserByTeamID team_id is null');
        }
        $condition['team_id'] = $team_id;
        return $this->where($condition)->delete();
    }
}