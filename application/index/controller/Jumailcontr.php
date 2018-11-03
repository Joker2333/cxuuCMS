<?php
/**
 * 龙啸轩网站管理系统
 * 邓中华
 * 20181010
 */
namespace app\index\controller;

use app\index\model\Jumail;
use app\index\model\Juleader;

class Jumailcontr extends \think\Controller {

    public function _empty() {
            return error404();
    }

    public function index() {
		$getuid = $this->request->param('uid');
		if(!empty($getuid)){
			$list = Jumail::where('uid',$getuid)->order('id DESC')->paginate(20);
			$ldname = Juleader::get($getuid);
		}else{
			return error404();
		}
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('ldname', $ldname['name']);
        $this->assign('page', $page);
        return $this->fetch('maillist');
    }

	public function writeMail() {
		$getuid = $this->request->param('uid');
		$ldname = Juleader::get($getuid);
		$this->assign('ldname', $ldname['name']);
		$this->assign('uid', $getuid);
        return $this->fetch('wirtemail');
    }

    public function addAction() {//新增方法
        $addpost = $this->request->param();
		$validate = new \app\index\validate\Jumail;
		if (!$validate->check($addpost)) {
			return ajax_Jsonreport($validate->getError(),0);
        }
        if(!captcha_check($addpost['checkcode'])) {
            return ajax_Jsonreport("验证码错误", 0);
        }
		
		$mail = new Jumail([
			'uid'		=>$addpost['uid'],
			'writename'	=>$addpost['writename'],
			'department'=>$addpost['department'],
			'phone'		=>$addpost['phone'],
			'title'		=>$addpost['title'],
			'category'	=>$addpost['category'],
			'content'	=>$addpost['content'],
			'addr'		=>$addpost['addr'],
			'greatttime'=>$this->request->time(),
			'ip'		=>$this->request->ip()
		]);
		$mail->save();

    
        if ($mail) {
            return ajax_Jsonreport("添加成功", 1,"/index/Juleadermail");
        } else {
            return ajax_Jsonreport("添加失败", 0);

        }
    }

}
