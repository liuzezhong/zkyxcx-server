<?php
/**
 * Created by PhpStorm.
 * User: liuzezhong
 * Date: 2017/10/31
 * Time: 11:23
 */

namespace Weapp\Model;


use Think\Model;

class PayrecordsModel extends Model
{
    /**
     * 功能：新增交易记录信息
     * @param array $payrecordsArray
     * @return mixed
     */
    public function createPayrecords($payrecordsArray = array()) {
        if(!$payrecordsArray || !is_array($payrecordsArray)) {
            throw_exception('Weapp Model PayrecordsModel createPayrecords payrecordsArray is null');
        }
        return $this->add($payrecordsArray);
    }

    /**
     * 功能：查看是否存在交易记录
     * @param int $match_id
     * @param int $category_id
     * @param int $user_id
     * @return mixed
     */
    public function isPayrecords($match_id = 0, $category_id = 0, $user_id = 0) {
        if(!$match_id || !$category_id || !$user_id) {
            throw_exception('Weapp Model PayrecordsModel isPayrecords id is null');
        }
        $condition = array(
            'match_id' => $match_id,
            'category_id' => $category_id,
            'user_id' => $user_id,
        );
        return $this->where($condition)->find();
    }
}