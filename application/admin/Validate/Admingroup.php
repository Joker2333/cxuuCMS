<?php

namespace app\admin\validate;

use think\Validate;

class Admingroup extends Validate {

    protected $rule = [
        'groupname' => 'require|max:50|min:2',
    ];
    protected $message = [
        'groupname.require' => '用户组名不能为空！',
        'groupname.max' => '用户组名最多不能超过50个字符',
        'groupname.min' => '用户组名最多不能小于2个字',
    ];

}
