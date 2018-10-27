<?php

namespace app\admin\controller;

use app\admin\model\Attachments;

class Attachmentscontr extends \think\Controller
{

    protected $middleware = ['Auth'];

    public function index()
    {
        $attlist = Attachments::order('id DESC')->paginate(20);

        $this->assign("attlist", $attlist);
        $page = $attlist->render();
        $this->assign('page', $page);
        return $this->fetch();
    }

    public function del()
    {
        $delId = $this->request->param('id');
        //echo $delFilename['fileurl'];
        $delFile = Attachments::get($delId);
        $delfilename = empty($delFile['fileurl']) ? "uploads" : $delFile['fileurl'];
        //      $delReport = del_file("." . $delfilename);
//        if($delReport == 1){
//            Attachments::destroy($delId);
//            return ajax_Jsonreport("文件删除成功",1);
//        }
//        
        switch (del_file("." . $delfilename)) {
            case 0 :
                return ajax_Jsonreport("要删除的文件不存在", 0);
            case 1:
                Attachments::destroy($delId);
                return ajax_Jsonreport("文件删除成功", 1);
            case 2:
                return ajax_Jsonreport("文件删除不成功，请检查权限", 0);
            default :
                return ajax_Jsonreport("删除失败", 0);
        }
    }

}
