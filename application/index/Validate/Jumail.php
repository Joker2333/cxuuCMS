<?php
/**
 *  邮件提交信息验证
 * 邓中华
 * 20181010
 */
namespace app\index\validate;

use think\Validate;

class Jumail extends Validate {

    protected $rule = [
        'writename' => 'require|max:5',
        'department' => 'require|max:20',
        'phone' => 'require|number|max:11',
		'addr' => 'require|max:20',
        'title' => 'require|max:10',
        'category' => 'require|max:4',
        'content' => 'require|max:1000',
        
    ];
    protected $message = [
        'writename.require' => '写信人不能为空！',
        'writename.max'      => '写信人最多不能超过10个字',
		'department.require' => '写信人所在部门不能为空！',
        'department.max'      => '写信人所在部门最多不能超过20个字',
		'phone.require' => '联系电话不能为空！',
        'phone.max'      => '联系电话最多不能超过11个数字',
        'phone.number'      => '联系电话只能是数字',
		'title.require' => '信件标题不能为空！',
        'title.max'      => '信件标题最多不能超过10个字',
		'category.require' => '信件类型不能为空！',
        'category.max'      => '信件类型最多不能超过4个字',
        'content.require'      => '信件内容不能为空',
        'content.max'      => '信件类型最多不能超过1000个字',
		'addr.require'      => '联系地址不能为空',
        'addr.max'      => '联系地址最多不能超过1000个字',
		
    ];

}
