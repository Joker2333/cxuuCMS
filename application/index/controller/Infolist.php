<?php

namespace app\index\controller;

use think\facade\Cache;
use app\index\model\Channel;
use app\index\model\Content;

class Infolist extends \think\Controller
{

    public function _empty()
    {
        return error404();
    }

    public function index()
    {
        $getVal = $this->request->param('channelval'); // 获取get变量
        if (empty($getVal)) {
            return error404();
        }
        //获取栏目信息
        if (is_numeric($getVal)) {
            $channel = Channel::where('id', $getVal)->find(); //获取当前栏目
        } else {
            $channel = Channel::where('urlname', $getVal)->find(); //获取当前栏目
        }

        //$count = Content::count('id');->where('id','>',200200)
        $cache = Content::where('cid', $channel['id'])->field('id,title,created_date')->order('id desc')->paginate($channel['DisplayNum']);

 /*       if (Cache::get("channellist" . $channel['id'])) {
            $cache = cache("channellist" . $channel['id']);
        } else {
            $cache = Content::where('cid', $channel['id'])->where('status', 1)->field('id,title,created_date')->order('id desc')->paginate($channel['DisplayNum']);
            Cache::set("channellist" . $channel['id'], $cache, 200);
        }*/

        $page = $cache->render();

        $channelpath = Channel::getUrlTree($channel['id']);
        $this->assign('channelpath', $channelpath);

        $this->assign('list', $cache);
        $this->assign('channel', $channel);
        $this->assign('page', $page);
        if (empty($channel['Template'])) {
            return $this->fetch('List');
        } else {
            return $this->fetch($channel['Template']);
        }
    }
}
