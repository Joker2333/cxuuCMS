<?php

namespace app\admin\controller;

class Menu extends \think\Controller {

    // protected $middleware = ['Auth'];

    public function index() {

        return $this->fetch();
    }

    public function content() {
        return $this->fetch();
    }

    public function admin() {
        return $this->fetch();
    }

    public function channel() {
        return $this->fetch();
    }

    public function setting() {
        return $this->fetch();
    }
    public function application(){
        return $this->fetch();
    }

}
