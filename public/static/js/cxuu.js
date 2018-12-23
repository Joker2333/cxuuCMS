/*form ajax 提交数据 用于AJAX加载到#main
 * act  提交方法 add  edit
 * url  提交方法
 * */
function ajaxPost(url, act) {
    var actionname = act || '';
    $(":submit").click(function () {
        var options = {
            url: url + actionname,
            dataType: "json",
            method: "post",
            success: function (data) {
                if (data.result == 1) {
                    layer.msg(data.msg);
                    $("#main").load(data.url);
                } else {
                    layer.msg(data.msg);
                }
            }
        };
        $("#form1").ajaxForm(options);
    });
}

/**
 * 搜索信息
 * */
function searchGet(url) {
    $("button.btn-search").click(function () {
        var data = $('#form1').serializeObject();
        var parm = '';
        //console.log(data);
        for (var name in data) {
            var value = data[name];
            !(typeof value == 'undefined') && (parm += name + '=' + encodeURI(value) + '&');
        }
        parm && (parm = parm.substring(0, parm.length - 1));
        $("#main").load(url + '?' + parm);
    });
}


/*序列化对象*/
$.fn.serializeObject = function () {
    var serializeObj = {};
    var array = this.serializeArray();
    var str = this.serialize();
    $(array).each(function () {
        if (serializeObj[this.name]) {
            if ($.isArray(serializeObj[this.name])) {
                serializeObj[this.name].push(this.value);
            } else {
                serializeObj[this.name] = [serializeObj[this.name], this.value];
            }
        } else {
            serializeObj[this.name] = this.value;
        }
    });
    return serializeObj;
};


/*ajax默认设置 以及扩展、重写方法*/
$.ajaxSetup({
    cache: false,
    async: true
});

/*锁屏*/
$.fn.lock = function () {
    return this.unlock().each(function () {
        if ($.css(this, 'position') === 'static')
            this.style.position = 'relative';
        if (/msie/.test(navigator.userAgent.toLowerCase()))
            this.style.zoom = 1;
        // $(this).append('<div class="load-progress"><div class="load-spinner"></div></div>');
        $(this).html('<div class="full-block-loading"><div class="loader-wrapper"><div class="loader"></div></div></div>');
    });
};

/*取消锁屏*/
$.fn.unlock = function () {
    return this.each(function () {
        $('.load-progress', this).remove();
    });
};

/*重新载入 带锁屏动画*/
$.fn.reload = function (url, data, callback) {
    var $this = $(this);
    $this.lock();
    setTimeout(function () {
        $this.load(url, data, callback);
    }, 100);

};

/*上传组件 方法*/
function uploader(config, success, contr) {
    var upcontr = contr || '';//上传控制器名
    if (!config.btnId) {
        var config = {
            btnId: config, /*上传按钮ID*/
            maxcount: 1, /*最大上传文件数量*/
            fileNumLimit: 1,
            multiple: false, /*是否为多文件上传*/
            extensions: 'jpg,png,gif,doc', /**/
            success: success
        };
    }
    var uploader = WebUploader.create({
        auto: true,
        pick: {
            id: ('#' + config.btnId)
        },
        compress: false, //图片在上传前不进行压缩
        threads: 1, //上传并发数
        fileNumLimit: config.maxcount,
        server: '/admin/upload/uploadWebuploader?upcontr=' + upcontr,
        swf: '/static/webuploader/Uploader.swf',
        fileVal: 'image',
        accept: {title: '请选择文件', extensions: config.extensions, multiple: config.multiple},
        formData: {}
    });

    uploader.on("uploadSuccess", function (file, response, uploader) {
        typeof config.success == 'function' && config.success(file, response);
    });
}

