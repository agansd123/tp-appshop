<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：支付接口
 * Date：2019/7/22
 * Time：12:43
 * 努力前行！
 */

namespace app\api\controller\v1;


use app\api\service\WxNotify;
use app\api\validate\IDMustBePostiveInt;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{
    public function getPreOrder($id =''){
        (new IDMustBePostiveInt())->goCheck();
        $pay = new PayService($id);
        $result =  $pay->pay();
        return $result;
    }

    //支付后处理回调
    public function receiveNotify(){
        $notify = new WxNotify();
        $notify->Handle();
    }
}