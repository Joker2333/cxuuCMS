<?php

namespace app\admin\controller;

use app\admin\model\Admingroup;
use app\admin\model\Channel;

class Admingroupcontr extends \think\Controller
{

    protected $middleware = ['Auth'];

    public function index()
    {
        $list = Admingroup::order('group_id ASC')->paginate(10);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }

    public function addedit()
    {
        $get = $this->request->param();
        if (empty($get['id'])) {
            error_reporting(E_ALL & ~E_NOTICE); //屏蔽未定义变量错误提示
            $this->assign('constname', "添加");
            $this->assign('actionname', "addAction");
            return $this->fetch('admingroup');
        } else {
            $info = Admingroup::get($get['id']);
            $this->assign('info', $info);
            $this->assign('constname', "编辑");
            $this->assign('actionname', "editAction");
            return $this->fetch('admingroup');
        }
    }

    public function addAction()
    {
        $addpost = $this->request->post();
        $validate = new \app\admin\validate\Admingroup;

        if (!$validate->check($addpost)) {
            return ajax_Jsonreport($validate->getError(), 0);
        }

        $groupname = Admingroup::where('groupname', $addpost['groupname'])->find();
        if ($groupname) {
            return ajax_Jsonreport("用户组名已经存在", 0);
            // return json_encode(array('msg' => '用户组名已经存在！', 'result' => '0'));
        }

        $add = new Admingroup;
        if ($add->save($addpost)) {
            return ajax_Jsonreport("添加成功", 1, "/admin/Admingroupcontr");
        } else {
            return ajax_Jsonreport("添加失败", 0);
        }
    }

    public function editAction()
    {
        $editpost = $this->request->post();
        $validate = new \app\admin\validate\Admingroup;
        if (!$validate->check($editpost)) {
            return ajax_Jsonreport($validate->getError(), 0);
        }
        $save = new Admingroup;
        //$saved = $save->allowField(['groupname'])->save($editpost, ['group_id' => $editpost['group_id']]); //只更新对应数据
        $saved = $save->save($editpost, ['group_id' => $editpost['group_id']]); //只更新对应数据
        if ($saved) {
            return ajax_Jsonreport("修改用户组成功", 1, "/admin/Admingroupcontr");
        }
        return ajax_Jsonreport("修改用户组失败", 0);
    }

    public function baseAuth()
    {
        $get = $this->request->param();
        $model = new Admingroup;
        $info = $model->getAdminGroupBase($get['id']);
        $this->assign('info', $info);
        $this->assign('getid', $get['id']);
        return $this->fetch('baseauthedit');
    }

    public function baseAuthAction()
    {
        $get = $this->request->param();
        $data = $this->request->post('baseauth');
        $model = new Admingroup;
        if ($model->setAdminGroupBase($get['id'], $data)) {
            return ajax_Jsonreport("修改成功", 1, "/admin/Admingroupcontr");
        } else {
            return ajax_Jsonreport("修改失败", 0);
        }
    }

    public function channelAuth()
    {
        $get = $this->request->param();
        $model = new Admingroup;
        $info = $model->getAdminGroupChannel($get['id']);
        $list = Channel::getCTree();
        $this->assign('list', $list);
        $this->assign('info', $info);
        $this->assign('getid', $get['id']);
        return $this->fetch('channelauthedit');
    }

    public function channelAuthAction()
    {
        $get = $this->request->param();
        $data = $this->request->post('channelauth');
        $model = new Admingroup;
        if ($model->setAdminGroupChannel($get['id'], $data)) {
            return ajax_Jsonreport("修改成功", 1, "/admin/Admingroupcontr");
        } else {
            return ajax_Jsonreport("修改失败", 0);
        }
    }

    public function del()
    {
        $id = $this->request->get('id');
        if ($id == 1) {
            return ajax_Jsonreport("超级管理员组禁止删除", 0);
        }
        if (Admingroup::where('id', $id)->delete()) {
            return ajax_Jsonreport("删除成功", 1);
        }
        return ajax_Jsonreport("删除失败", 0);
    }

}
