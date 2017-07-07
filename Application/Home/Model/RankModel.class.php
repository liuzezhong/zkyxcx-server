<?php

/**
 * Created by PhpStorm.
 * User: PC41
 * Date: 2017-07-06
 * Time: 15:46
 */
namespace Home\Model;
use Think\Model;

class RankModel extends Model {
    private $_db = '';

    public function __construct() {
        $this->_db = M('rank');
    }

    public function selectAllRank() {
        return $this->_db->order('rankmoney desc')->select();
    }
}