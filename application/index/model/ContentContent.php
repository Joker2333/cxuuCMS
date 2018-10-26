<?php

namespace app\index\model;

use think\Model;
class ContentContent extends Model {

    protected $pk = 'aid';

    public function Content()
    {
        return $this->belongsTo('Content');
    }


}
