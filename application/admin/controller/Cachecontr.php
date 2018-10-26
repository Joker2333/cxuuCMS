<?php

namespace app\admin\controller;

use Env;
use Cache;

class Cachecontr extends \think\Controller {

    protected $middleware = ['Auth'];

    public function index() {
        $runtimeCachedirSize = round(dir_size(Env::get('runtime_path') . "/Cache/") / 1024, 2);
        $runtimeTempdirSize = round(dir_size(Env::get('runtime_path') . "/temp/") / 1024, 2);
        $runtimeLogdirSize = round(dir_size(Env::get('runtime_path') . "/log/") / 1024, 2);
        $this->assign("runtimeCachedirSize", $runtimeCachedirSize);
        $this->assign("runtimeTempdirSize", $runtimeTempdirSize);
        $this->assign("runtimeLogdirSize", $runtimeLogdirSize);
        return $this->fetch();
    }

    public function del() {
        $getID = $this->request->param('id');
        switch ($getID) {
			case 0:
                Cache::clear(); 
                return ajax_Jsonreport("清除Redis缓存成功！", 1);
            case 1:
                del_dir(Env::get('runtime_path') . "/Cache/");
                return ajax_Jsonreport("清除文件缓存成功！", 1);
            case 2:
                del_dir(Env::get('runtime_path') . "/temp/");
                return ajax_Jsonreport("清除程序缓存成功！", 1);
            case 3:
                if(del_dir(Env::get('runtime_path') . "/log/")){
                    return ajax_Jsonreport("清除日志文件成功！", 1);
                }else{
                    return ajax_Jsonreport("清除日志文件失败！", 0);
                }
                
        }
    }

}
