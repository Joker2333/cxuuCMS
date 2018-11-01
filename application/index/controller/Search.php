<?php
/**
 * 龙啸轩网站管理系统
 * 邓中华
 * 20181010
 */
namespace app\index\controller;

use app\index\model\Channel;
use app\index\model\Content;

class Search extends \think\Controller {

    public function _empty() {
        return error404();
    }

    public function index() {
        $keywordsArry = $this->request->param();
		$keywords = $keywordsArry['keywords'];
		$validate = new \app\index\validate\Search;

        if (!$validate->check($keywordsArry)) {
			validateError($validate->getError());
        }		
        $list = Content::where('title', 'like', '%'.$keywords.'%')
                        ->order('id desc')
						->paginate(20, false, ['query' => $keywordsArry]);
        //$list = Db::query("SELECT * FROM `cxuu_content` WHERE `title` LIKE '%{$keywords}%' order by id desc limit 0,20");
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('keywords', $keywords);
        $this->assign('page', $page);
        return $this->fetch('search');
    }

}
