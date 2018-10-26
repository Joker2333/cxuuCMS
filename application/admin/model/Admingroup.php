<?php

namespace app\admin\model;

use think\Model;

class AdminGroup extends Model {

    protected $pk = 'group_id';
    protected $type = [
        'base_purview' => 'serialize', //指定为序列化类型的话，数据会自动序列化写入，并且在读取的时候自动反序列化。
        'channel_purview' => 'serialize', //指定为序列化类型的话，数据会自动序列化写入，并且在读取的时候自动反序列化。
    ];

    //获取一条
    public function getOneAdminGroup($group_id) {
        $AdmingroupOneinfo = $this->get($group_id);
        return $AdmingroupOneinfo;
    }

    //获取指定 操作权限
    public function getAdminGroupBase($group_id) {
        $info = $this->get($group_id);
        return $info['base_purview'];
    }

    //存入指定 操作权限
    public function setAdminGroupBase($group_id, $data) {
        $this->update(['group_id' => $group_id, 'base_purview' => $data]);
        return true;
    }

    //获取指定 栏目权限
    public function getAdminGroupChannel($group_id) {
        $info = $this->get($group_id);
        return $info['channel_purview'];
    }

    //存入指定 栏目权限
    public function setAdminGroupChannel($group_id, $data) {
        $this->update(['group_id' => $group_id, 'channel_purview' => $data]);
        return true;
    }

}
