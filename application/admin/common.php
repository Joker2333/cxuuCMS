<?php

/**
 * 定义获取COOKIE值
 * * */
function getCxuuCookie()
{
    $userinfo = unserialize(decrypt(Cookie::get('cxuu_admin_user')));
    return $userinfo;
}

/**
 * 定义获取COOKIE  userId
 * * */
function getCxuuUserId()
{
    $userinfo = getCxuuCookie();
    $userId = $userinfo['user_id'];
    return $userId;
}

/**
 * 定义获取COOKIE  group_id
 * * */
function getCxuuGroupId()
{
    $userinfo = getCxuuCookie();
    $GroupId = $userinfo['group_id'];
    return $GroupId;
}

/**
 * 获取用户栏目权限
 * * */
function getCxuuChannelAuth()
{
    $userinfo = getCxuuCookie();
    $userChannelAuth = $userinfo['channel_purview'];
    return $userChannelAuth;
}

/**
 * 用户操作权限检查
 * * */
function getCxuuBaseAuth($auth)
{
    $userinfo = getCxuuCookie();
    if ($userinfo['group_id'] == 1) {
        //超级管理员不受限制
        $userAuth = 1;
    } else {
        $userBaseAuth = $userinfo['base_purview'];
        /* 		foreach ($userBaseAuth as &$item) {
                    $item = strtolower($item); //递归转换成小写
                } */
        in_array($auth, $userBaseAuth) ? $userAuth = 1 : $userAuth = 0;
    }
    return $userAuth;
}

/**
 * AJAX  返回响应
 * $msg string
 * $result bool  0  1
 * $url    string
 * * */
function ajax_Jsonreport($msg, $result, $url = null)
{
    return json_encode(array('msg' => $msg, 'result' => $result, 'url' => $url));
}


/**
 * 生成唯一数字
 */
function unique_number()
{
    return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

/**
 * 生成随机字符串
 */
function random_str()
{
    $year_code = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
    $order_sn = $year_code[intval(date('Y')) - 2010] .
        strtoupper(dechex(date('m'))) . date('d') .
        substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('d', rand(0, 99));
    return $order_sn;
}

/**
 * 删除指定路径文件
 * @param string $file
 * @return int
 */
function del_file($file)
{
    if (!file_exists($file)) {
        return 0; //文件不存在
    }
    if (!unlink($file)) {
        return 2; ///"文件删除成功"
    } else {
        return 1; ///"文件删除不成功，请检查权限"
    }

//            switch (del_file("." . $delfilename)) {
//            case 0 :
//                return ajax_Jsonreport("要删除的文件不存在",0);
//            case 1:
//                Attachments::destroy($delId);
//                 return ajax_Jsonreport("文件删除成功",1);
//            case 2:
//                 return ajax_Jsonreport("文件删除不成功，请检查权限",0);
//            default :
//                 return ajax_Jsonreport("删除失败",0);
//        }
}


/**
 * 获取目录下文件列表
 * @param string $dir 路径
 */
//递归方式
function read_dir($dir)
{
    $files = array();
    $dir_list = scandir($dir);
    foreach ($dir_list as $file) {
        if ($file != '..' && $file != '.') {
            if (is_dir($dir . '/' . $file)) {
                $files[] = read_dir($dir . '/' . $file);
            } else {
                $files[] = $file;
            }
        }
    }
    return $files;
}

/**
 * 获取文件或文件大小   字节
 * @param string $directoty 路径
 * @return int
 */
function dir_size($directoty)
{
    $dir_size = 0;
    if ($dir_handle = @opendir($directoty)) {
        while ($filename = readdir($dir_handle)) {
            $subFile = $directoty . DIRECTORY_SEPARATOR . $filename;
            if ($filename == '.' || $filename == '..') {
                continue;
            } elseif (is_dir($subFile)) {
                $dir_size += dir_size($subFile);
            } elseif (is_file($subFile)) {
                $dir_size += filesize($subFile);
            }
        }
        closedir($dir_handle);
    }
    return ($dir_size);
}

/**
 * 遍历删除目录和目录下所有文件
 * @param string $dir 路径
 * @return bool
 */
function del_dir($dir)
{
    if (!is_dir($dir)) {
        return false;
    }
    $handle = opendir($dir);
    while (($file = readdir($handle)) !== false) {
        if ($file != "." && $file != "..") {
            is_dir("$dir/$file") ? del_dir("$dir/$file") : @unlink("$dir/$file");
        }
    }
    if (readdir($handle) == false) {
        closedir($handle);
        @rmdir($dir);
    }
    return true;
}

/**
 * 字符串转布尔
 * @param string $directoty 路径
 * @return bool
 */
function string_to_bool($val)
{
    switch ($val) {
        case 'true':
            return true;
            break;
        case 'false':
            return false;
            break;

        default:
            return $val;
            break;
    }
}

/**
 * 获取IP  暂无使用
 * @return string 字符串类型的返回结果
 */
function getIp()
{
    if (@$_SERVER['HTTP_CLIENT_IP'] && $_SERVER['HTTP_CLIENT_IP'] != 'unknown') {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (@$_SERVER['HTTP_X_FORWARDED_FOR'] && $_SERVER['HTTP_X_FORWARDED_FOR'] != 'unknown') {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return preg_match('/^\d[\d.]+\d$/', $ip) ? $ip : '';
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
