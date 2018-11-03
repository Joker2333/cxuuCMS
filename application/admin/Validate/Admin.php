<?php

namespace app\admin\validate;

use think\Validate;

class Admin extends Validate {

    protected $rule = [
        'username' => 'require|max:50|min:5',
        'nicename' => 'chs|max:50|min:2',
        'password' => 'require|min:5',
        'password_f' => 'confirm:password',
        'email' => 'mobile',
    ];
    protected $message = [
        'username.require' => '用户名不能为空！',
        'username.max' => '用户名最多不能超过50个字符',
        'username.min' => '用户名最多不能小于5个字符',
        'nicename.chs' => '昵称只能是中文',
        'nicename.min' => '昵称不能小于2个字',
        'password.require' => '密码不能为空',
        'password.min' => '密码不能小于5个字符',
        'password_f' => '两次输入密码不一致！',
        'email' => '电话格式不对！',
    ];

    
    protected $scene = [
        'sceneEdit'  =>  ['username', 'nicename', 'email'],
        'scenePasswordEdit'  =>  ['username', 'nicename', 'email','password','password_f'],
        'scenepwEdit'  =>  ['password','password_f'],
    ];
    

}
