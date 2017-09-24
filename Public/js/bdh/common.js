/**
 * Created by liuzezhong on 2017/4/24.
 */
/*
$(function () {
    $('#add-products').click(function () {
        alert('1');
    });
});*/


$(document).ready(function() {

    $('#add-product-form').formValidation({
        message: '输入的内容有误！',
        icon: {
            valid: 'fa fa-check',
            invalid: 'fa fa-remove',
            validating: 'fa  fa-refresh'
        },
        fields: {

            product_name: {
                message: '产品名输入有误',
                validators: {
                    notEmpty: {
                        message: '产品名不能为空'
                    },
                    stringLength: {
                        min: 2,
                        max: 20,
                        message: '产品名在2-20个字符之间'
                    },
                    /*regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: '产品名称只能是字母、数字和下划线'
                    }*/
                }
            },
            website: {
                validators: {
                    notEmpty: {
                        message: '产品网址不能为空'
                    }
                }
            },
            describes: {
                validators: {
                    notEmpty: {
                        message: '产品的描述不能为空'
                    }
                }
            }
        }
    });
});

