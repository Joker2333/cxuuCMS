<?php

namespace app\admin\model;

use think\Model;
use Tree;

class Channel extends Model
{

    protected $pk = 'id';

    /**
     * 无限级分类 只获取常用值   栏目权限操作页调用
     * @access public
     */
    static public function getCTree()
    {
        $getCxuuGroupId = getCxuuGroupId();
        $group_auth = getCxuuChannelAuth();
        if ($getCxuuGroupId == 1) {
            $data = Channel::order('sort asc')->field('id,name,pid,attribute')->select();
        } else {
            $data = Channel::order('sort asc')->whereIn('id', $group_auth)->field('id,name,pid,attribute')->select();
        }
        $tree = new Tree(array('id', 'pid', 'name', 'cname'));
        $categorys = $tree->getTree($data, 0);
        return $categorys;
    }

    /**
     * 无限级分类  获取数据库栏目全部数据  栏目管理页调用
     * @access public
     */
    static public function getCAllTree()
    {
        $getCxuuGroupId = getCxuuGroupId();
        $group_auth = getCxuuChannelAuth();
        if ($getCxuuGroupId == 1) {
            $data = Channel::order('sort asc')->select();
        } else {
            $data = Channel::order('sort asc')->whereIn('id', $group_auth)->select();
        }
        $tree = new Tree(array('id', 'pid', 'name', 'cname'));
        $categorys = $tree->getTree($data, 0);
        //print_r($categorys);
        return $categorys;
    }

    /**
     * JS无限级分类
     * @access public
     * @param Array $data //数据库里获取的结果集
     * @param Int $pid
     *作者：邓中华
     *创建时间：2018-10-1
     * @return array
     */
    static public function jsTree(&$data, $pid = 0)
    {
        $jsTreeList = array();
        foreach ($data as $value) {
            if ($value['pid'] == $pid) {
                $obj = array();
                $obj['id'] = $value['id'];
                $obj['text'] = $value['name'];
                //$obj['selectedIcon'] = "glyphicon glyphicon-stop";
                if ($value['attribute'] != 0) {
                    $obj['href'] = 'javascript:targetmain("/admin/contentcontr/?cid=' . $obj['id'] . '");';
                }else{
					$obj['selectable'] =  false;					
				}
                $obj['nodes'] = self::jsTree($data, $value['id']);
                array_push($jsTreeList, $obj);
            }
        }
        return $jsTreeList;
    }

    /**
     * @return array 内容页列表调用
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    static public function getJsTree()
    {
        $getCxuuGroupId = getCxuuGroupId();
        $group_auth = getCxuuChannelAuth();
        /** @var TYPE_NAME $getCxuuGroupId */
        if ($getCxuuGroupId == 1) {
            $data = Channel::field('id,name,pid,attribute')->order('sort asc')->all();
        } else {
            $data = Channel::whereIn('id', $group_auth)->field('id,name,pid,attribute')->order('sort asc')->select();
        }
        //$data = Channel::order('sort asc')->all();
        return self::jsTree($data);
    }

    /**
     * zTree 无限级分类  Menu 控制器调用
     * @access public
     *作者：邓中华
     *创建时间：2018-10-29
     * @return string
     * @throws \think\Exception\DbException
     */
    static public function getZTree()
    {
        $getCxuuGroupId = getCxuuGroupId();
        $group_auth = getCxuuChannelAuth();
        if ($getCxuuGroupId == 1) {
            $categoryList = Channel::field('id,name,pid,attribute')->order('sort asc')->all();
        } else {
            $categoryList = Channel::whereIn('id', $group_auth)->field('id,name,pid,attribute')->order('sort asc')->select();
        }
        $data = '';
        foreach ($categoryList as $value) {
            if ($value['attribute'] != 0) {
                $data .= '{ id:' . $value['id'] . ', pId:' . $value['pid'] . ', name:"' . $value['name'] . '",url:"javascript:targetmain(' . ' \\"/admin/contentcontr/?cid=' . $value['id'] . '\\"' . ');", open:true},';
            } else {
                $data .= '{ id:' . $value['id'] . ', pId:' . $value['pid'] . ', name:"' . $value['name'] . '", open:false},' . "\n";
            }
        }
        return $data;
    }


}
