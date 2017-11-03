<?php
/**
 * Created by PhpStorm.
 * User: liuzezhong
 * Date: 2017/10/23
 * Time: 15:17
 */

namespace Weapp\Model;


use Think\Model;

class ImageModel extends Model
{
    /**
     * 功能：查找与比赛关联的宣传图片信息，如果有多张只选第一张
     * @param int $match_id
     * @return mixed
     */
    public function getImageOfMatch ($match_id = 0) {
        if($match_id == 0) {
            throw_exception('Weapp Model ImageModel getImageOfMatch match_id is null');
        }
        $condition['match_id'] = $match_id;
        return $this->where($condition)->field('image_url')->find();
    }

    /**
     * 功能：根据比赛ID获取所有相关联的图片信息
     * @param int $match_id
     * @return mixed
     */
    public function listImageOfMatch ($match_id = 0) {
        if($match_id == 0) {
            throw_exception('Weapp Model ImageModel listImageOfMatch match_id is null');
        }
        $condition = array(
            'match_id' => $match_id,
            'is_status' => 1,
        );
        return $this->where($condition)->select();
    }
}