<?php
/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-15
 * Time: 10:07
 */

namespace Activity\Model;


use Think\Model;

class EnrolModel extends Model {
    private $_db = '';

    public function __construct() {
        $this->_db = M('enrol');
    }

    public function addOneEnrol($data = array()) {
        if(!$data || !is_array($data)) {
            throw_exception('数据不存在！');
        }
        return $this->_db->add($data);
    }
}