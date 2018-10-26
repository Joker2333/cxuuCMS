<?php

namespace app\index\controller;

class Index extends \think\Controller {

    public function _empty() {
        return error404();
    }

    public function index() {
        return $this->fetch();
    }

}
