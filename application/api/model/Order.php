<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：订单模型
 * Date：2019/7/19
 * Time：9:54
 * 努力前行！
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id','delete_time','update_time'];
}