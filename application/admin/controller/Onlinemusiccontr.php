<?php
/**
 * Created by 龙啸轩PHP 信息 管理系统.
 * 文件发签控制器
 * User: 邓中华
 * Date: 2018/12/20
 * Time: 11:38
 */
namespace app\admin\controller;

use app\admin\model\Onlinemusic;
use app\admin\model\AdminLog;

class Onlinemusiccontr extends \think\Controller {

    protected $middleware = ['Auth'];

    public function index() {
        $searchInfo = $this->request->param();
        error_reporting(E_ALL & ~E_NOTICE); //屏蔽未定义变量错误提示
		$status = $searchInfo['status'];
        $title = $searchInfo['title'];
        $query = [];
		if(getCxuuGroupId() != 1){
			array_push($query, ['user_id', '=', getCxuuUserId()]);
		}
        if ($status != '') {
            array_push($query, ['status', '=', $status]);
        }
		if (!empty($title)) {
            array_push($query, ['title', 'like', '%' . $title . '%']);
        }

        //根据条件列表
        $list = Onlinemusic::where($query)
                ->order('id', 'desc')
                ->paginate(20, false, ['query' => $searchInfo]);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }

    public function addEdit() {
        $getInfo = $this->request->param();
		$userInfo = getCxuuCookie();
        $this->assign('contr', $this->request->controller() . '/' . $this->request->action()); //传递给上传器 控制器及方法名称
        $this->assign('userinfo', $userInfo);
        if (empty($getInfo['id'])) {
            error_reporting(E_ALL & ~E_NOTICE); //屏蔽未定义变量错误提示
            $this->assign('constname', "添加");
            $this->assign('actionname', "addAction");
            $this->assign('getcid', $getInfo['cid']);
            return $this->fetch('Onlinemusic');
        } else {
            error_reporting(E_ALL & ~E_NOTICE); //屏蔽未定义变量错误提示
			if($userInfo['group_id'] == 1){
				//超级管理员不受限制
				$find = Onlinemusic::where('id', $getInfo['id'])->find();
			}else{
				$find = Onlinemusic::where('id', $getInfo['id'])->where('user_id', getCxuuUserId())->find();
			}
            if ($find) {
                $this->assign('info', $find);
                $this->assign('constname', "编辑");
                $this->assign('actionname', "editAction");
                $this->assign('getcid', $getInfo['cid']);
                return $this->fetch('Onlinemusic');
            } else {
                return '你没有权限编辑此条信息';
            }
        }
    }

    public function addAction() {
        $addPost = $this->request->post();
        $validate = new \app\admin\validate\Onlinemusic();
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
        $add = Onlinemusic::create($addPost);
        if ($add) {
			//写入日志
            $ip = $this->request->ip();
			$model = new AdminLog;
            $model->addData(time(), $userInfo['username'], $ip, $this->request->url(), "添加在线音乐 ID:".$add->id);
            return ajax_Jsonreport("添加成功", 1, "/admin/Onlinemusiccontr");
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
            $edit = Onlinemusic::get($id);
            $edit->save($editPost, ['id' => $id]);
            if ($edit) {
                //写入日志
                $ip = $this->request->ip();
                $userInfo = getCxuuCookie();// 实例化 用户信息模型
                $model = new AdminLog;
                $model->addData(time(), $userInfo['username'], $ip, $this->request->url(), "修改在线音乐 ID:".$id);
                return ajax_Jsonreport("修改成功", 1, "/admin/Onlinemusiccontr");
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
			$del = Onlinemusic::where('id', $id)->delete();
		}else{
			$del = Onlinemusic::where('id', $id)->where('user_id', $userInfo['user_id'])->delete();
			if(!$del){
                return ajax_Jsonreport("你不能删除不属于你的内容", 0);
            }
		}
        if ($del) {
            //写入日志
            $ip = $this->request->ip();
            $model = new AdminLog;
            $model->addData(time(), $userInfo['username'], $ip, $this->request->url(), "删除在线音乐 ID:".$id);
            return ajax_Jsonreport("删除成功", 1);
        } else {
            return ajax_Jsonreport("删除失败或你不能删除不属于你的在线音乐内容", 0);
        }
    }

	//批量操作
    public function batchOperation() {
        $content = $this->request->param();
        $ip = $this->request->ip();
        $userInfo = getCxuuCookie();// 实例化 用户信息模型
        $model = new AdminLog;
		$status = $content["status"];
		$id = $content["id"];
		$id_array=explode(',', $id);
		switch($status){
			case 2:
                //审核
                foreach ($id_array as $value) {
					$Operation = Onlinemusic::get($value);
					$Operation->status     = 1;
					$Operation->save();
                }
                //写入日志
                $model->addData(time(), $userInfo['username'], $ip, $this->request->url(), "批量审核在线音乐 ID:".$id);
				return ajax_Jsonreport("批量审核成功", 1);
                break;
            case 3:
                //取消审核
                foreach ($id_array as $value) {
					$Operation = Onlinemusic::get($value);
					$Operation->status     = 0;
					$Operation->save();
                }
                //写入日志
                $model->addData(time(), $userInfo['username'], $ip, $this->request->url(), "批量取消审核在线音乐 ID:".$id);
				return ajax_Jsonreport("批量取消审核成功", 1);
                break;
            case 4:
                //删除
                $Operation = Onlinemusic::destroy($id);
				if($Operation){
                    //写入日志
                    $model->addData(time(), $userInfo['username'], $ip, $this->request->url(), "批量删除在线音乐 ID:".$id);
					return ajax_Jsonreport("批量删除成功", 1);
				}else{
					return ajax_Jsonreport("批量删除失败", 0);
				}
                break;
		}

    }

}
