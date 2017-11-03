<?php
/**
 * Created by PhpStorm.
 * User: liuzezhong
 * Date: 2017/10/24
 * Time: 14:21
 */

namespace Weapp\Model;


use Think\Model;

class SessionkeyModel extends Model
{
    /**
     * 功能：根据openid的值获取session信息
     * @param string $openid
     * @return mixed
     */
    public function getSessionKeyByOpenID ($openid = '') {
        if(!$openid || $openid == '') {
            throw_exception('Weapp Model SessionkeyModel getSessionKeyByOpenID openid is null');
        }
        $condition['openid'] = $openid;
        return $this->where($condition)->find();
    }

    /**
     * 功能： 新增一条sessionkey的记录
     * @param array $data
     * @return mixed
     */
    public function createSessionKey ($data = array()) {
        if(!$data || !is_array($data)) {
            throw_exception('Weapp Model SessionkeyModel createSessionKey data is null');
        }
        return $this->add($data);
    }

    /**
     * 功能：根据openid的值更新一条sessionkey记录
     * @param string $openid
     * @param array $data
     * @return bool
     */
    public function modifySessionKey ($openid = '', $data = array()) {
        if(!$openid || $openid == '') {
            throw_exception('Weapp Model SessionkeyModel modifySessionKey openid is null');
        }
        if(!$data || !is_array($data)) {
            throw_exception('Weapp Model SessionkeyModel modifySessionKey data is null');
        }
        $condition['openid'] = $openid;
        return $this->where($condition)->save($data);
    }

    /**
     * 功能：根据第三方sessionkey获取session信息
     * @param string $session3key
     * @return mixed
     */
    public function getSessionKeyBySession3key ($session3key = '') {
        if(!$session3key || $session3key == '') {
            throw_exception('Weapp Model SessionkeyModel getSessionKeyBySession3key session3key is null');
        }
        $condition['session3key'] = $session3key;
        return $this->where($condition)->find();
    }
}