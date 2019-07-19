<?php

namespace app\api\controller\v1;


use app\api\validate\IDMustBePostiveInt;
use app\api\model\Banner as BannerModel;

class Banner
{
    /**
     * 获取banner轮播图url
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \app\lib\exception\BannerMissException
     * @throws \app\lib\exception\ParameterException
     */
    public function getBanner($id){
        //AOP 面向切面编程
        (new IDMustBePostiveInt())->goCheck();
        $banner = BannerModel::getBannerByID($id);
        return $banner;
    }
}