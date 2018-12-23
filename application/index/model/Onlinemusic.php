<?php

namespace app\index\model;

use think\Model;

class Onlinemusic extends Model {

    protected $pk = 'id';
    // 定义全局的查询范围
    protected $globalScope = ['status'];
    public function scopeStatus($query)
    {
        $query->where('status',1);
    }

}
