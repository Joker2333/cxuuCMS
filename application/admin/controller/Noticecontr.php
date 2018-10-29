<?php
/**
 * Created by 龙啸轩PHP 信息 管理系统.
 * User: 邓中华
 * Date: 2018/10/28
 * Time: 12:38
 */

namespace app\admin\controller;

use app\admin\model\Notice;

class Noticecontr extends \think\Controller {

    protected $middleware = ['Auth'];

    public function index() {
        $list = Notice::order('id DESC')->paginate(20);
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
            return $this->fetch('notice');
        } else {
            $info = Notice::get($getval['id']);
            $this->assign('info', $info);
            $this->assign('constname', "编辑");
            $this->assign('actionname', "editAction");
            return $this->fetch('notice');
        }
    }

    public function addAction() {//新增方法
        $addPost = $this->request->param();
        $validate = new \app\admin\validate\Notice();

        if (!$validate->check($addPost)) {
            return ajax_Jsonreport($validate->getError(), 0);
        }

        $postData = [
            'did' => $addPost['did'],
            'title' => $addPost['title'],
            'content' => $addPost['content'],
            'publisher' => $addPost['publisher'],
            'created_date' => time(),
            'status' => 	$addPost['status'],
        ];

        $add = Notice::create($postData); // 静态方法
        if ($add) {
            return ajax_Jsonreport("添加成功", 1,"/admin/Noticecontr");
        } else {
            return ajax_Jsonreport("添加失败", 0);

        }
    }

    public function editAction() {
        $editPost = $this->request->param();
        $validate = new \app\admin\validate\Notice();
        if (!$validate->check($editPost)) {
            return ajax_Jsonreport($validate->getError(), 0);
        }
        $editData = [
            'did' => $editPost['did'],
            'title' => $editPost['title'],
            'content' => $editPost['content'],
            'publisher' => $editPost['publisher'],
            'status' => 	$editPost['status'],
        ];
        $save = Notice::where('id',$editPost['id'])->update($editData);
        if ($save) {
            return ajax_Jsonreport("修改成功", 1,"/admin/Noticecontr");
        }
        return ajax_Jsonreport("修改失败", 0);
    }


    public function Del() {
        $getId = $this->request->param('id');
        $del = Notice::destroy($getId);
        if ($del) {
            return ajax_Jsonreport("删除 公告  ID  $getId  的内容成功！", 1);
        }
        return ajax_Jsonreport("删除失败", 0);
    }



}