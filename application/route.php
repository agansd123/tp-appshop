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

use think\Route;

//模块名，控制器名，方法名
Route::get('api/:version/banner/:id','api/:version.Banner/getBanner'); //获取Banner

Route::get('api/:version/theme','api/:version.Theme/getTList');  //获取专题
Route::get('api/:version/theme/:id','api/:version.Theme/getComplexOne');  //获取专题详情

Route::get('api/:version/category/all','api/:version.Category/getAllCategories');  //分类

Route::group('api/:version/product',function (){
    Route::get('/recent','api/:version.Product/getRecent');  //最近新品
    Route::get('/by_category','api/:version.Product/getAllInCategory');  //分类商品
    Route::get('/:id','api/:version.Product/getOne',[],['id'=>'\d+']);  //获取商品详情
});

Route::post('api/:version/token/user','api/:version.Token/getToken');  //获取token

Route::post('api/:version/address','api/:version.Address/createOrUpdateAddress');  //获取token