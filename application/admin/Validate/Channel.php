<?php
namespace app\admin\validate;

use think\Validate;

class Channel extends Validate
{
    protected $rule =   [
        'urlname'  => 'alpha|max:20'    
    ];
    
    protected $message  =   [
        'urlname.alpha' => '栏目别名只能是字母和数字',
        'urlname.max'     => '栏目别名最多不能超过20个字符',

    ];
    
}