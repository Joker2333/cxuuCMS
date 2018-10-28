<?php
/***
 * 龙啸轩网站管理系统
 * 作者：邓中华 20181010
 * 用户提交验证
 ***/

namespace app\admin\validate;

use think\Validate;

class Onduty extends Validate
{

    protected $rule = [
        'name' => 'require|max:50|min:2',
        'duty' => 'max:100|min:2',
    ];
    protected $message = [
        'name.require' => '值班员姓名不能为空！',
        'name.max' => '值班员姓名最多不能超过50个字符',
        'duty.max' => '值班员职务最多不能小于100个字符',
        'duty.min' => '值班员职务不能小于2个字',
    ];

}