<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：
 * Date：2019/7/10
 * Time：18:13
 * 努力前行！
 */

namespace app\api\model;


class Image extends BaseModel
{
    protected $hidden = ['delete_time','update_time','from','id'];

    /**
     * 获取器，获取数据的字段值后自动进行处理 不可定义私有方法
     * https://www.kancloud.cn/manual/thinkphp5/135192
     * 格式：get+字段+Attr
     * @param $value
     * @return string
     */
    protected function getUrlAttr($value,$data){
       return self::prefixImgUrl($value,$data);
    }
}