<?php

namespace app\admin\validate;

use think\Validate;

class Onlinemusic extends Validate
{
    protected $rule = [
        'cid' => 'require',
        'title' => 'require|max:100',
        'musicurl' => 'require',
    ];

    protected $message = [
        'cid.require' => '类别不能为空！',
        'title.require' => '音乐标题不能为空！',
        'title.max' => '音乐标题最多不能超过100个字符',
        'musicurl.require' => '拟稿人不能为空！',

    ];

}