<?php

//注册路由

/* Route::rule('content/:id', 'index/info/index/')->ext('html');
Route::rule('channel/:channelval', 'index/infolist/index/')->ext('html');
Route::rule('/', 'index/index'); */

Route::get('CXUU', function () {
    return 'hello,CXUU!';
});


return [
    '/'=>'index/index',
    'content/:id'=>'index/Info/index/',
    'channel/:channelval'=>'index/infolist/index/',
];