<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：订单状态枚举
 * Date：2019/7/22
 * Time：18:15
 * 努力前行！
 */

namespace app\lib\enum;


class OrderStatusEnum
{
    //待支付
    const UNPAID = 1;

    //已支付
    const PAID = 2;

    // 已发货
    const DELIVERED = 3;

    //已支付，但库存量不足
    const PAID_BUT_OUT_OF = 4;

}