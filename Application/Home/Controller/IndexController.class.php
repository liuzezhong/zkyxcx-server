<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        //$url = 'http://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=LyBSIP1wlVXKohV4LSkHnTyUGIjUm1cdx-Duoz5UqGDY7O4aUb8itHLSykhJXolP7jMq42nxURGy3BTdR1sA9HG56WY7Tt8WcBfJ4Q1xl8VF--5y0aPkjPvYBbeomwO4JZSfAGAWMF';
        $url = 'http://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=LyBSIP1wlVXKohV4LSkHnTyUGIjUm1cdx-Duoz5UqGDY7O4aUb8itHLSykhJXolP7jMq42nxURGy3BTdR1sA9HG56WY7Tt8WcBfJ4Q1xl8VF--5y0aPkjPvYBbeomwO4JZSfAGAWMF';
        $data = array(
            'scene' => 23,
            'width' => 430,
            'auto_color' => false,
        );
        $postData = json_encode($data);
        print_r($postData);
        $httpstr = D('Common')->http($url, $postData, 'POST', array("Content-type: text/html; charset=utf-8"));
        //$decode_http = json_decode($httpstr,true);
        print_r($httpstr);
        $this->display();
    }
}