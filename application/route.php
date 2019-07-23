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

Route::group('api/:version',function (){
    Route::post('/token/user','api/:version.Token/getToken');  //获取普通会员token
    Route::post('/pay/notify','api/:version.Pay/receiveNotify');  //处理微信支付回调业务
    Route::get('/banner/:id','api/:version.Banner/getBanner'); //获取Banner
    Route::get('/theme','api/:version.Theme/getTList');  //获取专题
    Route::get('/theme/:id','api/:version.Theme/getComplexOne');  //获取专题详情
    Route::get('/category/all','api/:version.Category/getAllCategories');  //分类

    Route::group('/product',function (){
        Route::get('/recent','api/:version.Product/getRecent');  //最近新品
        Route::get('/by_category','api/:version.Product/getAllInCategory');  //分类商品
        Route::get('/:id','api/:version.Product/getOne',[],['id'=>'\d+']);  //获取商品详情
    });

});


//填写收货地址
Route::post('api/:version/address','api/:version.Address/createOrUpdateAddress',[
    'before_behavior'=>'\app\api\behavior\NeedPrimaryScope'
]);

//下单
Route::post('api/:version/order','api/:version.Order/placeOrder',[
    'before_behavior'=>'\app\api\behavior\NeedPrimaryScope'
]);

//获取订单列表
Route::get('api/:version/order_list','api/:version.Order/getSummaryByUser',[
    'before_behavior'=>'\app\api\behavior\NeedPrimaryScope'
]);

//获取订单详情
Route::get('api/:version/order/:id','api/:version.Order/getDetail',[
    'before_behavior'=>'\app\api\behavior\NeedPrimaryScope'
],['id' =>'\d+']);

//获取预支付订单
Route::post('api/:version//pay/pre_order','api/:version.Pay/getPreOrder',[
    'before_behavior'=>'\app\api\behavior\NeedExclusiveScope'
]);














