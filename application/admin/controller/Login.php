<?php

namespace app\admin\controller;

use Cookie;
use app\admin\model\Admin;
use app\admin\model\AdminLog;
use app\admin\model\Admingroup;

class Login extends \think\Controller {

    public function index() {
        return $this->fetch('login');
    }

    public function loginAction() {
        $loginPost = $this->request->post();
        $model = new AdminLog;
        $ip = $this->request->ip();
        $validate = new \app\admin\validate\Login;
        if (!$validate->check($loginPost)) {
            return ajax_Jsonreport($validate->getError(), 0);
        }
        $userInfo = Admin::where('username', $loginPost['username'])->find();
        if (empty($userInfo) || $userInfo['password'] != md5($loginPost['password'])) {
            //写入日志
            $model->addData(time(), $loginPost['username'], $ip, $this->request->url(), "登录操作-用户名密码错误！");
            return ajax_Jsonreport("用户名密码错误！", 0);
        }
        if (!$userInfo['stauts'] || !$userInfo['group_id']) {
            //写入日志
            $model->addData(time(), $loginPost['username'], $ip, $this->request->url(), "登录操作-用户状态异常！");
            return ajax_Jsonreport("用户状态异常，请联系管理员", 0);
        }

        // 更新登录信息,写入记录
        $data = [
            'last_login_time' => time(),
            'last_login_ip' => $ip
        ];
        if (!Admin::where('user_id', $userInfo['user_id'])->update($data)) {
            return ajax_Jsonreport("写入数据库错误！", 0);
        }
        //写入COOKIE
        if (in_array("remember-me", $loginPost)) {
            $cookieTime = 86400; //秒，一天
        } else {
            $cookieTime = 3600; //一小时
        }
        $this->adminuserInfo($userInfo, $cookieTime);

        //写入日志
        $model->addData(time(), $userInfo['username'], $ip, $this->request->url(), "登录操作-登录成功");
        return ajax_Jsonreport("登录成功！", 1);
    }

    /**
     * 将用户信息及所在组信息写入cookie  并加密
     * 传入userinfo 值  array
     * * */
    public function adminuserInfo($userInfo, $cookieTime) {
        $admingroupinfo = Admingroup::get($userInfo['group_id']);
        //设置cookie
        $adminuserinfo = array(
            'user_id' => $userInfo['user_id'],
            'group_id' => $userInfo['group_id'],
            'username' => $userInfo['username'],
            'nicename' => $userInfo['nicename'],
            'last_login_time' => $userInfo['last_login_time'],
            'last_login_ip' => $userInfo['last_login_ip'],
            'groupname' => $admingroupinfo['groupname'],
            'base_purview' => $admingroupinfo['base_purview'],
            'channel_purview' => $admingroupinfo['channel_purview'],
        );
        Cookie::set('cxuu_admin_user', encrypt(serialize($adminuserinfo)), $cookieTime);
        return true;
    }

    /**
     * 退出登录
     */
    public function loginout() {
        Cookie::delete('cxuu_admin_user');
        return ajax_Jsonreport("登出成功！", 1);
    }

}
