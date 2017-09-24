<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" ">
    <title>中铠云|街区体育</title>

    <!-- Bootstrap -->
    <link href="Public/css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="Public/fonts/fontawesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="Public/plugin/jquery-span/jq22.css">

    <link rel="stylesheet" href="Public/plugin/bootstrap-datepicker/css/bootstrap-datepicker.min.css">

    <link rel="stylesheet" href="Public/plugin/bootstrap-from-validation/css/formValidation.css"/>

    <link href="Public/plugin/uploadify/uploadify.css" rel="stylesheet">

    <link href="Public/plugin/bootstrap-switch/css/bootstrap3/bootstrap-switch.css" rel="stylesheet">

    <link rel="stylesheet" href="Public/css/zhongkai/common.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->







</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">中铠云</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">创建赛事</a></li>
                <li><a href="#">发现活动</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">发现活动 <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">篮球</a></li>
                        <li><a href="#">羽毛球</a></li>
                        <li><a href="#">乒乓球</a></li>
                        <li class="divider"></li>
                        <li><a href="#">游泳比赛</a></li>
                        <li class="divider"></li>
                        <li><a href="#">拳击比赛</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="篮球比赛……">
                </div>
                <button type="submit" class="btn btn-default">搜索</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">管理赛事</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <form class="form-inline">
                <select class="form-control select" id="select-tasks">
                    <option>请选择</option>
                    <?php if(is_array($alltasks)): $i = 0; $__LIST__ = $alltasks;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$task): $mod = ($i % 2 );++$i;?><option value="<?php echo ($task["tasks_id"]); ?>"><?php echo ($task["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </form>
        </div>
        <div class="col-md-6">
            <button class="btn btn-success" id="enrol-export" tasks_id="<?php echo ($tasks["tasks_id"]); ?>">导出</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <p><?php echo ($tasks["title"]); ?>+<?php echo ($tasks["tasks_id"]); ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-center">报名序号</th>
                        <th class="text-center">项目名称</th>
                        <th class="text-center">报名费用(元）</th>
                        <th class="text-center">支付状态</th>
                        <?php if(is_array($name)): $i = 0; $__LIST__ = $name;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$name): $mod = ($i % 2 );++$i;?><th class="text-center"><?php echo ($name); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
                        <th class="text-center">报名时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($enrols)): $i = 0; $__LIST__ = $enrols;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$enrol): $mod = ($i % 2 );++$i;?><tr>
                            <td class="text-center"><?php echo ($enrol["id"]); ?></td>
                            <td class="text-center"><?php echo ($enrol["title"]); ?></td>
                            <td class="text-center"><?php echo ($enrol["price"]); ?></td>
                            <td class="text-center"><?php echo ($enrol["pay_status"]); ?></td>
                            <?php if(is_array($enrol["value"])): $i = 0; $__LIST__ = $enrol["value"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><td class="text-center"><?php echo ($value); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                            <td class="text-center"><?php echo ($enrol["create_time"]); ?></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<!--
<footer class="footer">
    <small>
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                            <h5>网站相关</h5>
                            <div class="row">
                                <div class="col-md-8">
                                    <hr>
                                </div>
                            </div>

                            <ul class="list-unstyled">
                                <li class="footer-font-li"><a href="/about/" class="footer-font-a-color a-t">关于我们</a></li>
                                <li class="footer-font-li"><a href="/ad/" class="footer-font-a-color a-t">服务条款</a></li>
                                <li class="footer-font-li"><a href="/links/" class="footer-font-a-color a-t">帮助中心</a></li>
                                <li class="footer-font-li"><a href="/hr/" class="footer-font-a-color a-t">每周精选</a></li>
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <h5>联系合作</h5>
                            <div class="row">
                                <div class="col-md-8">
                                    <hr>
                                </div>
                            </div>

                            <ul class="list-unstyled">
                                <li class="footer-font-li"><a href="http://weibo.com/bootcss" title="Bootstrap中文网官方微博" target="_blank" class="footer-font-a-color a-t">联系我们</a></li>
                                <li class="footer-font-li"><a href="mailto:admin@bootcss.com" class="footer-font-a-color a-t">加入我们</a></li>
                                <li class="footer-font-li"><a href="mailto:admin@bootcss.com" class="footer-font-a-color a-t">合作伙伴</a></li>
                                <li class="footer-font-li"><a href="mailto:admin@bootcss.com" class="footer-font-a-color a-t">媒体报道</a></li>
                                <li class="footer-font-li"><a href="mailto:admin@bootcss.com" class="footer-font-a-color a-t">建议反馈</a></li>
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <h5>获得帮助</h5>
                            <div class="row">
                                <div class="col-md-8">
                                    <hr>
                                </div>
                            </div>

                            <ul class="list-unstyled">
                                <li class="footer-font-li"><a href="http://www.golaravel.com/" target="_blank" class="footer-font-a-color a-t">支持中心</a></li>
                                <li class="footer-font-li"><a href="http://www.ghostchina.com/" target="_blank" class="footer-font-a-color a-t">常见问题</a></li>
                                <li class="footer-font-li"><a href="http://www.ghostchina.com/" target="_blank" class="footer-font-a-color a-t">联系我们</a></li>
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <h5>关注我们</h5>
                            <div class="row">
                                <div class="col-md-10">
                                    <hr>
                                </div>
                            </div>
                            <ul class="list-unstyled">
                                <li class="footer-font-li"><a href="https://www.upyun.com" target="_blank" class="footer-font-a-color a-t">团队日志</a></li>
                                <li class="footer-font-li"><a href="https://www.upyun.com" target="_blank" class="footer-font-a-color a-t">产品技术日志</a></li>
                                <li class="footer-font-li"><a href="https://www.upyun.com" target="_blank" class="footer-font-a-color a-t">社区运营日志</a></li>
                                <li class="footer-font-li"><a href="https://www.upyun.com" target="_blank" class="footer-font-a-color a-t">市场运营日志</a></li>
                            </ul>
                        </div>

                        <div class="col-md-4">
                            <h5>社交媒体</h5>
                            <div class="row">
                                <div class="col-md-11">
                                    <hr>
                                </div>
                            </div>
                            <ul class="list-unstyled list-inline">
                                <li ><a href="https://www.upyun.com" target="_blank" class="a-t"><i class="fa fa-twitter-square fa-fw fa-2x"></i></a></li>
                                <li ><a href="https://www.upyun.com" target="_blank" class="a-t"><i class="fa fa-facebook-square fa-fw fa-2x"></i></a></li>
                                <li ><a href="https://www.upyun.com" target="_blank" class="a-t"><i class="fa fa-github-square fa-fw fa-2x"></i></a></li>
                                <li ><a href="https://www.upyun.com" target="_blank" class="a-t"><i class="fa fa-google-plus-square fa-fw fa-2x"></i></a></li>
                                <li ><a href="https://www.upyun.com" target="_blank" class="a-t"><i class="fa fa-linkedin-square fa-fw fa-2x"></i></a></li>
                                <li ><a href="https://www.upyun.com" target="_blank" class="a-t"><i class="fa fa-weibo fa-fw fa-2x"></i></a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</footer>
<footer class="bg-footers-beian">
    <div>
        <div class="container footer-bottom-ba bg-footers-beian">
            <ul class="list-unstyled list-inline text-center">
                <li >&copy; 2016-2017 <a href="http://www.zhongkaiyun.com" class="a-t">ZKY</a> Ltd.</li>&nbsp;|
                <li ><a href="/blog/" class="a-t">Blog <i class="fa fa-rss"></i></a></li>&nbsp;|
                <li ><a href="/newsletter/subscribe/" class="a-t">Newsletter <i class="fa fa-envelope-o"></i></a></li>&nbsp;|
                <li><a href="http://www.miibeian.gov.cn/" target="_blank" class="a-t">京ICP备11008151号</a></li>&nbsp;|<li>京公网安备11010802014853</li>
            </ul>


        </div>&lt;!&ndash; end .container &ndash;&gt;</small>
    </div>
</footer>
-->



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="Public/js/jquery/jquery-1.11.1.js"></script>

<script src="Public/plugin/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="Public/plugin/bootstrap-datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>

<script type="text/javascript" src="Public/plugin/bootstrap-from-validation/js/formValidation.js"></script>
<script type="text/javascript" src="Public/plugin/bootstrap-from-validation/js/framework/bootstrap.js"></script>
<script type="text/javascript" src="Public/plugin/bootstrap-from-validation/js/language/zh_CN.js"></script>

<script type="text/javascript" src="Public/plugin/bootstrap-switch/js/bootstrap-switch.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="Public/js/bootstrap/bootstrap.js"></script>
<script src="/weapp.zhongkaiyun.com/Public/plugin/uploadify/jquery.uploadify.js"></script>

<script src="Public/js/drag/drag.js"></script>

<script src="Public/js/dialog/layer/layer.js"></script>
<script src="Public/js/dialog/dialog.js"></script>

<script type="text/javascript" src="Public/js/zhongkai/common.js"></script>


</body>
</html>