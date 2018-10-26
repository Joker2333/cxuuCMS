<?php

namespace app\admin\model;

use think\Model;

class Content extends Model {

    protected $pk = 'id';

//定义一对一关联
    public function channel() {
        //除了关联模型外，其它参数都是可选。
        //关联模型（必须）：关联的模型名或者类名
        //外键：默认的外键规则是当前模型名（不含命名空间，下同）+_id ，例如user_id
        //主键：当前模型主键，默认会自动获取也可以指定传入
        return $this->hasOne('channel', 'id', 'cid');
    }

}
