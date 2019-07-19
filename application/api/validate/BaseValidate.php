<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Data：验证器基类
 * Time：0:42
 * 努力前行！
 */

namespace app\api\validate;

use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck(){
        $request = Request::instance();
        $params = $request->param();
        $result = $this->batch()->check($params);
        if (!$result){
            $e = new ParameterException([
                'msg' =>  $this->error
            ]);
            throw $e;
        }
        else{
            return true;
        }
    }

    /**
     * 根据验证规则获取指定的数据
     * @param $arrays
     * @return array
     * @throws ParameterException
     */
    public function getDataByRule($arrays){
        if (array_key_exists('user_id',$arrays) || array_key_exists('uid',$arrays) ){
            throw new ParameterException([
                'msg' => '参数值包含非法的参数名user_id或者uid'
            ]);
        }
        $newArray = [];
        foreach ($this->rule as $key =>$value){
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }


    /**
     * 自定义正整数验证
     * @param $value
     * @param string $rule 嵌套验证路由
     * @param string $data
     * @param string $field  验证字段
     * @return bool|string
     */
    protected function isPositiveInteger($value, $rule = '', $data = '', $field = ''){
        if (is_numeric($value) && is_int($value + 0) && ($value+0) > 0 ){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * 验证ids组，以逗号分割的多个正整数
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool
     */
    protected function checkIDs($value, $rule = '', $data = '', $field = ''){
        $values = explode(',',$value);
        if (empty($values)){
            return false;
        }
        foreach ($values as $id){
            if (!$this->isPositiveInteger($id)){
                return false;
            }
        }
        return true;
    }

    protected function isNotEmpty($value, $rule = '', $data = '', $field = ''){
        if (empty($value)){
            return false;
        }else{
            return true;
        }
    }

    protected function isMobile($value){
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule,$value);
        if ($result){
            return true;
        }else{
            return false;
        }
    }
}