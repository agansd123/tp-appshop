<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Data：2019/7/9
 * Time：16:59
 * 努力前行！
 */

namespace app\api\model;

use app\lib\exception\BannerMissException;

class Banner extends BaseModel
{
    protected $hidden = ['delete_time','update_time'];

    public function bannerItem(){
        //参数：关联模型  外键  当前模型主键
        return $this->hasMany('BannerItem','banner_id','id');
    }

    public static function getBannerByID($id){
        $banner = self::with(['bannerItem','bannerItem.itemImage'])->find($id);
        if (!$banner){
            throw new BannerMissException();
        }
        return $banner;
    }

}