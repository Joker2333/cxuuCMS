<?php
/**
 * Created by 龙啸轩PHP 信息 管理系统.
 * User: 邓中华
 * Date: 2018/11/30
 * Time: 11:32
 */

namespace app\index\model;

use think\Model;

class DocumentsSignin extends Model
{

    protected $pk = 'id';

//获取当前 文件ID 的签收列表
    static public function getList($id)
    {
        $list = DocumentsSignin::where('aid', $id)->select();
        return $list;
    }


}

