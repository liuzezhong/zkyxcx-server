/**
 * Created by PC41 on 2017-07-12.
 */
$('.sandbox-container').datepicker({
    language: "zh-CN",
    orientation: "bottom auto",
    todayHighlight: true
});

$('#create-activity-body').click(function () {

    var title = $('input[name = "name"]').val();
    var category = $('#select').val();
    var start_time = $('input[name = "begain_date"]').val();
    var end_time = $('input[name = "end_date"]').val();
    var description = $('textarea[name = "textArea"]').val();
    var leader = $('input[name = "leader"]').val();
    var contact = $('input[name = "contact"]').val();
    var zmobile = /^(1[34578]\d{9})$/;  //手机号码验证
    var tasks_id = $(this).attr('attr-tasks_id');

    if(title) {
        var oldClass = $('#activity-name').attr('class');
        var newClass = oldClass.replace(' has-error','');
        $('#activity-name').attr('class',newClass);
        $('#activity-name-info').html('');
    }else if(!title) {
        var oldClass = $('#activity-name').attr('class');
        $('#activity-name').attr('class',oldClass+' has-error');
        $('#activity-name-info').html('赛事活动名称不能为空！');
        return ;
    }

    if(category == 0) {
        var oldClass = $('#activity-category').attr('class');
        $('#activity-category').attr('class',oldClass+' has-error');
        $('#activity-category-info').html('请选择赛事活动类别！');
        return ;
    }else {
        var oldClass = $('#activity-category').attr('class');
        var newClass = oldClass.replace(' has-error','');
        $('#activity-category').attr('class',newClass);
        $('#activity-category-info').html('');
    }

    if(start_time) {
        var oldClass = $('#activity-begaindate').attr('class');
        var newClass = oldClass.replace(' has-error','');
        $('#activity-begaindate').attr('class',newClass);
        $('#activity-begaindate-info').html('');
    } else if(!start_time) {
        var oldClass = $('#activity-begaindate').attr('class');
        $('#activity-begaindate').attr('class',oldClass+' has-error');
        $('#activity-begaindate-info').html('赛事开始时间不能为空！');
        return ;
    }

    if(end_time) {
        var oldClass = $('#activity-enddate').attr('class');
        var newClass = oldClass.replace(' has-error','');
        $('#activity-enddate').attr('class',newClass);
        $('#activity-enddate-info').html('');
    } else if(!end_time) {
        var oldClass = $('#activity-enddate').attr('class');
        $('#activity-enddate').attr('class',oldClass+' has-error');
        $('#activity-enddate-info').html('赛事结束时间不能为空！');
        return ;
    }

    start_time = start_time.replace('年','-');
    start_time = start_time.replace('月','-');
    start_time = start_time.replace('日','');
    start_time = $.trim(start_time);
    start_time = start_time + ' 00:00:00'
    start_time = Date.parse(new Date(start_time));
    start_time = start_time / 1000;

    end_time = end_time.replace('年','-');
    end_time = end_time.replace('月','-');
    end_time = end_time.replace('日','');
    end_time = $.trim(end_time);
    end_time = end_time + ' 00:00:00'
    end_time = Date.parse(new Date(end_time));
    end_time = end_time / 1000;

    if(start_time > end_time) {
        var oldClass = $('#activity-date').attr('class');
        $('#activity-date').attr('class',oldClass+' has-error');
        $('#activity-date-info').html('活动开始时间不能晚于活动结束时间！');
        return ;
    }else {
        var oldClass = $('#activity-date').attr('class');
        var newClass = oldClass.replace(' has-error','');
        $('#activity-date').attr('class',newClass);
        $('#activity-date-info').html('');
    }

    if(description) {
        var oldClass = $('#activity-description').attr('class');
        var newClass = oldClass.replace(' has-error','');
        $('#activity-description').attr('class',newClass);
    }else if(!description) {
        var oldClass = $('#activity-description').attr('class');
        $('#activity-description').attr('class',oldClass+' has-error');
        return ;
    }

    if(leader) {
        var oldClass = $('#activity-leader').attr('class');
        var newClass = oldClass.replace(' has-error','');
        $('#activity-leader').attr('class',newClass);
        $('#activity-leader-info').html('');
    }else if(!leader) {
        var oldClass = $('#activity-leader').attr('class');
        $('#activity-leader').attr('class',oldClass+' has-error');
        $('#activity-leader-info').html('赛事活动负责人姓名不能为空！');
        return ;
    }

    if(contact) {
        var oldClass = $('#activity-contact').attr('class');
        var newClass = oldClass.replace(' has-error','');
        $('#activity-contact').attr('class',newClass);
        $('#activity-contact-info').html('');
    }else if(!contact) {
        var oldClass = $('#activity-contact').attr('class');
        $('#activity-contact').attr('class',oldClass+' has-error');
        $('#activity-contact-info').html('赛事活动负责人联系方式不能为空！');
        return ;
    }

    if(!zmobile.test(contact)) {
        var oldClass = $('#activity-contact').attr('class');
        $('#activity-contact').attr('class',oldClass+' has-error');
        $('#activity-contact-info').html('请输入正确的手机号码！');
        return ;
    }else if(zmobile.test(contact)) {
        var oldClass = $('#activity-contact').attr('class');
        var newClass = oldClass.replace(' has-error','');
        $('#activity-contact').attr('class',newClass);
        $('#activity-contact-info').html('');
    }
    var postUrl = '/index.php?m=activity&c=index&a=checkActivityBody';
    var jumpUrl = '/index.php?m=activity&c=index&a=project';
    var postData = {
        'title' : title,
        'category' : category,
        'start_time' : start_time,
        'end_time' : end_time,
        'description' : description,
        'leader' : leader,
        'contact' : contact,
        'tasks_id' : tasks_id,
    };

    $.post(postUrl,postData,function (result) {
        if(result.status == 0) {
            return dialog.msg(result.message);
        }else if(result.status == 1) {
            //return dialog.msg(result.message);
            jumpUrl = jumpUrl + '&tasks_id=' + result.tasks_id;
            console.log(jumpUrl);
            return dialog.msg_url(result.message,jumpUrl);

        }
    },'JSON');
});

