<?php
/**
 * Created by PhpStorm.
 * User: liuzezhong
 * Date: 2017/10/24
 * Time: 10:03
 */

namespace Weapp\Model;

use Think\Model;

class CategoryModel extends Model
{
    /**
     * 功能：根据比赛ID获取所有相关类目信息
     * @param int $match_id
     * @return mixed
     */
    public function listCategoryOfMatch ($match_id = 0) {
        if($match_id == 0) {
            throw_exception('Weapp Model CategoryModel listCategoryOfMatch match_id is null');
        }
        $condition['match_id'] = $match_id;
        return $this->where($condition)->select();
    }

    /**
     * 功能：根据比赛项目ID获取比赛项目信息
     * @param int $category_id
     * @return mixed
     */
    public function getCategoryOfMatch($category_id = 0) {
        if($category_id == 0) {
            throw_exception('Weapp Model CategoryModel getCategoryOfMatch category_id is null');
        }
        $condition['category_id'] = $category_id;
        return $this->where($condition)->find();
    }
}