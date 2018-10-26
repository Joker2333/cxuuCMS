<?php

namespace app\index\controller;

use Db;
use View;
use Request;
use app\index\model\User;

class Userlist extends \think\Controller {

    public function index() {

        $user = User::paginate(1);


        // 获取分页显示
        //$test = User::scope('cxuu')->find();
        // 模板变量赋值
        //$this->assign('test', $test);
        $page = $user->render();
        $this->assign('page', $page);
        $this->assign('user', $user);
        return $this->fetch();
    }

}
