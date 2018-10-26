<?php
/***
* 龙啸轩网站管理系统 
* 作者：邓中华 20181009
* 用户提交验证
***/
namespace app\admin\validate;

use think\Validate;

class Juleader extends Validate {

    protected $rule = [
        'name' => 'require|max:50|min:2',
        'duty' => 'max:100|min:2',
    ];
    protected $message = [
        'username.require' => '领导姓名不能为空！',
        'username.max' => '领导姓名最多不能超过50个字符',
        'username.min' => '领导姓名最多不能小于2个字符',
        'nicename.min' => '领导职务不能小于2个字',
    ];

    
    protected $scene = [
        'sceneEdit'  =>  ['name', 'duty'],
    ];
    

}
