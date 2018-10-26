<?php
namespace app\http\middleware;

class Auth {

    public function handle($request, \Closure $next) {
        /**
          判断操作权限中间件
          路径和Session 判断
         * */
        //$module = $request->module();
        $controler = $request->controller();
        $action = $request->action();
        $userinfo = getCxuuCookie();
        if ($userinfo['group_id'] != 1) {
            $basepurview = $userinfo['base_purview'];
            $contrAndAction = strtolower($controler . "_" . $action); //转换成小写
            foreach ($basepurview as &$item) {
                $item = strtolower($item); //递归转换成小写json_encode(array('msg' => '你没有权限访问这项功能！', 'result' => '1'))
            }
            if (!in_array($contrAndAction, $basepurview)) {
               return response("<script> layer.msg('你无权限操作此栏目！',{icon: 5,offset: '100px',time:'3000'});</script>");
                //return redirect("/admin/contentcontr/");
            }
        }
        return $next($request);
    }

}
