/**
 * Created by liuzezhong on 2017/2/4.
 */

var user = {
  check : function () {

      var username = $('input[name = "username"]').val();
      var mobile = $('input[name = "mobile"]').val();
      var wechat = $('input[name = "wechat"]').val();
      var email = $('input[name = "email"]').val();
      var company = $('input[name = "company"]').val();
      var job = $('input[name = "job"]').val();
      var describes = $('textarea[name = "describes"]').val();
      var userid = $('input[name = "userid"]').val();
      var thumb = $('input[name = "thumb"]').val();

      //设定正则表达式规则
      var zmobile = /^(1[34578]\d{9})$/;  //手机号码验证
      var zemail = /^(\w{1,}@\w{1,}\.\w{1,})$/;//邮箱验证
      var zusername = /^([\u4e00-\u9fa5a-zA-Z0-9]{3,12})$/;//用户名要求以字母开头，可以是数字或字母
      var zpassword = /^.{6,20}$/;

      var postUrl = 'index.php?m=home&c=user&a=update';
      var jumpUrl = '';


      if(!username)
          return dialog.msg('请填写昵称！');
      if(!zusername.test(username))
          return dialog.msg('昵称必须是3-12位字符！');
      if(!mobile && !email) {
          return dialog.msg('手机号码和电子邮件不能全部为空！')
      }
      if(mobile || email) {
          if(mobile) {
              if(!zmobile.test(mobile))
                  return dialog.msg('手机号码格式错误！');
          }
          if(email) {
              if(!zemail.test(email))
                  return dialog.msg('电子邮件格式错误！');
          }
      }

      data = {
          'username' : username ,
          'mobile' : mobile ,
          'wechat' : wechat ,
          'email' : email,
          'company' : company,
          'job' : job ,
          'describes' : describes,
          'user_id' :userid,
          'headerimg' : thumb,
      };

      $.post(postUrl,data,function (result) {
          if(result.status == 0) {
              return dialog.msg(result.message);
          }else if(result.status == 1) {
              return dialog.msg_url(result.message,jumpUrl);
          }
      },'JSON');

  }  
};