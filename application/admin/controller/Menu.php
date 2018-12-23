<?php
/**
 * Created by 龙啸轩PHP 信息 管理系统.
 * User: 邓中华
 * Date: 2018/11/1
 * Time: 11:38
 */
namespace app\admin\controller;

//use app\admin\model\Channel;
class Menu extends \think\Controller
{

    // protected $middleware = ['Auth'];

    public function index()
    {
        return $this->fetch();
    }

    public function content()
    {
        //$treeData=Channel::getZTree();
        //$this->assign('treeData', $treeData);
        return $this->fetch();
    }

    public function documents()
    {
        return $this->fetch();
    }
    public function onlinemusic()
    {
        return $this->fetch();
    }

    public function admin()
    {
        return $this->fetch();
    }

    public function channel()
    {
        return $this->fetch();
    }

    public function setting()
    {
        return $this->fetch();
    }

    public function application()
    {
        return $this->fetch();
    }

}
