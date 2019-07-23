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

use app\api\validate\IDMustBePostiveInt;
use app\api\validate\OrderPlace;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\api\validate\PagingParameter;
use app\lib\exception\OrderException;

class Order extends BaseController
{

    /**
     * 创建预支付订单
     * @return array
     * @throws \app\lib\exception\ParameterException
     * @throws \app\lib\exception\TokenGetException
     * @throws \think\Exception
     */
    public function placeOrder(){
        (new OrderPlace())->goCheck();

        $product = input('post.products/a');
        $uid = TokenService::getCurrentTokenVar('uid');

        $order = new OrderService();
        $status = $order->place($uid,$product);
        return $status;
    }

    //返回订单列表
    public function getSummaryByUser($page=1,$size=15){
        (new PagingParameter())->goCheck();
        $uid = TokenService::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByUser($uid,$page,$size);
        if ($pagingOrders->isEmpty()){
            return [
                'data' => [],
                'current_page' => $pagingOrders->getCurrentPage()
            ];
        }

        $data = $pagingOrders->hidden(['prepay_id','snap_address','snap_items'])->toArray();
        return [
          'data' => $data,
          'current_page' => $pagingOrders->getCurrentPage()
        ];
    }

    //获取订单详情
    public function getDetail($id){
        (new IDMustBePostiveInt())->goCheck();
        $order = OrderModel::get($id);
        if (!$order){
            throw new OrderException();
        }
        return $order->hidden(['prepay_id']);
    }

}