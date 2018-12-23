<?php
/**
 * Created by 龙啸轩PHP 信息 管理系统.
 * User: 邓中华
 * Date: 2018/12/20
 */

namespace app\index\controller;

use app\index\model\Onlinemusic;
use think\facade\Cache;

class Music extends \think\Controller
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

        if (Cache::get("findOnOnlineMusic" . $id)) {
            $info = cache("findOnOnlineMusic" . $id);
        } else {
            $info = Onlinemusic::where('id', $id)->find();
            if (empty($info)) {
                return validateError("内容不存在，请勿非法操作");
            }
            Cache::set("findOnOnlineMusic" . $id, $info, 20);
        }

        Onlinemusic::where('id', $id)->field('hits')->setInc('hits'); //阅读量递增
        $this->assign('info', $info);
        return $this->fetch('music');

    }


}
