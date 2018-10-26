<?php
/***
* 龙啸轩网站管理系统 作者：邓中华 20181009
***/
namespace app\admin\controller;

use app\admin\model\Juleader;

class Juleadercontr extends \think\Controller {

    protected $middleware = ['Auth']; //中间件权限管理

    public function index() {
        $list = Juleader::order('sort ASC')->paginate(20);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }

    public function addedit() {
        $getval = $this->request->param();
		$this->assign('contr', $this->request->controller() . '/' . $this->request->action()); //传递给上传器 控制器及方法名称
        if (empty($getval['id'])) {
            error_reporting(E_ALL & ~E_NOTICE); //屏蔽未定义变量错误提示
            $this->assign('constname', "添加");
            $this->assign('actionname', "addAction");
            return $this->fetch('juleader');
        } else {
            $info = Juleader::get($getval['id']);
            $this->assign('info', $info);
            $this->assign('constname', "编辑");
            $this->assign('actionname', "editAction");
            return $this->fetch('juleader');
        }
    }

    public function addAction() {//新增方法
        $addpost = $this->request->param();
        $validate = new \app\admin\validate\Juleader;

        if (!$validate->check($addpost)) {
            return ajax_Jsonreport($validate->getError(), 0);
        }

        $add = new Juleader; // 实例化 Content模型       
        if ($add->save($addpost)) {
            return ajax_Jsonreport("添加成功", 1,"/admin/Juleadercontr");
        } else {
            return ajax_Jsonreport("添加失败", 0);

        }
    }

    public function editAction() {
        $editpost = $this->request->param();
        $validate = new \app\admin\validate\Juleader;
        if (!$validate->check($editpost)) {
            return ajax_Jsonreport($validate->getError(), 0);
        }

        $result = $this->validate($editpost, 'app\admin\validate\Juleader.sceneEdit'); //场景验证
        if (true !== $result) {
           return ajax_Jsonreport($result, 0);
        }
        $save = new Juleader;	
        $saved = $save->save($editpost, ['id' => $editpost['id']]);
        if ($saved) {
            return ajax_Jsonreport("修改成功", 1,"/admin/Juleadercontr");
        }
        return ajax_Jsonreport("修改失败", 0);
    }


    public function Del() {
        $getid = $this->request->param('id');
        $del = Juleader::destroy($getid);
        if ($del) {
            return ajax_Jsonreport("删除 领导信息ID  $getid  成功！", 1);
        }
        return ajax_Jsonreport("删除失败", 0);
    }

}
