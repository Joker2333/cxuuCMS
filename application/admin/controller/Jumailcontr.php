<?php
/***
* 龙啸轩网站管理系统 
* 作者：邓中华 20181009
* 领导信箱
***/
namespace app\admin\controller;
use app\admin\model\Jumail;

class Jumailcontr extends \think\Controller {

    protected $middleware = ['Auth']; //中间件权限管理

    public function index() {
		$getuid = $this->request->param('uid');
		if(!empty($getuid)){
			$list = Jumail::where('uid',$getuid)->order('id DESC')->paginate(20);
		}else{
			$list = Jumail::order('id DESC')->paginate(20);
		}
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }

    public function addedit() {
        $getval = $this->request->param();
        $info = Jumail::get($getval['id']);
        $this->assign('info', $info);
        $this->assign('constname', "回复");
        $this->assign('actionname', "editAction");
        return $this->fetch('Jumail');
    }


    public function editAction() {
        $editpost = $this->request->param();
		$editpost['replytime'] = time();
        $save = new Jumail;	
        $saved = $save->save($editpost, ['id' => $editpost['id']]); 
        if ($saved) {
            return ajax_Jsonreport("回复成功", 1,"/admin/Jumailcontr");
        }
        return ajax_Jsonreport("回复失败", 0);
    }


    public function Del() {
        $getid = $this->request->param('id');
        $del = Jumail::destroy($getid);
        if ($del) {
            return ajax_Jsonreport("删除 邮件ID  $getid  成功！", 1);
        }
        return ajax_Jsonreport("删除失败", 0);
    }




}