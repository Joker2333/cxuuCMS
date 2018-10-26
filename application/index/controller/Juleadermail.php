<?php

namespace app\index\controller;

use app\index\model\Juleader;
use think\facade\Cache;

class Juleadermail extends \think\Controller {

    public function _empty() {
            return error404();
    }

    public function index() {
		
		if (Cache::get("Juleadermailindex")) {
			$cache = cache("Juleadermailindex"); //如果有缓存则在缓存中读取数据 
		} else {
			$cache = Juleader::all()->order('sort','asc');
			//dump($cache);
			Cache::set("Juleadermailindex", $cache,500); //没有缓存则链接数据表获取数据并写入缓存 
		}
		
        $this->assign('list', $cache);
        return $this->fetch('juleaderlist');
    }

}
