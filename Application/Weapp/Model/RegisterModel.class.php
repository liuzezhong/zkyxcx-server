<?php
/**
 * Created by PhpStorm.
 * User: liuzezhong
 * Date: 2017/10/31
 * Time: 11:01
 */

namespace Weapp\Model;


use Think\Model;

class RegisterModel extends Model
{
    /**
     * 功能：写入用户报名信息
     * @param array $registerArray
     * @return mixed
     */
    public function createRegister($registerArray = array()) {
        if(!$registerArray || !is_array($registerArray)) {
            throw_exception('Weapp Model RegisterModel createRegister registerArray is null');
        }
        return $this->add($registerArray);
    }

    /**
     * 功能：根据报名信息ID修改报名信息
     * @param int $register_id
     * @param array $registerArray
     * @return bool
     */
    public function updateRegisterByID($register_id = 0, $registerArray = array()) {
        if(!$register_id) {
            throw_exception('Weapp Model RegisterModel updateRegisterByID register_id is null');
        }
        if(!$registerArray || !is_array($registerArray)) {
            throw_exception('Weapp Model RegisterModel updateRegisterByID registerArray is null');
        }
        $condition['register_id'] = $register_id;
        return $this->where($condition)->save($registerArray);
    }

    /**
     * 功能：根据条件查找是否存在报名记录
     * @param int $match_id
     * @param int $category_id
     * @param int $user_id
     * @return mixed
     */
    public function isRegister($match_id = 0, $category_id = 0, $user_id = 0) {
        if(!$match_id || !$category_id || !$user_id) {
            throw_exception('Weapp Model RegisterModel isRegister id is null');
        }
        $condition = array(
            'match_id' => $match_id,
            'category_id' => $category_id,
            'user_id' => $user_id,
        );
        return $this->where($condition)->find();
    }

    /**
     * 功能：根据比赛ID查找已经报名的用户信息
     * @param int $match_id
     * @return mixed
     */
    public function getRegisterByMatchID($match_id = 0) {
        if(!$match_id) {
            throw_exception('Weapp Model getRegisterByMatchID match_id id is null');
        }
        $condition['match_id'] = $match_id;
        return $this->where($condition)->select();
    }

    /**
     * 功能：根据比赛ID计算记录数
     * @param int $match_id
     * @return mixed
     */
    public function countRegisterByMatchID($match_id = 0) {
        if(!$match_id) {
            throw_exception('Weapp Model countRegisterByMatchID match_id is null');
        }
        $condition['match_id'] = $match_id;
        return $this->where($condition)->count('user_id');
    }

    /**
     * 功能：搜索用户参赛记录
     * @param int $user_id
     * @return mixed
     */
    public function listRegisterByUserID($user_id = 0) {
        if(!$user_id) {
            throw_exception('Weapp Model listRegisterByUserID user_id is null');
        }
        $condition['user_id'] = $user_id;
        return $this->where($condition)->select();
    }

    /**
     * 功能：获取用户报名信息
     * @param int $register_id
     * @return mixed
     */
    public function getRegisterByID($register_id = 0) {
        if(!$register_id) {
            throw_exception('Weapp Model getRegisterByID register_id is null');
        }
        $condition['register_id'] = $register_id;
        return $this->where($condition)->find();
    }

    /**
     * 功能：查看用户已经报名几项
     * @param int $user_id
     * @param int $match_id
     * @return mixed
     */
    public function countRegisterByUserID($user_id = 0 ,$match_id = 0) {
        if(!$user_id || !$match_id) {
            throw_exception('Weapp Model countRegisterByUserID id is null');
        }
        $condition = array(
            'user_id' => $user_id,
            'match_id' => $match_id,
        );
        return $this->where($condition)->count('register_id');
    }
}