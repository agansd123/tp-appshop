<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：商品
 * Date：2019/7/14
 * Time：22:01
 * 努力前行！
 */

namespace app\api\model;


use app\lib\exception\ProductException;

class Product extends BaseModel
{
    protected $hidden = ['delete_time','category_id','from','create_time','update_time','img_id','pivot'];

    protected function getMainImgUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }

    public function imgs(){
        return $this->hasMany('ProductImage','product_id','id');
    }

    public function properties(){
        return $this->hasMany('ProductProperty','product_id','id');
    }

    public static function getMostRecent($count){
        $product = self::limit($count)
            ->order('create_time desc')
            ->select();
        if ($product->isEmpty()){
            throw new ProductException();
        }
        return $product;
    }

    public static function getProductsByCategoryID($categoryID){
        $products = self::where('category_id','=',$categoryID)->select();
        if ( $products->isEmpty()){
            throw new ProductException();
        }
        return $products;
    }

    public static function getProductDetail($id){
        $product = self::with([
            'imgs' => function($query){
                $query->with(['imgUrl'])->order('order','asc');
            }
        ])->with(['properties'])->find($id);
        if (!$product){
            throw new ProductException();
        }
        return $product;
    }
}