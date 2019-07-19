<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：分类
 * Date：2019/7/15
 * Time：10:16
 * 努力前行！
 */

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;

class Category
{
    /**
     * 获取所有分类列表
     * @return CategoryModel[]|false
     * @throws CategoryException
     * @throws \think\exception\DbException
     */
    public function getAllCategories(){
        $categories = CategoryModel::all([],['topicImg']);
        if ($categories->isEmpty()){
            throw new CategoryException();
        }
        return $categories;
    }
}