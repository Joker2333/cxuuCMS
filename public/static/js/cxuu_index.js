/*form ajax 提交数据 用于AJAX加载到#main
 * act  提交方法 add  edit
 * url  提交方法
 * */
/**
 * 龙啸轩网站管理系统
 * 邓中华
 * 20181010
 */
function ajaxPost(url, act) {
    var actionname = act || '';
    $(":submit").click(function () {
        var options = {
            url: url + actionname,
            dataType: "json",
            method: "post",
            success: function (data) {
                if (data.result == 1) {
                    layer.alert(data.msg);
                    window.location.href = data.url;
                } else {
                    layer.msg(data.msg, {
                        time: 0
                    });
                }
            }
        };
        $("#form1").ajaxForm(options);
    });
}