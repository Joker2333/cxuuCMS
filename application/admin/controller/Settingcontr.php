<?php
namespace app\admin\controller;

use app\admin\model\Settings;

class Settingcontr extends \think\Controller {

    protected $middleware = ['Auth'];

    public function index() {
        if ($this->request->post('site_title')) {
            $model = new Settings;
            $settings = $model->getSiteSetting();
            /*             * 获取 POST数据 */
            $data = $this->request->post();
            $updata = array_merge($settings, $data); //合并数组
            if ($model->saveSiteSettings($updata)) {
                return ajax_Jsonreport("站点配置成功",1,"/admin/Settingcontr");
            }
            return ajax_Jsonreport("站点配置失败",0);
        } else {
            $model = new Settings;
            $settings = $model->getSiteSetting();
            $this->assign('setting', $settings);
            return $this->fetch();
        }
    }

}
