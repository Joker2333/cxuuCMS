<?php

namespace app\admin\controller;

use app\admin\model\Content;
use app\admin\model\Channel;
use app\admin\model\Admin;
use app\admin\model\Attachments;

use Tree;

class Index extends \think\Controller {

    protected $middleware = ['Auth'];

    public function index() {
        return $this->fetch();
    }

    public function leftmenu() {
        return $this->fetch();
    }

    public function home() {
        $usergroup = getCxuuCookie();
        $this->assign('usergroup', $usergroup);

        $contentCount = Content::count();
        $channelCount = Channel::count();
        $adminCount = Admin::count();
        $attachmentsCount = Attachments::count();
		
		$ip = $this->request->ip();

        $this->assign('ip', $ip);
        $this->assign('contentCount', $contentCount);
        $this->assign('channelCount', $channelCount);
        $this->assign('adminCount', $adminCount);
        $this->assign('attachmentsCount', $attachmentsCount);
        return $this->fetch('home');
    }

}
