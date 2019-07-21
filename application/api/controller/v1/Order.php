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

use app\api\validate\OrderPlace;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeorder'] //方法名称不可使用大写,字母对应即可
    ];


    public function placeOrder(){
        (new OrderPlace())->goCheck();

        $product = input('post.products/a');
        $uid = TokenService::getCurrentTokenVar('uid');

        $order = new OrderService();
        $status = $order->place($uid,$product);
        return $status;
    }
}