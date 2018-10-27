<?php

namespace app\admin\controller;

use app\admin\model\AdminLog;

class Adminlogcontr extends \think\Controller
{

    public function index()
    {

        $list = AdminLog::order('log_id', 'desc')->paginate(20);

        // 获取分页显示
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }

}
