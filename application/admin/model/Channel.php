<?php

namespace app\admin\model;

use think\Model;
use Tree;
use app\admin\model\Admingroup;

class Channel extends Model {

    protected $pk = 'id';


    /**
     * 无限级分类
     * @access public 
     * @param Array $data     //数据库里获取的结果集 
     * @param Int $pid             
     * @param Int $count       //第几级分类
     * @return Array $treeList   
	 作者：邓中华;
		创建时间：2018-10-1;
		最后修改时间：
     */
    static private $treeList = array(); //存放无限分类结果如果一页面有多个无限分类可以使用 Tool::$treeList = array(); 清空


/*     static private function tree(&$data, $pid = 0, $count = 1) {
        $userinfo = getCxuuCookie();
        $channelAuth = $userinfo['channel_purview'];
        foreach ($data as $key => $value) {
            if ($userinfo['group_id'] == 1) {
                if ($value['pid'] == $pid) {
                    $value['count'] = $count;
                    self::$treeList [] = $value;
                    unset($data[$key]);
                    self::tree($data, $value['id'], $count + 1);
                }
            } elseif (in_array($value['id'], $channelAuth)) {
                if ($value['pid'] == $pid) {
                    $value['count'] = $count;
                    self::$treeList [] = $value;
                    unset($data[$key]);
                    self::tree($data, $value['id'], $count + 1);
                }
            }
        }
        return self::$treeList;
    }

	static public function getTree() {
        $data = Channel::order('sort asc')->all();
        return self::tree($data);
    }  */
	
	
    /**
     * 无限级分类 只获取常用值
     * @access public 
     */
	static public function getCTree() {
		$getCxuuGroupId = getCxuuGroupId();
		$group_auth = getCxuuChannelAuth();
		if($getCxuuGroupId == 1){
			$data = Channel::order('sort asc')->field('id,name,pid,attribute')->select();
		}else{
			$data = Channel::order('sort asc')->whereIn('id',$group_auth)->field('id,name,pid,attribute')->select();
		}
		$tree = new Tree(array('id', 'pid', 'name','cname'));
        $categorys = $tree->getTree($data,0);
        //print_r($categorys);
        return $categorys;
    }
	    /**
     * 无限级分类  获取数据库栏目全部数据
     * @access public 
     */
		static public function getCAllTree() {
		$getCxuuGroupId = getCxuuGroupId();
		$group_auth = getCxuuChannelAuth();
		if($getCxuuGroupId == 1){
			$data = Channel::order('sort asc')->select();
		}else{
			$data = Channel::order('sort asc')->whereIn('id',$group_auth)->select();
		}
		$tree = new Tree(array('id', 'pid', 'name','cname'));
        $categorys = $tree->getTree($data,0);
        //print_r($categorys);
        return $categorys;
    }

    /**
     * JS无限级分类
     * @access public 
     * @param Array $data     //数据库里获取的结果集 
     * @param Int $pid             
     * @param Int $count       //第几级分类
		作者：邓中华;
		创建时间：2018-10-1;
		最后修改时间：
     */
    static public function jsTree(&$data, $pid = 0) {
        $jsTreeList = array();
        $userinfo = getCxuuCookie();
        $channelAuth = $userinfo['channel_purview'];
        foreach ($data as $value) {
            if ($userinfo['group_id'] == 1) {
                if ($value['pid'] == $pid) {
                    $obj = array();
                    $obj['id'] = $value['id'];
                    $obj['text'] = $value['name'];
                    if ($value['attribute'] != 0) {
                        $obj['href'] = 'javascript:targetmain("/admin/contentcontr/?cid=' . $obj['id'] . '");';
                    }
                    $obj['nodes'] = self::jsTree($data, $value['id']);
                    array_push($jsTreeList, $obj);
                }
            } elseif (in_array($value['id'], $channelAuth)) {
                if ($value['pid'] == $pid) {
                    $obj = array();
                    $obj['id'] = $value['id'];
                    $obj['text'] = $value['name'];
                    if ($value['attribute'] != 0) {
                        $obj['href'] = 'javascript:targetmain("/admin/contentcontr/?cid=' . $obj['id'] . '");';
                    }
                    $obj['nodes'] = self::jsTree($data, $value['id']);
                    array_push($jsTreeList, $obj);
                }
            }
        }
        return $jsTreeList;
    }

    static public function getJsTree() {
        $data = Channel::order('sort asc')->all();
        return self::jsTree($data);
    }

}
