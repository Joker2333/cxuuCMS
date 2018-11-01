<?php
namespace app\admin\validate;

use think\Validate;

class Content extends Validate
{
    protected $rule =   [
        'cid' 		 => 'require',
        'title' 	 => 'require|max:50',
        'auther' 	 => 'require|max:5',
        'examine'	 => 'require|max:5',
        'publish' 	 => 'require|max:5',
    ];
    
    protected $message  =   [
        'cid.require' => '栏目不能为空！',
        'title.require' => '标题不能为空！',
        'title.max'     => '标题最多不能超过50个字符',
		'auther.require' => '拟稿人不能为空！',
        'auther.max'     => '拟稿人最多不能超过5个字符',
		'examine.require' => '审核人不能为空！',
        'examine.max'     => '审核人最多不能超过5个字符',
		'publish.require' => '发布人不能为空！',
        'publish.max'     => '发布人最多不能超过5个字符',
    ];
    
}