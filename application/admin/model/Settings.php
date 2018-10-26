<?php

namespace app\admin\model;

use think\Model;

class Settings extends Model {

    protected $pk = 'name';
    protected $type = [
        'info' => 'serialize', //指定为序列化类型的话，数据会自动序列化写入，并且在读取的时候自动反序列化。
    ];

    /**
     * 获取信息
     * @return array 
     */
    public function getSiteSetting() {
        $info = $this->get("Sitesetting");
        return $info['info'];
    }

    /**
     * 写入信息
     * @return true 
     */
    public function saveSiteSettings($data) {
        //$this->where('name', 'Sitesetting')->update(['info' => $data]);
        $info = $this->get("Sitesetting");
        $info->info = $data;
        $info->save();
        return true;
    }
    
    /**
     * 获取上传设置信息
     * @return array 
     */
    public function getUploadSetting() {
        $info = $this->get("uploadsetting");
        return $info['info'];
    }

}
