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
        $loginpost = $this->request->post();
//        print_r($loginpost);
//        return;
        $validate = new \app\admin\validate\Login;
        if (!$validate->check($loginpost)) {
            return ajax_Jsonreport($validate->getError(), 0);
        }
        $userinfo = Admin::where('username', $loginpost['username'])->find();
        if (empty($userinfo) || $userinfo['password'] != md5($loginpost['password'])) {
            return ajax_Jsonreport("用户名密码错误！", 0);
        }
        if (!$userinfo['stauts'] || !$userinfo['group_id']) {
            return ajax_Jsonreport("用户状态异常，请联系管理员", 0);
        }

        // 更新登录信息,写入记录
        $ip = $this->request->ip();
        $data = [
            'last_login_time' => time(),
            'last_login_ip' => $ip
        ];
        if (!Admin::where('user_id', $userinfo['user_id'])->update($data)) {
            return ajax_Jsonreport("写入数据库错误！", 0);
        }
        //写入COOKIE
        if (in_array("remember-me", $loginpost)) {
            $cookieTime = 86400; //秒，一天
        } else {
            $cookieTime = 3600; //一小时
        }
        $this->adminuserInfo($userinfo, $cookieTime);

        //写入日志
        $model = new AdminLog;
        $model->addData(time(), $userinfo['username'], $ip, $this->request->url(), "登录操作");
        return ajax_Jsonreport("登录成功！", 1);
    }

    /**
     * 将用户信息及所在组信息写入cookie  并加密
     * 传入userinfo 值  array
     * * */
    public function adminuserInfo($userinfo, $cookieTime) {
        $admingroupinfo = Admingroup::get($userinfo['group_id']);
        //设置cookie
        $adminuserinfo = array(
            'user_id' => $userinfo['user_id'],
            'group_id' => $userinfo['group_id'],
            'username' => $userinfo['username'],
            'nicename' => $userinfo['nicename'],
            'last_login_time' => $userinfo['last_login_time'],
            'last_login_ip' => $userinfo['last_login_ip'],
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
