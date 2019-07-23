<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：处理微信支付回调
 * Date：2019/7/23
 * Time：13:13
 * 努力前行！
 */

namespace app\api\service;


use app\api\model\Order;
use app\api\model\Product;
use app\api\service\Order as OrderService;
use app\lib\enum\OrderStatusEnum;
use think\Db;
use think\Exception;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');


class WxNotify extends \WxPayNotify
{
    public function NotifyProcess($data, $config, &$msg)
    {
        if ($data['result_code'] == 'SUCCESS') {
            $orderNo = $data['out_trade_no'];
            Db::startTrans();
            try {
                $order = Order::where('order_no', '=', $orderNo)->lock(true)->find();
                if ($order->status == 1) {
                    $service = new OrderService();
                    $status = $service->checkOrderStock($order->id);
                    if ($status['pass']) {
                        $this->updateOrderStatus($order->id, true);
                        $this->reduceStock($status);
                    } else {
                        $this->updateOrderStatus($order->id, false);
                    }
                }
                Db::commit();
            } catch (Exception $ex) {
                Db::rollback();
                Log::error($ex);
                // 如果出现异常，向微信返回false，请求重新发送通知
                return false;
            }
        }
        return true;
    }

    //削减库存量
    private function reduceStock($status)
    {
        foreach ($status['pStatusArray'] as $singlePStatus) {
            Product::where('id', '=', $singlePStatus['id'])->setDec('stock', $singlePStatus['count']);
        }
    }

    //更新订单状态
    private function updateOrderStatus($orderID, $success)
    {
        $status = $success ? OrderStatusEnum::PAID : OrderStatusEnum::PAID_BUT_OUT_OF;
        Order::where('id', '=', $orderID)->update(['status' => $status]);
    }
}