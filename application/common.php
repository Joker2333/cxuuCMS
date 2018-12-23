<?php
/**
 * 常量定义
 */
const CXUUCMSVER = 'V1.4.2 LTS(长期支持版本)-20181223';

/**
 * 页面不存在
 */
function error404()
{
    header('Content-type: text/html; charset=UTF-8');
    echo '<head>';
    echo '<title>龙啸轩网站信息管理系统</title>';
    echo '</head>';
    echo '<body>';
    echo '<style>#notice {margin: auto;width:600px;height:80px;border: #c6edfd solid 2px;padding: 20px;margin-top: 20px;font-size: 16px;color: #656565;line-height: 30px;text-align: center;}</style>';
    echo '<div id="notice">你所请求的页面不存在!!</div>';
    echo '</body>';
    exit;
}

/**
 * 验证错误返回响应
 * $words string
 * * */
function validateError($words)
{
    header('Content-type: text/html; charset=UTF-8');
    echo '<head>';
    echo '<title>龙啸轩网站信息管理系统</title>';
    echo '</head>';
    echo '<style>#notice {margin:auto;width:600px;height:60px;border: #c6edfd solid 2px;padding: 20px;font-size: 16px;color: #656565;line-height: 30px;text-align: center;}</style>';
    echo '<body>';
    echo '<div id="notice">' . $words . '</div>';
    echo '</body>';
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


/**
 * 格式化时间显示
 * $time string 时间戳
 * $type number
 * $date 时间格式
 * 主页自定义标签用法 {$vo.time|format_time=2}
 * */
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


/**
 * 定义获取COOKIE值
 * * */
function getCxuuCookie()
{
    $userInfo = unserialize(decrypt(Cookie::get('cxuu_admin_user')));
    return $userInfo;
}

/**
 * 定义获取COOKIE  userId
 * * */
function getCxuuUserId()
{
    $userInfo = getCxuuCookie();
    $userId = $userInfo['user_id'];
    return $userId;
}

/**
 * 定义获取COOKIE  group_id
 * * */
function getCxuuGroupId()
{
    $userInfo = getCxuuCookie();
    $GroupId = $userInfo['group_id'];
    return $GroupId;
}


/**
 * 加密函数  用于COOKIE
 * @param string $txt 需要加密的字符串
 * @param string $key 密钥
 * @return string 返回加密结果
 */
function encrypt($txt, $key = 'cxuu_dzh')
{
    if (empty($txt))
        return $txt;
    if (empty($key))
        $key = md5(cxuu_dzh);
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
    $ikey = "-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
    $nh1 = rand(0, 64);
    $nh2 = rand(0, 64);
    $nh3 = rand(0, 64);
    $ch1 = $chars{$nh1};
    $ch2 = $chars{$nh2};
    $ch3 = $chars{$nh3};
    $nhnum = $nh1 + $nh2 + $nh3;
    $knum = 0;
    $i = 0;
    while (isset($key{$i}))
        $knum += ord($key{$i++});
    $mdKey = substr(md5(md5(md5($key . $ch1) . $ch2 . $ikey) . $ch3), $nhnum % 8, $knum % 8 + 16);
    $txt = base64_encode(time() . '_' . $txt);
    $txt = str_replace(array('+', '/', '='), array('-', '_', '.'), $txt);
    $tmp = '';
    $j = 0;
    $k = 0;
    $tlen = strlen($txt);
    $klen = strlen($mdKey);
    for ($i = 0; $i < $tlen; $i++) {
        $k = $k == $klen ? 0 : $k;
        $j = ($nhnum + strpos($chars, $txt{$i}) + ord($mdKey{$k++})) % 64;
        $tmp .= $chars{$j};
    }
    $tmplen = strlen($tmp);
    $tmp = substr_replace($tmp, $ch3, $nh2 % ++$tmplen, 0);
    $tmp = substr_replace($tmp, $ch2, $nh1 % ++$tmplen, 0);
    $tmp = substr_replace($tmp, $ch1, $knum % ++$tmplen, 0);
    return $tmp;
}

/**
 * 解密函数
 * @param string $txt 需要解密的字符串
 * @param string $key 密匙
 * @return string 字符串类型的返回结果
 */
function decrypt($txt, $key = 'cxuu_dzh', $ttl = 0)
{
    if (empty($txt))
        return $txt;
    if (empty($key))
        $key = md5(cxuu_dzh);
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
    $ikey = "-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
    $knum = 0;
    $i = 0;
    $tlen = @strlen($txt);
    while (isset($key{$i}))
        $knum += ord($key{$i++});
    $ch1 = @$txt{$knum % $tlen};
    $nh1 = strpos($chars, $ch1);
    $txt = @substr_replace($txt, '', $knum % $tlen--, 1);
    $ch2 = @$txt{$nh1 % $tlen};
    $nh2 = @strpos($chars, $ch2);
    $txt = @substr_replace($txt, '', $nh1 % $tlen--, 1);
    $ch3 = @$txt{$nh2 % $tlen};
    $nh3 = @strpos($chars, $ch3);
    $txt = @substr_replace($txt, '', $nh2 % $tlen--, 1);
    $nhnum = $nh1 + $nh2 + $nh3;
    $mdKey = substr(md5(md5(md5($key . $ch1) . $ch2 . $ikey) . $ch3), $nhnum % 8, $knum % 8 + 16);
    $tmp = '';
    $j = 0;
    $k = 0;
    $tlen = @strlen($txt);
    $klen = @strlen($mdKey);
    for ($i = 0; $i < $tlen; $i++) {
        $k = $k == $klen ? 0 : $k;
        $j = strpos($chars, $txt{$i}) - $nhnum - ord($mdKey{$k++});
        while ($j < 0)
            $j += 64;
        $tmp .= $chars{$j};
    }
    $tmp = str_replace(array('-', '_', '.'), array('+', '/', '='), $tmp);
    $tmp = trim(base64_decode($tmp));
    if (preg_match("/\d{10}_/s", substr($tmp, 0, 11))) {
        if ($ttl > 0 && (time() - substr($tmp, 0, 11) > $ttl)) {
            $tmp = null;
        } else {
            $tmp = substr($tmp, 11);
        }
    }
    return $tmp;
}

