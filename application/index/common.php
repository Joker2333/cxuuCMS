<?php
/**
 * AJAX  返回响应
 * $msg string
 * $result bool  0  1
 * $url    string
 * * */
function ajax_Jsonreport($msg, $result, $url = null) {
    return json_encode(array('msg' => $msg, 'result' => $result, 'url' => $url));
}



