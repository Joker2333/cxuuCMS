<?php
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