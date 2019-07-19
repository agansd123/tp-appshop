<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：ORM模型基类
 * Date：2019/7/10
 * Time：19:41
 * 努力前行！
 */

namespace app\api\model;


use think\Model;

class BaseModel extends Model
{
    /**
     * imagesUrl获取器响应方法
     * @param $value
     * @return string
     */
    protected function prefixImgUrl($value,$data){
        $finalUrl = $value;
        if ($data['from'] == 1){
            $finalUrl =  config('setting.img_prefix').$value;
        }
        return $finalUrl;
    }
}