$('.add-one-project').click(function () {
    $('.add-project-list').append('<div class="col-md-6">'
        +'<div class="panel panel-default">'
        +'<div class="panel-body">'
        +'<button type="button" class="close project-close" aria-label="Close"><i class="fa fa-times-circle" style="color: red;"  id="project-close"></i></button>'
        +'<div class="col-md-12">'
        +'<form class="form-horizontal">'
        +'<fieldset>'
        +'<div class="form-group" id="activity-name">'
        +'<div class="col-lg-12">'
        +'<input type="text" class="form-control" name="title[]" placeholder="竞赛项目/分组名称">'
        +'<span class="help-block" id="activity-name-info"></span>'
        +'</div>'
        +'</div>'
        +'<div class="form-group" id="activity-contact">'
        +'<div class="col-lg-12">'
        +'<input type="text" class="form-control" name="price[]" placeholder="每人收费价格，免费请填0">'
        +'<span class="help-block" id="activity-contact-info"></span>'
        +'</div>'
        +'</div>'
        +'</fieldset>'
        +'</form>'
        +'</div>'
        +'</div>'
        +'</div>'
        +'</div>');

});

$('.add-project-list').on('click','.project-close',function () {
    $(this).parent().parent().remove();
});

$('#save-project').click(function () {

    var data_array = new Array();
    var tasks_id = $("input[name='tasks_id']").val();

    $("input[name='title[]']").each(function(i) {
        data_array[i] = {};
        var test = $(this).val();
        var project_id = $(this).attr('attr-project');
        if(!test) {
            return dialog.msg('新的竞赛项目名称不能为空！');
        }
        data_array[i]['title'] = $(this).val();
        data_array[i]['project_id'] = project_id;
    });

    $("input[name='price[]']").each(function (i) {
        var price = $(this).val();
        if(!price) {
            return dialog.msg('竞赛项目收费标准不能为空！');
        }
        if(isNaN(price)) {
            return dialog.msg('请输入正确的金额格式！');
        }
        data_array[i]['price'] = $(this).val();
    });

    var postUrl = 'index.php?m=activity&c=index&a=checkProject';
    var jumpUrl = 'index.php?m=activity&c=index&a=registration';
    var postData = {
        'project' : data_array,
        'tasks_id' : tasks_id,
    };

    $.post(postUrl,postData,function (result) {
        if(result.status == 0) {
            return dialog.msg(result.message);
        }else if(result.status == 1) {
            jumpUrl = jumpUrl + '&tasks_id=' + result.tasks_id + '&project_status=' + result.project_status;
            return dialog.msg_url(result.message,jumpUrl);
        }
    },'JSON');

});

