<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：商品二维数组验证（购物车提交）
 * Date：2019/7/21
 * Time：10:15
 * 努力前行！
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{
    protected $rule = [
        'products' => 'require|checkProducts'
    ];

    protected $singleRule = [
        'product_id' => 'require|isPositiveInteger',
        'count' => 'require|isPositiveInteger'
    ];

    /**
     * 验证二维数组商品参数
     * @param $values
     * @return bool
     * @throws ParameterException
     */
    protected function checkProducts($values){
        if (!is_array($values)){
            throw new ParameterException(['msg' => '商品参数不正确']);
        }

        if (empty($values)){
            throw new ParameterException(['msg' => '商品列表不能为空']);
        }

        foreach ($values as $value){
            $this->checkProduct($value);
        }
        return true;
    }

    /**
     * 验证当前节点商品参数
     * @param $value
     * @throws ParameterException
     */
    protected function checkProduct($value){
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->check($value);

        if (!$result){
            throw new ParameterException(['msg' =>'商品列表参数错误']);
        }
    }
}