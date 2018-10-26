<?php

namespace app\index\validate;

use think\Validate;

class Search extends Validate {

    protected $rule = [
        'keywords' => 'require|max:10',
    ];
    protected $message = [
        'keywords.require' => '搜索关键字不能为空！',
        'keywords.max'      => '搜索关键字最多不能超过10个字符',
    ];

}
