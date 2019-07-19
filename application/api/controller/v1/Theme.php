<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：主题
 * Date：2019/7/12
 * Time：23:13
 * 努力前行！
 */

namespace app\api\controller\v1;

use app\api\model\Theme as ThemeModel;
use app\api\validate\IDCollection;
use app\api\validate\IDMustBePostiveInt;

class Theme
{
    public function getTList($ids){
        (new IDCollection())->goCheck();
        $result = ThemeModel::getSimpleList($ids);
        return $result;
    }

    public function getComplexOne($id){
        (new IDMustBePostiveInt())->goCheck();
        $result = ThemeModel::getThemeWithProducts($id);
        return $result;
    }

}