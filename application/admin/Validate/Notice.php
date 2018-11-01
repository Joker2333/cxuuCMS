<?php

/**
 * Created by 龙啸轩PHP 信息 管理系统.
 * User: 邓中华
 * Date: 2018/10/28
 * Time: 12:55
 */

namespace app\admin\validate;

use think\Validate;

class Notice extends Validate
{

    protected $rule = [
        'title' => 'require|max:50|min:2',
        'content' => 'max:500|min:2',
    ];
    protected $message = [
        'title.require' => '公告标题不能为空！',
        'title.max' => '公告标题最多不能超过50个字符',
        'content.min' => '公告内容不能小于2个字符',
        'content.max' => '公告内容最多不能超过500个字',
    ];

}