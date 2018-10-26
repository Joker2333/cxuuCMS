<?php
/***
* 龙啸轩网站管理系统 作者：邓中华 20181009
***/
namespace app\admin\controller;

use app\admin\model\Admin;
use app\admin\model\Admingroup;

class Adminusercontr extends \think\Controller {

    protected $middleware = ['Auth']; //中间件权限管理

    public function index() {
        $list = Admin::order('user_id ASC')->paginate(10);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }

    public function addedit() {
        $getid = $this->request->get('id');
        $groupname = Admingroup::all();
        $this->assign('groupname', $groupname);

        if (empty($getid)) {
            error_reporting(E_ALL & ~E_NOTICE); //屏蔽未定义变量错误提示
            $this->assign('constname', "添加");
            $this->assign('actionname', "addAction");
            return $this->fetch('adminuser');
        } else {
            $info = Admin::get($getid);
            $this->assign('info', $info);
            $this->assign('constname', "编辑");
            $this->assign('actionname', "editAction");
            return $this->fetch('adminuser');
        }
    }

    public function addAction() {//新增用户方法
        $addpost = $this->request->post();
        $validate = new \app\admin\validate\Admin;

        if (!$validate->check($addpost)) {
            return ajax_Jsonreport($validate->getError(), 0);
        }

        $username = Admin::where('username', $addpost['username'])->find();
        if ($username) {
            return ajax_Jsonreport("用户名已经存在", 0);
        }
        $nicename = Admin::where('nicename', $addpost['nicename'])->find();
        if ($nicename) {
            return ajax_Jsonreport("昵称已经存在", 0);
        }
        $addpost['password'] = md5($addpost['password']);
        $add = new Admin; // 实例化 Content模型       
        if ($add->save($addpost)) {
            return ajax_Jsonreport("添加成功", 1,"/admin/Adminusercontr");
        } else {
            return ajax_Jsonreport("添加失败", 0);

        }
    }

    public function editAction() {
        $editpost = $this->request->post();
        new \app\admin\validate\Admin;
        if (!empty($editpost['password']) || !empty($editpost['password_f'])) {
            $result = $this->validate($editpost, 'app\admin\validate\admin.scenePasswordEdit'); //场景验证
            if (true !== $result) {
                return ajax_Jsonreport($result, 0);
            }
        }

        $result = $this->validate($editpost, 'app\admin\validate\admin.sceneEdit'); //场景验证
        if (true !== $result) {
           return ajax_Jsonreport($result, 0);
        }

        $save = new Admin;

        if (!empty($editpost['password'])) {
            $editpost['password'] = md5($editpost['password']);
            $saved = $save->save($editpost, ['user_id' => $editpost['user_id']]);
        } else {
            $saved = $save->allowField(['group_id', 'username', 'nicename', 'email', 'stauts'])->save($editpost, ['user_id' => $editpost['user_id']]); //只更新对应数据
        }

        if ($saved) {
            return ajax_Jsonreport("修改成功", 1,"/admin/Adminusercontr");
        }
        return ajax_Jsonreport("修改用户失败", 0);
    }

    public function pw() {
        $userinfo = getCxuuCookie();
        $this->assign('userinfo', $userinfo);
        return $this->fetch('pwedit');
    }

    public function pwedit() {
        $editpost = $this->request->post();
        new \app\admin\validate\Admin;
        $result = $this->validate($editpost, 'app\admin\validate\admin.scenepwEdit'); //场景验证
        if (true !== $result) {
            return ajax_Jsonreport($result, 0);            
        }
        $data = [
            'password' => md5($editpost['password']),
        ];
        $update = new Admin;
        if ($update->allowField(['password'])->save($data, ['user_id' => $editpost['user_id']])) {
            return ajax_Jsonreport("修改成功", 1,"/admin/Adminusercontr");
        }
        return ajax_Jsonreport("修改失败", 0);
    }

    public function del() {
        $getid = $this->request->param('id');
        $del = Admin::destroy($getid);
        if ($del) {
            return ajax_Jsonreport("删除 用户ID  $getid  成功！", 1);
        }
        return ajax_Jsonreport("删除失败", 0);
    }

}
