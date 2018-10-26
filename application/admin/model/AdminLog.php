<?php

namespace app\admin\model;

use think\Model;

class AdminLog extends Model {

    protected $pk = 'log_id';

    // 模型初始化
    protected static function init() {
        //TODO:初始化内容
    }

    /**
     * 获取数量
     * @return int 数量
     */
    public function countList() {
        return $this->count();
    }

    public function addData($time, $username, $ip, $app, $content) {

        $data_log = [
            'time' => $time,
            'username' => $username,
            'ip' => $ip,
            'app' => $app,
            'content' => $content
        ];

        if (empty($data_log)) {
            return false;
        }
        //只保留5000条数据
        $count = $this->countList();
        if ($count > 5000) {
            $this->where('log_id <> 0')->order('log_id asc')->limit('1')->delete();
        }
        //增加记录
        $this->save($data_log);
    }

}
