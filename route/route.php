<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// Route::get('think', function () {
//     return 'hello,ThinkPHP5!';
// });
// Route::get('hello/:name', 'index/hello');
Route::get('/', 'index/index/index');
Route::get('/data', 'index/data/index');
Route::rule('/add','index/data/add');
Route::rule('/del','index/data/del');
Route::rule('/edit','index/data/edit');
Route::rule('/update','index/data/update');
Route::rule('/up','index/data/up');
Route::rule('/upload','index/data/upload');
//访问 http://vue1/index.php/new
Route::rule('/register','index/index/register');
//登录
Route::rule('/login','index/index/login');
//apipost测试
Route::rule('ceshi','index/index/ceshi');
Route::rule('yuyin','index/index/yuyin');
//token
Route::rule('token','index/index/crate_token');
//验证token
Route::rule('verifyToken','index/index/verify_token');
//支付
Route::rule('/pay','index/pay/pay_order');
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");
//……
return [

];
