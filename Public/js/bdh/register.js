/**
 * Created by liuzezhong on 2017/1/31.
 */

var register = {

  firstCheck : function () {
      //获取到输入的内容
      var inputVaule = $('input[name = "emailOrMobil"]').val();

      //设置post链接和post请求后跳转链接
      var postUrl = 'index.php?m=home&c=register&a=firstCheck';
      var jumpUrl = 'index.php?m=home&c=register&a=register';

      //设置存储手机号码或邮箱的变量
      var mobile = '';
      var email = '';

      //正则表达式验证手机号码或邮箱
      var zmobile=/^(1[34578]\d{9})$/;  //手机号码验证
      var zemail=/^(\w{1,}@\w{1,}\.\w{1,})$/;//邮箱验证

      //对输入的有效性进行判断
      if(!inputVaule)
          return dialog.msg('请输入您的邮箱或手机号码！');
      if(!zmobile.test(inputVaule) && !zemail.test(inputVaule))
          return dialog.msg('请输入正确的邮箱或手机号码！');

      //判断出输入的是邮箱还是手机号码
      if(zmobile.test(inputVaule))
          mobile = inputVaule;
      if(zemail.test(inputVaule))
          email = inputVaule;

      //将数据封装
      var data = {
          'mobile' : mobile,
          'email' : email,
      };

      //进行Ajax异步请求
      $.post(postUrl,data,function (result) {
          if(result.status == 0) {
              //return dialog.error(result.message);
              return dialog.msg(result.message);
          } else if(result.status == 1) {
              //将值存储到sessionStorage里面，浏览器关闭消失，并跳转链接
              sessionStorage.firstCheckVaule = inputVaule;
              window.location.href = jumpUrl;
          }
      },'JSON');



  },

  secondCheck : function () {
      //获取页面输入、上级页面传递过来的值
      var emailOrMobil = sessionStorage.firstCheckVaule;
      var username = $('input[name = "username"]').val();
      var password = $('input[name = "password"]').val();

      //获取checkedbox的内容，如果勾选值为checked,如果不勾选则为undefined
      var checked = $("input[name='checkbox']:checked").val();

      //设置post链接和跳转连接
      var postUrl = 'index.php?m=home&c=register&a=userRegister';
      var jumpUrl = 'index.php';

      //设定字符串
      var mobile = '';
      var email = '';

      //设定正则表达式规则
      var zmobile = /^(1[34578]\d{9})$/;  //手机号码验证
      var zemail = /^(\w{1,}@\w{1,}\.\w{1,})$/;//邮箱验证
      var zusername = /^([\u4e00-\u9fa5a-zA-Z0-9]{3,12})$/;//用户名要求以字母开头，可以是数字或字母
      var zpassword = /^.{6,20}$/;

      //对数据有效性进行验证
      if(!username)
          return dialog.msg('请输入您的昵称！');
      if(!zusername.test(username))
          return dialog.msg('昵称必须是3-12位字符！');
      if(!password)
          return dialog.msg('请输入您的密码！');
      if(!zpassword.test(password))
          return dialog.msg('请输入6-20位密码！');
      if(window.dragtype == 0)
          return dialog.msg('请拖动滑块验证！');
      if(checked != 'checked')
          return dialog.msg('请仔细阅读并同意《不导航服务条款》！');

      //判断出手机或邮箱
      if(zmobile.test(emailOrMobil))
          mobile = emailOrMobil;
      if(zemail.test(emailOrMobil))
          email = emailOrMobil;

      //封装数据
      var data = {
          'username' : username ,
          'password' : password ,
          'mobile'   : mobile,
          'email'    : email,
      };


      //Ajax交互
      $.post(postUrl,data,function (result) {
          if(result.status == 1) {
              //return dialog.success(result.message,jumpUrl);
             /* dialog.msg(result.message);
              window.location.href = jumpUrl;*/
              return dialog.msg_url(result.message,jumpUrl);
          }else if(result.status == 0){
              return dialog.msg(result.message);
          }


      },'JSON');



  }
};