$('#create-registration').click(function () {
    var enrol_start_time = $('input[name = "enrol_start_time"]').val();
    var enrol_end_time = $('input[name = "enrol_end_time"]').val();
    var personal_limit = $('input[name = "personal_limit"]').val();
    var team_limit = $('input[name = "team_limit"]').val();
    var team_personal_limit = $('input[name = "team_personal_limit"]').val();
    var total_personal = $('input[name = "total_personal"]').val();
    var minimum_age = $('input[name = "minimum_age"]').val();
    var maximum_age = $('input[name = "maximum_age"]').val();
    var statement = $('textarea[name = "statement"]').val();
    var tasks_id = $(this).attr('attr-tasks_id');

    if(!enrol_start_time) {
        return dialog.msg('报名开始时间不能为空！');
    }
    if(!enrol_end_time) {
        return dialog.msg('报名结束时间不能为空！');
    }

    enrol_start_time = timeFormatConversion(enrol_start_time);
    enrol_end_time = timeFormatConversion(enrol_end_time);
    if(enrol_start_time > enrol_end_time) {
        return dialog.msg('报名开始时间不能晚于报名结束时间！');
    }

    if(total_personal) {
        var sum_personal = parseInt(personal_limit) + parseInt(team_limit) * parseInt(team_personal_limit);
        if(sum_personal > parseInt(total_personal)) {
            return dialog.msg('个人加团体人数上限不能超过总人数名额上限！');
        }
    }

    if(minimum_age > maximum_age) {
        return dialog.msg('最小年龄限制不可以大于最大年龄限制！');
    }

    var postUrl = 'index.php?m=activity&c=index&a=checkRegistration';
    var jumpUrl = 'index.php?m=activity&c=index&a=form';
    var postData = {
        'enrol_start_time' : enrol_start_time,
        'enrol_end_time' : enrol_end_time,
        'personal_limit' : personal_limit,
        'team_limit' : team_limit,
        'team_personal_limit' : team_personal_limit,
        'total_personal' : total_personal,
        'minimum_age' : minimum_age,
        'maximum_age' : maximum_age,
        'statement' : statement,
        'tasks_id' : tasks_id,
    };

    $.post(postUrl,postData,function (result) {
        if(result.status == 0) {
            return dialog.msg(result.message);
        }else if(result.status == 1) {
            jumpUrl = jumpUrl + '&tasks_id=' + result.tasks_id + '&project_status=' + result.project_status + '&registration=' + result.registration;
            return dialog.msg_url(result.message,jumpUrl);
        }
    },'JSON');

});

function timeFormatConversion(r_time) {
    var start_time = r_time;
    start_time = start_time.replace('年','-');
    start_time = start_time.replace('月','-');
    start_time = start_time.replace('日','');
    start_time = $.trim(start_time);
    start_time = start_time + ' 00:00:00'
    start_time = Date.parse(new Date(start_time));
    start_time = start_time / 1000;
    return start_time;

}

$(".switch input").bootstrapSwitch();

/*$(".nav-form li a").click(function () {
    //$(this).parent().addClass('active');

    if(!$(this).parent().hasClass("mustbe")) {
        $(this).parent().toggleClass('active');
    }
    if($(this).attr('attr-status') == 1) {
        $(this).attr('attr-status',0);
    }else if($(this).attr('attr-status') == 0) {
        $(this).attr('attr-status',1);
    }
});*/

$(".nav-form").on('click','li a',function () {
    if(!$(this).parent().hasClass("mustbe")) {
        $(this).parent().toggleClass('active');
    }
    if($(this).attr('attr-selected') == 1) {
        $(this).attr('attr-selected',0);
    }else if($(this).attr('attr-selected') == 0) {
        $(this).attr('attr-selected',1);
    }
});

$('#add-form').click(function () {
    layer.prompt({title: '添加自定义填写项', formType: 3}, function(title, index){
        layer.close(index);
        layer.confirm('是否为必填项？', {
            btn: ['必填','不一定'] //按钮
        }, function(index){
            $('.nav-form').append('<li><a href="#" attr-status="1" attr-name="'+ title+ '" attr-selected="0" attr-name_id="-1">'+ title+'（必填）' + '</a></li>');
            layer.close(index);
        }, function(){
            $('.nav-form').append('<li><a href="#" attr-status="0" attr-name="'+ title+ '" attr-selected="0" attr-name_id="-1">'+ title + '</a></li>');
            layer.close(index);
        });
    });
});

$('#check-form').click(function () {

   var data = new Array();
   var tasks_id = $(this).attr('attr-tasks');

   $('.nav-form li a').each(function (i) {
       data[i] = {};
       data[i]['name'] = $(this).attr('attr-name');
       data[i]['required'] = $(this).attr('attr-status');
       data[i]['selected'] = $(this).attr('attr-selected');
       data[i]['name_id'] = $(this).attr('attr-name_id');
   });

   var postUrl = 'index.php?m=activity&c=index&a=checkForm';
   var jumpUrl = 'index.php?m=activity&c=index&a=generateProgramCode&tasks_id='+tasks_id;
   var postData = {
       'data' : data,
       'tasks_id' : tasks_id,
   };

    $.post(postUrl,postData,function (result) {
        if(result.status == 0) {
            return dialog.msg(result.message);
        }else if(result.status == 1) {
            return dialog.msg_url(result.message,jumpUrl);
        }
    },'JSON');
});

$('#select-tasks').change(function () {
    var tasks_id = $('#select-tasks').val();
    window.location.href = 'index.php?m=activity&c=enrol&a=index&tasks_id='+tasks_id;
});

$('#enrol-export').click(function () {
    var tasks_id = $(this).attr('tasks_id');
    window.location.href = 'index.php?m=activity&c=enrol&a=export&tasks_id='+tasks_id;
});