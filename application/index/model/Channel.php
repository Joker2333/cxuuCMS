<?php

namespace app\index\model;

use think\Model;
use Tree;
class Channel extends Model {

    protected $pk = 'id';

    // 模型初始化
    protected static function init() {
        
    }
	
	
	/**
     * 获取洋葱皮路径
     * @access public 
     */
	static public function getUrlTree($cid) {
		$data = Channel::field('id,name,pid')->order('id asc')->select();
		$tree = new Tree(array('id', 'pid', 'name','cname'));
        $categorys = $tree->getPath($data,$cid);
        sort($categorys);// 以升序对数组排序
        return $categorys;
    }

}
