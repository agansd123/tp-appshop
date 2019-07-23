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
use app\api\service\Order as OrderService;

class Order extends BaseModel
{
    protected $hidden = ['user_id','delete_time','update_time'];

    public static function getSummaryByUser($uid,$page=1,$size=15){
        $pagingData = self::where('user_id','=',$uid)
            ->order('create_time desc')
            ->paginate($size,true,['page' => $page]);
        return $pagingData;
    }

    protected function getSnapAddressAttr($value){
        return  OrderService::getSnapAddress($value);
    }

    protected function getSnapItemsAttr($value){
        if (!$value){
            return null;
        }
        return json_decode($value,true);
    }
}