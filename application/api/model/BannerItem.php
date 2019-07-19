<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：
 * Date：2019/7/10
 * Time：17:58
 * 努力前行！
 */

namespace app\api\model;


class BannerItem extends BaseModel
{
    protected $hidden = ['delete_time','update_time','banner_id','img_id','id'];

    public function itemImage(){
        return $this->belongsTo('Image','img_id','id');
    }
}