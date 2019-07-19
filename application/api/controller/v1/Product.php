<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：商品
 * Date：2019/7/15
 * Time：0:02
 * 努力前行！
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\api\validate\IDMustBePostiveInt;

class Product
{
    public function getRecent($count = 15){
        (new Count())->goCheck();
        $result = ProductModel::getMostRecent($count);
        $result->hidden(['summary']);
        return $result;
    }

    public function getAllInCategory($id){
        (new IDMustBePostiveInt())->goCheck();
        $result = ProductModel::getProductsByCategoryID($id);
        $result->hidden(['summary']);
        return $result;
    }

    public function getOne($id){
        (new IDMustBePostiveInt())->goCheck();
        $result = ProductModel::getProductDetail($id);
        return $result;
    }
}