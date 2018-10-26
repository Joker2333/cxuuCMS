<?php

namespace app\index\controller;

use app\index\model\Content;
//use app\index\model\ContentContent;
use app\index\model\Channel;
use think\facade\Cache;

class Info extends \think\Controller {

    public function _empty() {
            return error404();
    }

    public function index() {
        $id = request()->route('id');
        if(empty($id)){
             return error404();
        }
		
		if (Cache::get("findoncontent".$id)) {
			$cache = cache("findoncontent".$id);
		} else {
			$cache = Content::where('id', $id)->where('status',1)->find();
			//dump($cache = Content::hasWhere('ContentContent',['aid'=>$id])->select());
			Cache::set("findoncontent".$id, $cache,20);
		}
       
        Content::where('id', $id)->setInc('hits'); //阅读量递增
		
		$channelpath = Channel::getUrlTree($cache['cid']);
		$this->assign('channelpath', $channelpath);//获取栏目 树
		
        $this->assign('info', $cache);
        return $this->fetch('content');
    }

}
