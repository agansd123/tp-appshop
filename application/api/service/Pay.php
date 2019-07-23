<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：支付服务
 * Date：2019/7/22
 * Time：17:06
 * 努力前行！
 */

namespace app\api\service;


use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenGetException;
use think\Exception;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');

class Pay
{
    private $orderID;
    private $orderNO;

    function __construct($orderID)
    {
        if (!$orderID){
            throw new Exception('订单号不允许为NULL');
        }
        $this->orderID = $orderID;
    }

    /**
     * @return array|\成功时返回，其他抛异常
     * @throws OrderException
     * @throws TokenGetException
     */
    public function pay(){
        $this->checkOrderValid();
        $orderSerevice = new OrderService();
        $status = $orderSerevice->checkOrderStock($this->orderID);
        if (!$status['pass']){
            return $status;
        }
        return $this->makeWxPreOrder($status['orderPrice']);
    }

    /**
     * 微信预订单生成
     */
    private function makeWxPreOrder($totalPrice){
        $openid = Token::getCurrentTokenVar('openid');
        if (!$openid){
            throw new TokenGetException();
        }
        //调用统一下单输入对象
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNO);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice*100);
        $wxOrderData->SetBody('测试订单');
        $wxOrderData->SetOpenid($openid);
        $result = $this->getPaySignature($wxOrderData);
        return $result;
    }

    /**
     * 微信统一下单接口
     * 获取支付签名
     */
    private function getPaySignature($wxOrderData){
        $wxConfig = new \WxPayConfig();
        $wxOrder = \WxPayApi::unifiedOrder($wxConfig,$wxOrderData);
        if ($wxOrder['return_code'] != 'SUCCESS' ||
            $wxOrder['result_code'] != 'SUCCESS'){
            Log::record($wxOrder,'error');
            Log::record('获取预支付订单失败','error');
        }

        $this->recordPreOrder($wxOrder);
        $signature = $this->sign($wxOrder);
        return $signature;
    }

    //签名
    private function sign($wxOrder){
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.appid'));
        $jsApiPayData->SetTimeStamp((String)time());
        $rand = md5(time().mt_rand(0,1000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id='.$wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');
        $sign = $jsApiPayData->MakeSign();
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;
        unset($rawValues['appId']);
        return $rawValues;
    }

    private function recordPreOrder($wxOrder){
        $prePayID = $wxOrder['prepay_id'];
        OrderModel::where('id','=',$this->orderID)->update(['prepay_id' =>$prePayID ]);
    }

    /**
     * 检测订单是否有效
     * @throws OrderException
     */
    private function checkOrderValid(){
        //订单是否存在
        $order = OrderModel::where('id','=',$this->orderID)->find();
        if (!$order){
            throw new OrderException();
        }

        //会员与订单是否匹配
        if (!Token::isValidOperate($order->user_id) ){
            throw new TokenGetException([
                'msg' => '订单与用户不匹配',
                'errorCode' => 10003
            ]);
        }

        //订单是否支付
        if ($order->status != OrderStatusEnum::UNPAID){
            throw new OrderException([
                'msg' => '订单状态异常',
                'errorCode' => 80003,
                'code' => 400
            ]);
        }

        $this->orderNO = $order->order_no;
        return true;
    }
}