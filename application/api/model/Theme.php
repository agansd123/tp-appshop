<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：
 * Date：2019/7/12
 * Time：22:43
 * 努力前行！
 */

namespace app\api\model;

use app\lib\exception\ThemeException;

class Theme extends BaseModel
{
    protected $hidden = ['topic_img_id','delete_time','head_img_id','update_time'];

    public function topicImg(){
        return $this->belongsTo('Image','topic_img_id','id');
    }

    public function headImg(){
        return $this->belongsTo('Image','head_img_id','id');
    }

    public function products(){
        //参数:模型，中间表名,外键名，当前模型的关联键名
        return $this->belongsToMany('Product','theme_product','product_id','theme_id');
    }

    public static function getSimpleList($ids = ''){
        $ids = explode(',',$ids);
        $result = self::with(['topicImg','headImg'])->select($ids);
        if ($result->isEmpty()){
            throw new ThemeException();
        }
        return $result;
    }

    public static function getThemeWithProducts($id){
        $result = self::with(['products','topicImg','headImg'])->find($id);
        if (!$result){
            throw new ThemeException();
        }
        return $result;
    }
}