<?php

namespace app\admin\model;

use think\Model;

class Content extends Model {

    protected $pk = 'id';

//定义一对一关联
    public function channel() {
        return $this->hasOne('channel', 'id', 'cid');
    }

    public function ContentContent()
    {
        return $this->hasOne('ContentContent','aid','id');
    }

}
