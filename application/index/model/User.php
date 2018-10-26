<?php

namespace app\index\model;

use think\Model;

class User extends Model {

    protected $pk = 'id';

    // 模型初始化
    protected static function init() {
        //TODO:初始化内容
        //$user = User::get(1);
        //echo $user->name;
    }

    public function scopeCxuu($query) {
        //$query->where('id','>',0);
    }

}
