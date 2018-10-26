<?php

namespace app\admin\validate;

use think\Validate;

class Login extends Validate {

    protected $rule = [
        'username' => 'require|max:50',
        'password' => 'require|max:50',
    ];
    protected $message = [
        'username.require' => '用户名不能为空！',
        'username.max'      => '用户名最多不能超过50个字符',
        'password.require' => '密码不能为空！',
        'password.max'      => '密码最多不能超过50个字符',
    ];

}
