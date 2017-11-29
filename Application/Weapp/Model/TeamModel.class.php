<?php
/**
 * Created by PhpStorm.
 * User: liuzezhong
 * Date: 2017/11/6
 * Time: 15:00
 */

namespace Weapp\Model;


use Think\Model;

class TeamModel extends Model
{
    /**
     * 功能：新增团队信息
     * @param array $teamArray
     * @return mixed
     */
    public function createTeam($teamArray = array()) {
        if(!$teamArray || !is_array($teamArray)) {
            throw_exception('Weapp Model TeamModel createTeam teamArray is null');
        }
        return $this->add($teamArray);
    }

    /**
     * 功能：根据用户ID查找创建的团队信息
     * @param int $user_id
     * @return mixed
     */
    public function listTeamByUserID($user_id = 0) {
        if(!$user_id) {
            throw_exception('Weapp Model TeamModel listTeamByUserID user_id is null');
        }
        $condition['user_id'] = $user_id;
        return $this->where($condition)->order('gmt_create desc')->select();
    }

    /**
     * 功能：根据团队名称和用户ID查看团队名称是否有重名
     * @param string $team_name
     * @param int $user_id
     * @return mixed
     */
    public function getTeamByTeamName($team_name = '', $user_id = 0) {
        if(!$user_id) {
            throw_exception('Weapp Model TeamModel getTeamByTeamName user_id is null');
        }
        if(!$team_name) {
            throw_exception('Weapp Model TeamModel getTeamByTeamName team_name is null');
        }
        $condition = array(
            'team_name' => $team_name,
            'user_id' => $user_id,
        );
        return $this->where($condition)->find();
    }

    /**
     * 功能：根据团队ID获取团队信息
     * @param int $team_id
     * @return mixed
     */
    public function getTeamByID($team_id = 0) {
        if(!$team_id) {
            throw_exception('Weapp Model TeamModel getTeamByID team_id is null');
        }
        $condition['team_id'] = $team_id;
        return $this->where($condition)->find();
    }

    /**
     * 功能：更新团队信息
     * @param int $team_id
     * @param array $teamArray
     * @return bool
     */
    public function updataTeam($team_id = 0, $teamArray = array()) {
        if(!$team_id) {
            throw_exception('Weapp Model TeamModel updataTeam team_id is null');
        }
        if(!$teamArray) {
            throw_exception('Weapp Model TeamModel updataTeam $teamArray is null');
        }
        $condition['team_id'] = $team_id;
        return $this->where($condition)->save($teamArray);
    }
}