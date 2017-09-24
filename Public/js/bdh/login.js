/**
 * Created by liuzezhong on 2017/2/4.
 */

// js获取数据，验证数据有效性，区分数据，post请求，后台验证数据，返回结果

var login = {
  check : function () {
      //获取用户输入数据
      var username = $('input[name = "username"]').val();
      var password = $('input[name = "password"]').val();
      var postUrl = 'index.php?m=home&c=login&a=login';
      var jumpUrl = 'index.php';

      //验证数据有效性
      if(!username)
          return dialog.msg('请输入用户名或邮箱地址！');
      if(!password)
          return dialog.msg('请输入你的登录密码！');

      //区分数据

      //设定正则表达式规则
      var zmobile = /^(1[34578]\d{9})$/;  //手机号码验证
      var zemail = /^(\w{1,}@\w{1,}\.\w{1,})$/;//邮箱验证
      var zusername = /^([\u4e00-\u9fa5a-zA-Z0-9]{3,12})$/;//用户名要求以字母开头，可以是数字或字母
      var zpassword = /^.{6,20}$/;



      var user_mobile = '';
      var user_email = '';
      var user_name = '';

      if(zmobile.test(username))
          user_mobile = username;
      if(zemail.test(username))
          user_email = username;
      if(zusername.test(username))
          user_name = username;


      /*if(user_mobile)
          return dialog.msg('mobile');
      if(user_email)
          return dialog.msg('email');
      if(user_name)
          return dialog.msg('name');*/
      if(!user_mobile && !user_email && !user_name)
          return dialog.msg('输入的用户名不符合规则，请重新输入！');
      if(!zpassword.test(password))
          return dialog.msg('输入的密码不符合规则，请重新输入！');

      var data = {
          'username': user_name,
          'mobile': user_mobile,
          'email': user_email,
          'password' : password,
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