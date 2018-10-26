<?php

namespace app\admin\model;

use think\Model;

class Attachments extends Model {

    protected $pk = 'id';
    protected $type = [
        'updatetime' => 'timestamp:Y/m/d H:i:s',
    ];

}
