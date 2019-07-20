<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：订单
 * Date：2019/7/19
 * Time：9:53
 * 努力前行！
 */

namespace app\api\controller\v1;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeorder'] //方法名称不可使用大写,字母对应即可
    ];


    public function placeOrder(){

    }
}