<?php
/**
 * 页面不存在
 * @return array 页面信息
 */
function error404()
{
    header('Content-type: text/html; charset=UTF-8');
    echo '<center>你所请求的页面不存在!!</center>';
    exit;
}

/**
 * 验证错误返回响应
 * $words string
 * * */
function validateError($words)
{
    header('Content-type: text/html; charset=UTF-8');
    echo '<center>' . $words . '请返回！</center>';
    exit;
}

//网站配置信息 获取方法
function siteSettings($name = '')
{
    if (Cache::get("SiteConfig")) {
        $cache = Cache::get("SiteConfig"); //如果有缓存则在缓存中读取数据 
    } else {
        $cache = Db::table('cxuu_settings')->where('name', 'sitesetting')->find();
        Cache::set("SiteConfig", $cache, 500); //没有缓存则链接数据表获取数据并写入缓存 
    }
    $stiteSettings = unserialize($cache['info']);
    if (empty($name)) {
        return $stiteSettings;
    } else {
        return $stiteSettings[$name];
    }

}

/**
 * 截取字符
 * $title string
 * $first number
 * $end   number
 * 主页自定义标签用法 {$vo.title|mbStr=0,12}
 * */
function mbStr($title, $first, $end)
{
    if (mb_strlen($title, 'utf8') > $end -= $first) {
        $tit = mb_substr($title, $first, $end, 'utf8') . "..";
    } else {
        $tit = $title;
    }
    return $tit;
}

//格式化时间显示
function format_time($time, $type = 1, $date = 'Y-m-d H:i:s')
{
    if (is_numeric($type)) {
        switch ($type) {
            case 1:
                return date($date, $time);
                break;
            case 2:
                $d = time() - $time;
                if ($d < 0) {
                    return date($date, $time);
                }
                if ($d < 60) {
                    return $d . '秒前';
                } else {
                    if ($d < 3600) {
                        return floor($d / 60) . '分钟前';
                    } else {
                        if ($d < 86400) {
                            return floor($d / 3600) . '小时前';
                        } else {
                            if ($d < 259200) {
                                return floor($d / 86400) . '天前';
                            } else {
                                return date($date, $time);
                            }
                        }
                    }
                }
                break;
        }
    } else {
        return date($type, $time);
    }
}


