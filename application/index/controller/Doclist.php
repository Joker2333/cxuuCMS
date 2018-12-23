<?php
/**
 * Created by 龙啸轩PHP 信息 管理系统.
 * User: 邓中华
 * 文件发签前端
 * Date: 2018/10/29
 * Time: 12:34
 */
namespace app\index\controller;

//use think\facade\Cache;
use app\index\model\Documents;

class Doclist extends \think\Controller
{

    public function _empty()
    {
        return error404();
    }

    public function index()
    {

        $list = Documents::field('id,cid,title,created_date')->order('id desc')->paginate(20);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch('doclist');
    }
}
