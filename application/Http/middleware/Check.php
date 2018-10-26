<?php

namespace app\http\middleware;

class Check {

    public function handle($request, \Closure $next) {
        /**
          判断是否登录中间件
          路径和Session 判断
         * */
        if (!strpos($request->path(), 'login') && !$request->cookie('cxuu_admin_user')) {
            return redirect('/admin/login');
        }
        return $next($request);
    }

}
