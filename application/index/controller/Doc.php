<?php
/**
 * Created by 龙啸轩PHP 信息 管理系统.
 * User: 邓中华
 * Date: 2018/10/28
 * Time: 12:34
 */

namespace app\index\controller;

use app\index\model\Documents;
use app\index\model\DocumentsContent;
use app\index\model\DocumentsSignin;
use think\facade\Cache;

class Doc extends \think\Controller
{

    public function _empty()
    {
        return error404();
    }

    public function index()
    {
        $id = request()->route('id');
        if (empty($id)) {
            return error404();
        }
//判断用户是否登录
        $userInfo = getCxuuCookie();
        if ($userInfo['user_id']) {
            $userStatus = 1;
        } else {
            $userStatus = 0;
        }

        if (Cache::get("findOnDoc" . $id)) {
            $info = cache("findOnDoc" . $id);
        } else {
            $info = Documents::where('id', $id)->find();
            if (empty($info)) {
                return validateError("内容不存在，请勿非法操作");
            }elseif(!$info['public']&&$userStatus==0){
                return validateError("此文件为非公开内容，如需查看签收本文件，请先登录管理后台，再刷新此页！");;
            }
            $info['content'] = DocumentsContent::where('aid', $id)->find();
            Cache::set("findOnDoc" . $id, $info, 20);
        }

        Documents::where('id', $id)->field('hits')->setInc('hits'); //阅读量递增

        //判断用户是否己经签收该文件count($docSignIn)>0
        $docSignIn = DocumentsSignin::where('aid', $id)->where('group_id', getCxuuGroupId())->find();
        if (!empty($docSignIn)) {
            $docSign = 1;
        } else {
            $docSign = 0;
        }
        $signList = DocumentsSignin::getList($id);
        $this->assign('signList', $signList);

        $this->assign('info', $info);
        $this->assign('docSign', $docSign);
        $this->assign('userStatus', $userStatus);
        $this->assign('userInfo', $userInfo);
        $this->assign('content', $info['content']);
        return $this->fetch('doc');

    }

    public function signInAction()
    {
        $post = $this->request->param();
        $id = $post['id'];
        $userInfo = getCxuuCookie();
        $signPost = [
            'aid' => $id,
            'signinname' => $userInfo['nicename'],
            'group_id' => $userInfo['group_id'],
            'groupname' => $userInfo['groupname'],
            'ip' => $this->request->ip(),
            'time' => time(),
            'status' => $post['signIn'],
        ];
        $save = new DocumentsSignin;
        $saved = $save->save($signPost);
        if ($saved) {
            return ajax_Jsonreport("签收成功", 1);
        }
        return ajax_Jsonreport("修改失败", 0);

    }

}
