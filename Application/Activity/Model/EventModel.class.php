<?php
/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-13
 * Time: 10:35
 */

namespace Activity\Model;


use Think\Model;

class EventModel extends Model {
    private $_db = '';

    public function __construct() {
        $this->_db = M('event');
    }

    public function selectALLEvent() {
        return $this->_db->where('status != ' . -1)->select();
    }
}