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
        $content = $searchInfo['content']; 
		$userinfo = getCxuuCookie();		
        $userId = $userinfo['user_id'];
        $query = [];
		if($userinfo['group_id'] != 1){
			array_push($query, ['user_id', '=', $userId]);
		}
        if (!empty($status)) {
            array_push($query, ['status', '=', $status]);
        }
		if (!empty($title)) {
            array_push($query, ['title', 'like', '%' . $title . '%']);
        }
        if (!empty($content)) {
            array_push($query, ['content', 'like', '%' . $content . '%']);
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
        $channeltree = Channel::getCTree();
        $this->assign('channeltree', $channeltree);
        $this->assign('channelId', $channelId);
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }

    public function addedit() {
        $getInfo = $this->request->param();		
        $channellist = Channel::select();
        $channeltree = Channel::getCTree();
		$userinfo = getCxuuCookie();
        $this->assign('contr', $this->request->controller() . '/' . $this->request->action()); //传递给上传器 控制器及方法名称
        $this->assign('channellist', $channellist);
        $this->assign('userinfo', $userinfo);
        $this->assign('channeltree', $channeltree);
        if (empty($getInfo['id'])) {
            error_reporting(E_ALL & ~E_NOTICE); //屏蔽未定义变量错误提示
            $this->assign('constname', "添加");
            $this->assign('actionname', "addAction");
            $this->assign('getcid', $getInfo['cid']);
            return $this->fetch('content');
        } else {
            error_reporting(E_ALL & ~E_NOTICE); //屏蔽未定义变量错误提示
			if($userinfo['group_id'] == 1){
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
        $addpost = $this->request->post();
        $validate = new \app\admin\validate\Content;
        if (!$validate->check($addpost)) {
            return ajax_Jsonreport($validate->getError(), 0);
        }
        $addpost['created_date'] = time();
		$userinfo = getCxuuCookie();// 实例化 用户信息模型
        $addpost['user_id'] = $userinfo['user_id'];
        $addpost['usergroupname'] = $userinfo['groupname'];
        $add = new Content; 
        if ($add->save($addpost)) {
            return ajax_Jsonreport("添加成功", 1, "/admin/contentcontr");
        } else {
            return ajax_Jsonreport("添加失败", 0);
        }
    }

    public function editAction() {
        $id = $this->request->post('id');
        if ($id) {
            $editpost = $this->request->post();
            $editpost['edited_date'] = time();
			if(empty($editpost['position_a'])){
				$editpost['position_a'] = 0;
			}
			if(empty($editpost['position_b'])){
				$editpost['position_b'] = 0;
			}
			if(empty($editpost['position_c'])){
				$editpost['position_c'] = 0;
			}
				
            //$editpost['user_id'] = '';
            $user = new Content;
            // save方法第二个参数为更新条件
            if ($user->save($editpost, ['id' => $id])) {
                return ajax_Jsonreport("修改成功", 1, "/admin/contentcontr");
            } else {
                return ajax_Jsonreport("修改失败", 0);
            }
        }
    }

    public function Delete() {
        $id = $this->request->get('id');
		$userinfo = getCxuuCookie();
		if($userinfo['group_id'] == 1){
			//超级管理员不受限制
			$del = Content::where('id', $id)->delete();
		}else{
			$del = Content::where('id', $id)->where('user_id', getCxuuUserId())->delete();
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
