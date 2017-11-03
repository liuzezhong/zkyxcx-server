<?php
/**
 * Created by PhpStorm.
 * User: liuzezhong
 * Date: 2017-10-23
 * Time: 10:35
 */

namespace Weapp\Model;
use Think\Model;

class EventModel extends Model {
    /**
     * 功能：根据运动类别ID查找运动项目名称
     * @param int $event_id
     * @return mixed
     */
    public function getEventName ($event_id = 0) {
        if($event_id == 0) {
            throw_exception('Weapp Model EventModel getEventName event_id is null');
        }
        $condition['event_id'] = $event_id;
        return $this->where($condition)->field('name')->find();
    }
}