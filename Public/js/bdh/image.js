/**
 * Created by liuzezhong on 2017/2/6.
 */

/**
 * 图片上传功能
 */
$(function() {

    $('#file_upload').uploadify({

        'swf'      : 'Public/plugin/uploadify/uploadify.swf',
        'uploader' : '/index.php?m=home&c=image&a=ajaxUploadImage',
        'buttonText': '上传头像',
        'fileTypeDesc': 'Image Files',
        'fileObjName' : 'file',

        //允许上传的文件后缀
        'fileTypeExts': '*.gif; *.jpg; *.png;',

        'onUploadSuccess' : function(file,data,response) {
            // response true ,false
            if(response) {
                var obj = JSON.parse(data); //由JSON字符串转换为JSON对象

                //console.log(data);
                //$('#' + file.id).find('.data').html(' 上传完毕');

                $("#upload_org_code_img").attr("src",obj.data);
                $("#file_upload_image").attr('value',obj.data);
                $("#upload_org_code_img").show();
            }else{
                alert('上传失败');
            }
        },
    });
});