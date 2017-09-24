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
        <div class="col-md-3">
            <div class="list-group">
                <?php if($tasks_id != is_null()): ?><a href="#" class="list-group-item active">
                        <i class="fa fa-check-circle fa-fw" ></i>&nbsp;&nbsp;创建赛事活动主体信息
                    </a>
                    <?php else: ?>
                    <a href="#" class="list-group-item active">
                        <i class="fa fa-circle-thin fa-fw" ></i>&nbsp;&nbsp;创建赛事活动主体信息
                    </a><?php endif; ?>
                <?php if($tasks_id != is_null()): if($project_status == 1): ?><a href="<?php echo U('activity/index/project');?>&tasks_id=<?php echo ($tasks_id); ?>&project_status=<?php echo ($project_status); ?>&registration=<?php echo ($registration); ?>" class="list-group-item" style="color: #2780E3;">
                            <i class="fa fa-check-circle fa-fw" ></i>&nbsp;&nbsp;创建赛事活动收费项目
                        </a>
                        <?php else: ?>
                        <a href="<?php echo U('activity/index/project');?>&tasks_id=<?php echo ($tasks_id); ?>&project_status=<?php echo ($project_status); ?>&registration=<?php echo ($registration); ?>" class="list-group-item" style="color: #2780E3;">
                            <i class="fa fa-circle-thin fa-fw" ></i>&nbsp;&nbsp;创建赛事活动收费项目
                        </a><?php endif; ?>
                    <?php else: ?>
                    <a href="#" class="list-group-item">
                        <i class="fa fa-circle-thin fa-fw" ></i>&nbsp;&nbsp;创建赛事活动收费项目
                    </a><?php endif; ?>
                <?php if($project_status == 1): if($registration == 1): ?><a href="<?php echo U('activity/index/registration');?>&tasks_id=<?php echo ($tasks_id); ?>&project_status=<?php echo ($project_status); ?>&registration=<?php echo ($registration); ?>" class="list-group-item" style="color: #2780E3;">
                            <i class="fa fa-check-circle fa-fw"></i>&nbsp;&nbsp;创建赛事活动报名信息
                        </a>
                        <?php else: ?>
                        <a href="<?php echo U('activity/index/registration');?>&tasks_id=<?php echo ($tasks_id); ?>&project_status=<?php echo ($project_status); ?>&registration=<?php echo ($registration); ?>" class="list-group-item" style="color: #2780E3;">
                            <i class="fa fa-circle-thin fa-fw"></i>&nbsp;&nbsp;创建赛事活动报名信息
                        </a><?php endif; ?>

                    <?php else: ?>
                    <a href="#" class="list-group-item" >
                        <i class="fa fa-circle-thin fa-fw"></i>&nbsp;&nbsp;创建赛事活动报名信息
                    </a><?php endif; ?>
                <?php if($registration == 1): ?><a href="<?php echo U('activity/index/form');?>&tasks_id=<?php echo ($tasks_id); ?>&project_status=<?php echo ($project_status); ?>&registration=<?php echo ($registration); ?>" class="list-group-item" style="color: #2780E3;">
                        <i class="fa fa-circle-thin fa-fw"></i>&nbsp;&nbsp;生成管理赛事活动信息
                    </a>
                    <?php else: ?>
                    <a href="#" class="list-group-item">
                        <i class="fa fa-circle-thin fa-fw"></i>&nbsp;&nbsp;生成管理赛事活动信息
                    </a><?php endif; ?>

            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-dismissible alert-warning">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4>请注意！</h4>
                        <p>如果非赛事官方组织者，请勿其名义发布赛事活动募集，否则中铠云有权采取相应行动。</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body ">
                            <div class="col-md-12">
                                <form class="form-horizontal">
                                    <fieldset>
                                        <legend>活动主体信息</legend>
                                        <div class="form-group" id="activity-name">
                                            <label for="inputEmail" class="col-lg-2 control-label">赛事活动名称</label>
                                            <div class="col-lg-10">
                                                <input type="text" class="form-control" name="name" placeholder="请输入赛事活动名称" value="<?php echo ($tasks["title"]); ?>">
                                                <span class="help-block" id="activity-name-info"></span>
                                            </div>
                                        </div>
                                        <div class="form-group" id="activity-category">
                                            <label for="select" class="col-lg-2 control-label">赛事活动分类</label>
                                            <div class="col-lg-10">
                                                <select class="form-control" id="select">
                                                    <option value="0">请选择<?php echo ($tasks["category"]); ?></option>
                                                    <?php if(is_array($events)): $i = 0; $__LIST__ = $events;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$event): $mod = ($i % 2 );++$i; if($event['event_id'] == $tasks['category']): ?><option value="<?php echo ($event["event_id"]); ?>" selected><?php echo ($event["name"]); ?></option>
                                                            <?php else: ?>
                                                            <option value="<?php echo ($event["event_id"]); ?>"><?php echo ($event["name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                                </select>
                                                <span class="help-block" id="activity-category-info"></span>
                                            </div>
                                        </div>
                                        <div class="form-group" id="activity-date">
                                            <label for="inputEmail" class="col-lg-2 control-label">活动日期范围</label>
                                            <div class="col-lg-10">
                                                <div class="row">
                                                    <div class="col-md-6" id="activity-begaindate">
                                                        <input type="text" class="form-control sandbox-container" name="begain_date" placeholder="活动开始日期" value="<?php echo ($tasks["start_time"]); ?>">
                                                        <span class="help-block" id="activity-begaindate-info"></span>
                                                    </div>



                                                    <div class="col-md-6" id="activity-enddate">
                                                        <input type="text" class="form-control sandbox-container" name="end_date" placeholder="活动截止日期" value="<?php echo ($tasks["end_time"]); ?>">
                                                        <span class="help-block" id="activity-enddate-info"></span>
                                                    </div>
                                                </div>
                                                <span class="help-block" id="activity-date-info"></span>
                                            </div>
                                        </div>
                                        <div class="form-group" id="activity-description">
                                            <label for="textArea" class="col-lg-2 control-label">活动简介规程</label>
                                            <div class="col-lg-10">
                                                <textarea class="form-control" rows="3" name="textArea" id="textArea"><?php echo ($tasks["description"]); ?></textarea>
                                                <span class="help-block" id="activity-description-info">请列出将要举办赛事活动的相关简介或竞赛规程，并详细介绍活动信息。</span>
                                            </div>
                                        </div>
                                        <div class="form-group" id="activity-leader">
                                            <label for="inputEmail" class="col-lg-2 control-label">举办方负责人</label>
                                            <div class="col-lg-10">
                                                <input type="text" class="form-control" name="leader" placeholder="请输入该活动主要负责人姓名" value="<?php echo ($tasks["leader"]); ?>">
                                                <span class="help-block" id="activity-leader-info"></span>
                                            </div>
                                        </div>
                                        <div class="form-group" id="activity-contact">
                                            <label for="inputEmail" class="col-lg-2 control-label">主要联系方式</label>
                                            <div class="col-lg-10">
                                                <input type="text" class="form-control" name="contact" placeholder="请输入主要负责人的联系方式" value="<?php echo ($tasks["contact"]); ?>">
                                                <span class="help-block" id="activity-contact-info"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-10 col-lg-offset-2">
                                                <!--<button type="reset" class="btn btn-default">取消创建</button>-->
                                                <?php if($tasks_id != is_null()): ?><button type="button" class="btn btn-primary btn-block" id="create-activity-body" attr-tasks_id="<?php echo ($tasks_id); ?>"><i class="fa fa-check fa-fw"></i>&nbsp;&nbsp;保存修改</button>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-primary btn-block" id="create-activity-body"><i class="fa fa-check fa-fw"></i>&nbsp;&nbsp;确认创建</button><?php endif; ?>

                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">

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