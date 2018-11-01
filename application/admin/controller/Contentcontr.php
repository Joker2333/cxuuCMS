<?php

namespace app\admin\controller;

use app\admin\model\Content;
use app\admin\model\Channel;

class Contentcontr extends \think\Controller {

    protected $middleware = ['Auth'];

    public function index() {
        $searchInfo = $this->request->param();
        error_reporting(E_ALL & ~E_NOTICE); //屏蔽未定义变量错误提示		
        $channelId = $searchInfo['cid'];
		$status = $searchInfo['status'];
        $title = $searchInfo['title'];
        $query = [];
		if(getCxuuGroupId() != 1){
			array_push($query, ['user_id', '=', getCxuuUserId()]);
		}
        if (!empty($status)) {
            array_push($query, ['status', '=', $status]);
        }
		if (!empty($title)) {
            array_push($query, ['title', 'like', '%' . $title . '%']);
        }
        if (!empty($channelId)) {
            array_push($query, ['cid', '=', $channelId]);
        }
        //根据条件列表
        $list = Content::where($query)
                ->order('id', 'desc')
				//->where('image','=', 'not null')
                ->paginate(20, false, ['query' => $searchInfo]);
        $page = $list->render();
        $channelTree = Channel::getCTree();
        $this->assign('channeltree', $channelTree);
        $this->assign('channelId', $channelId);
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }

    public function addedit() {
        $getInfo = $this->request->param();
        $channelList = Channel::select();
        $channelTree = Channel::getCTree();
		$userInfo = getCxuuCookie();
        $this->assign('contr', $this->request->controller() . '/' . $this->request->action()); //传递给上传器 控制器及方法名称
        $this->assign('channellist', $channelList);
        $this->assign('userinfo', $userInfo);
        $this->assign('channeltree', $channelTree);
        if (empty($getInfo['id'])) {
            error_reporting(E_ALL & ~E_NOTICE); //屏蔽未定义变量错误提示
            $this->assign('constname', "添加");
            $this->assign('actionname', "addAction");
            $this->assign('getcid', $getInfo['cid']);
            return $this->fetch('content');
        } else {
            error_reporting(E_ALL & ~E_NOTICE); //屏蔽未定义变量错误提示
			if($userInfo['group_id'] == 1){
				//超级管理员不受限制
				$find = Content::where('id', $getInfo['id'])->find();
			}else{
				$find = Content::where('id', $getInfo['id'])->where('user_id', getCxuuUserId())->find();
			}
            if ($find) {
                $this->assign('info', $find);
                $this->assign('constname', "编辑");
                $this->assign('actionname', "editAction");
                $this->assign('getcid', $getInfo['cid']);
                return $this->fetch('content');
            } else {
                return '你没有权限编辑此条信息';
            }
        }
    }

    public function addAction() {
        $addPost = $this->request->post();
        $validate = new \app\admin\validate\Content;
        if (!$validate->check($addPost)) {
            return ajax_Jsonreport($validate->getError(), 0);
        }
        $addPost['created_date'] = time();
        if($addPost['image'] != ''){
            $addPost['imageBL'] = 1; //如果有图片，则判断字段为1,利于SQL优化
        }
		$userInfo = getCxuuCookie();// 实例化 用户信息模型
        $addPost['user_id'] = $userInfo['user_id'];
        $addPost['usergroupname'] = $userInfo['groupname'];
        /*   $a=1;
          while ($a<50000){
             $add = Content::create($addPost);
            $add->ContentContent()->save(['content' => $addPost['content']]);//关联写入
           $a++;
          }
  /*        for($i=1;$i<100000;+){
              Content::create($addPost);
          }*/
        $add = Content::create($addPost);
        $add->ContentContent()->save(['content' => $addPost['content']]);//关联写入
        if ($add) {
            return ajax_Jsonreport("添加成功", 1, "/admin/contentcontr");
        } else {
            return ajax_Jsonreport("添加失败", 0);
        }
    }

    public function editAction() {
        $id = $this->request->post('id');
        if ($id) {
            $editPost = $this->request->post();
            $editPost['edited_date'] = time();
			if(empty($editPost['position_a'])){
                $editPost['position_a'] = 0;
			}
			if(empty($editPost['position_b'])){
                $editPost['position_b'] = 0;
			}
			if(empty($editPost['position_c'])){
                $editPost['position_c'] = 0;
			}
            if($editPost['image'] != ''){
                $editPost['imageBL'] = 1; //如果有图片，则判断字段为1,利于SQL优化
            }else{
                $editPost['imageBL'] = 0;
            }
            $edit = new Content;
            $edit->save($editPost, ['id' => $id]);
            $edit->ContentContent()->save([
                'content' => $editPost['content'],   //关联写入
            ]);
            if ($edit) {
                return ajax_Jsonreport("修改成功", 1, "/admin/contentcontr");
            } else {
                return ajax_Jsonreport("修改失败", 0);
            }
        }
    }

    public function Delete() {
        $id = $this->request->get('id');
		$userInfo = getCxuuCookie();
		if($userInfo['group_id'] == 1){
			//超级管理员不受限制
			$del = Content::where('id', $id)->delete();
		}else{
			$del = Content::where('id', $id)->where('user_id', $userInfo['user_id'])->delete();
		}
        if ($del) {
            return ajax_Jsonreport("删除成功", 1);
        } else {
            return ajax_Jsonreport("删除失败或没有权限", 0);
        }
    }

	//批量操作
    public function batchOperation() {
        $content = $this->request->param();
		$status = $content["status"];
		$id = $content["id"];
		$cid = $content["cid"];
		$id_array=explode(',', $id);
		switch($status){
			case 1:
			//转移栏目
				foreach ($id_array as $value) {
                    $Operation = Content::get($value);
					$Operation->cid     = $cid;
					$Operation->save();
                }
				return ajax_Jsonreport("转移成功", 1);
				break;
			case 2:
                //审核
                foreach ($id_array as $value) {
					$Operation = Content::get($value);
					$Operation->status     = 1;
					$Operation->save();
                }
				return ajax_Jsonreport("批量审核成功", 1);
                break;
            case 3:
                //取消审核
                foreach ($id_array as $value) {
					$Operation = Content::get($value);
					$Operation->status     = 0;
					$Operation->save();
                }
				return ajax_Jsonreport("批量取消审核成功", 1);
                break;
            case 4:
                //删除
                $Operation = Content::destroy($id);
				if($Operation){
					return ajax_Jsonreport("批量删除成功", 1);
				}else{
					return ajax_Jsonreport("批量删除失败", 0);
				}
                break;
		}

    }

}
