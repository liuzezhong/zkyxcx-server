/**
 * Created by liuzezhong on 2017/1/30.
 */
$(function (){
    var zans = -1;
    var temp = 0;
    $("[id^='pop']").popover({placement:'bottom',trigger: 'click',});
    $("[id^='imgpop']").popover({placement:'bottom',trigger: 'hover',});
    //给Body加一个Click监听事件
    $('body').on('click', function(event) {
        var target = $(event.target);
        if (!target.hasClass('popover') //弹窗内部点击不关闭
            && target.parent('.popover-content').length === 0
            && target.parent('.popover-title').length === 0
            && target.parent('.popover').length === 0
            && target.parent('.popover').length === 0
            && target.parent('.a-font').length === 0
            && target.data("toggle") !== "popover") {
            //弹窗触发列不关闭，否则显示后隐藏
            $("[id^='pop']").popover('hide');
        }
    });
    /*
     $("#zan111").on('click',function(){

     if(zans == -1) {
     zans = $('#zan111').attr('attr-zan');
     }

     if(zans == 0) {

     zans = 1;
     $(".btn-defaults-red").toggleClass("btn-defaults");
     } else if(zans == 1) {

     zans = 0;
     $(".btn-defaults").toggleClass("btn-defaults-red");
     }

     });

     */




    $("body").on('click','.zanclass',function(){

        var loveid = $(this).attr('id');
        var midnumber = loveid.split('zan');
        var idnumber = midnumber[1];

        var count = parseInt($('#zannumber'+idnumber).html());

        var status = $(this).attr('rel');

        if(status == 'nozan')
        {
            $('#zannumber'+idnumber).html(count+1);
            $(this).addClass('btn-defaults-red').attr('rel','zan');

        }
        else
        {
            $('#zannumber'+idnumber).html(count-1);
            $(this).removeClass('btn-defaults-red').attr('rel','nozan');
        }


    });

    $('#div-point').on('click',function(){
        if (temp === 1)
            temp = 0;
        else
            window.open('http://www.baidu.com');

    });

    $('#pinglun1001').on('click',function(){
        window.open('http://www.sina.com');
        stopBubble(event);
    });
    $('#zan1001').on('click',function(){
        temp = 1;
    });


    function stopBubble(e)
    {

        if (e && e.stopPropagation)
            e.stopPropagation()
        else
            window.event.cancelBubble=true
    }



});