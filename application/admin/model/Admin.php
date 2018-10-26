<?php
/***
* 龙啸轩网站管理系统 作者：邓中华 20181009
***/
namespace app\admin\model;

use think\Model;

class Admin extends Model {

    protected $pk = 'user_id';
    protected $type = [
        'last_login_time' => 'timestamp:Y/m/d H:i:s',
    ];

    public function admingroup() {
        return $this->hasOne('Admingroup', 'group_id', 'group_id');
    }


}
