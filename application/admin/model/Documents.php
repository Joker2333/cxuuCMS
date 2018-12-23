<?php
/**
 * Created by 龙啸轩PHP 信息 管理系统.
 * User: 邓中华
 * Date: 2018/11/29
 * Time: 11:38
 */
namespace app\admin\model;

use think\Model;

class Documents extends Model {

    protected $pk = 'id';

//定义一对一关联
    public function DocumentsContent()
    {
        return $this->hasOne('DocumentsContent','aid','id');
    }

}
