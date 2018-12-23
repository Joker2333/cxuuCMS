<?php

//注册路由

Route::get('content/:id', 'index/info/index/')->ext('html');
Route::get('channel/:channelval', 'index/infolist/index/')->ext('html');
Route::get('doc', 'index/Doclist/index/')->ext('html');
Route::get('documents/:id', 'index/doc/index/')->ext('html');
Route::get('documents/signInAction/:id', 'index/doc/signInAction/')->ext('html');
Route::get('musiclist', 'index/Musiclist/index/')->ext('html');
Route::get('music/:id', 'index/music/index/')->ext('html');
Route::get('/', 'index/index');

Route::get('CXUU', function () {
    return 'hello,CXUU!';
});

