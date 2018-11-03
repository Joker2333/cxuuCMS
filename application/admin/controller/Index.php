<?php

namespace app\admin\controller;

use app\admin\model\Content;
//use app\admin\model\Channel;
use app\admin\model\Admin;
use app\admin\model\Jumail;

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

        $contentCount = Content::where('status',0)->count();
        $content = Content::count();
        //$channelCount = Channel::count();
        $adminCount = Admin::count();
        $jumailCount = Jumail::whereNull('reply')->count();
		
		$ip = $this->request->ip();

        $this->assign('ip', $ip);
        $this->assign('content', $content);
        $this->assign('contentCount', $contentCount);
        //$this->assign('channelCount', $channelCount);
        $this->assign('adminCount', $adminCount);
        $this->assign('jumailCount', $jumailCount);
        return $this->fetch('home');
    }

}
