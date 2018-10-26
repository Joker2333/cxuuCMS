<?php

namespace app\admin\controller;

use app\admin\model\Channel;
use app\admin\model\Content;

class Channelcontr extends \think\Controller {

    protected $middleware = ['Auth'];

    public function index() {
        $list = Channel::getCAllTree();
        $this->assign('list', $list);
        return $this->fetch();
    }

    public function addEdit() {
        $getid = $this->request->get('id');
        $channellist = Channel::all();
        $channeltree = Channel::getCTree();
        $this->assign('channellist', $channellist);
        $this->assign('channeltree', $channeltree);
        //$template = read_dir("D:\\appserv-win32-8.6.0\\www\\application\\index\\view\\Infolist");

        if (empty($getid)) {
            error_reporting(E_ALL & ~E_NOTICE); //屏蔽未定义变量错误提示
            $this->assign('constname', "添加");
            $this->assign('actionname', "addAction");
            //$this->assign('template', $template);
            return $this->fetch('channel');
        } else {
            $find = Channel::where('id', $getid)->find();
            $pid = $find['pid'];
            $this->assign('info', $find);
            $this->assign('pid', $pid);
            $this->assign('constname', "编辑");
            $this->assign('actionname', "editAction");
            //$this->assign('template', $template);
            return $this->fetch('channel');
        }
    }

    public function addAction() {
        $addpost = $this->request->post();
        $validate = new \app\admin\validate\Channel;
        if (!$validate->check($addpost)) {
            return ajax_Jsonreport($validate->getError(), 0);
        }
        $add = new Channel; // 实例化 Content模型
        if ($add->save($addpost)) {
            return ajax_Jsonreport("添加成功", 1, "/admin/Channelcontr");
        } else {
            return ajax_Jsonreport("添加失败", 0);
        }
    }

    public function editAction() {
        $id = $this->request->post('id');
        if ($id) {
            $editpost = $this->request->post();
            $validate = new \app\admin\validate\Channel;
            if (!$validate->check($editpost)) {
                return ajax_Jsonreport($validate->getError(), 0);
            }
            $user = new Channel;
            if ($user->save($editpost, ['id' => $id])) {
                return ajax_Jsonreport("修改成功", 1, "/admin/Channelcontr");
            } else {
                return ajax_Jsonreport("修改失败", 0);
            }
        }
    }

    public function Delete() {
        $id = $this->request->get('id');
        if (Content::where('cid', $id)->find()) {
            return ajax_Jsonreport("该栏目下存在内容，不能删除！", 0);
        }
        if (Channel::where('id', $id)->delete()) {
            return ajax_Jsonreport("删除成功", 1);
        }
        return ajax_Jsonreport("删除失败", 0);
    }

//菜单显示JS数据调用方法
    public function getJsTree() {
        $data = Channel::getJsTree();
        return json_encode($data);
    }

}
