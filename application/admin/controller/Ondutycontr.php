<?php
/**
 * 龙啸轩网站管理系统
 * 邓中华
 * 20181010
 */
namespace app\admin\controller;

use app\admin\model\Onduty;

class Ondutycontr extends \think\Controller {

    protected $middleware = ['Auth'];

     public function index() {
        $list = Onduty::order('sort ASC')->paginate(20);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }

    public function addedit() {
        $getval = $this->request->param();		
        if (empty($getval['id'])) {
            error_reporting(E_ALL & ~E_NOTICE); //屏蔽未定义变量错误提示
            $this->assign('constname', "添加");
            $this->assign('actionname', "addAction");
            return $this->fetch('onduty');
        } else {
            $info = Onduty::get($getval['id']);
            $this->assign('info', $info);
            $this->assign('constname', "编辑");
            $this->assign('actionname', "editAction");
            return $this->fetch('onduty');
        }
    }

    public function addAction() {//新增方法
        $addpost = $this->request->param();
        $validate = new \app\admin\validate\Onduty;

        if (!$validate->check($addpost)) {
            return ajax_Jsonreport($validate->getError(), 0);
        }

        $add = new Onduty; // 实例化 Content模型       
        if ($add->save($addpost)) {
            return ajax_Jsonreport("添加成功", 1,"/admin/Ondutycontr");
        } else {
            return ajax_Jsonreport("添加失败", 0);

        }
    }

    public function editAction() {
        $editpost = $this->request->param();
        $validate = new \app\admin\validate\Onduty;
        if (!$validate->check($editpost)) {
            return ajax_Jsonreport($validate->getError(), 0);
        }

        $save = new Onduty;	
        $saved = $save->save($editpost, ['id' => $editpost['id']]);
        if ($saved) {
            return ajax_Jsonreport("修改成功", 1,"/admin/Ondutycontr");
        }
        return ajax_Jsonreport("修改失败", 0);
    }


    public function Del() {
        $getid = $this->request->param('id');
        $del = Onduty::destroy($getid);
        if ($del) {
            return ajax_Jsonreport("删除 值班员信息ID  $getid  成功！", 1);
        }
        return ajax_Jsonreport("删除失败", 0);
    }



}